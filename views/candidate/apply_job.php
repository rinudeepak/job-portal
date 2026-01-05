<?php
session_start();
require_once "../../vendor/autoload.php";
require_once "../../models/db_connection/db.php";
require_once __DIR__ . '/../../config/github.php';

use Smalot\PdfParser\Parser;

require_once __DIR__ . '/../../controllers/skill_controller.php';
$skillController = new SkillController();

//Fetch candidate details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_btn'])) {

    $job_id = $_POST['job_id'];
    $candidate_id = $_SESSION['user_id'];



    $userQuery = mysqli_query($conn, "
        SELECT github_username 
        FROM users 
        WHERE id = $candidate_id
    ");
    $user = mysqli_fetch_assoc($userQuery);
    
    //Get resume path

    $resumeQuery = mysqli_query($conn, "
        SELECT file_path 
        FROM resumes 
        WHERE user_id = $candidate_id
    ");
    $resume = mysqli_fetch_assoc($resumeQuery);
    $resumePath = $resume['file_path'];

    //Get job required skills

    $jobQuery = mysqli_query($conn, "
        SELECT skills 
        FROM jobs 
        WHERE id = $job_id
    ");
    $job = mysqli_fetch_assoc($jobQuery);
    $jobSkillsArray = explode(',', strtolower($job['skills'] ?? ''));

   
    //Extract resume skills


    $matched = [];
    $resumeSkillsStr = '';

    if ($resumePath) {
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/job-portal/' . $resumePath;

        if ($fullPath && file_exists($fullPath)) {
            $parser = new Parser();
            $pdf = $parser->parseFile($fullPath);
            $text = strtolower($pdf->getText());

            foreach ($jobSkillsArray as $skill) {
                $skill = trim($skill);
                
                if ($skill && strpos($text, $skill) !== false) {
                    $matched[] = $skill;
                }
            }
            
            $resumeSkillsStr = implode(',', $matched);
        }
    }


    //Fetch GitHub data
    function fetchGitHubRepos($username) {
        $url = "https://api.github.com/users/$username/repos";

        // $opts = [
        //     "http" => [
        //         "method" => "GET",
        //         "header" => "User-Agent: JobPortal"
        //     ]
        // ];
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => [
                    "User-Agent: JobPortal",
                    "Authorization: token " . GITHUB_TOKEN
                ]
            ]
        ];


        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        return $response ? json_decode($response, true) : [];
    }
    
    function fetchRepoCommitCount($username, $repoName) {
        $url = "https://api.github.com/repos/$username/$repoName/commits?per_page=100";

        // $opts = [
        //     "http" => [
        //         "method" => "GET",
        //         "header" => "User-Agent: JobPortal"
        //     ]
        // ];
$opts = [
            "http" => [
                "method" => "GET",
                "header" => [
                    "User-Agent: JobPortal",
                    "Authorization: token " . GITHUB_TOKEN

                ]
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        if (!$response) return 0;

        $commits = json_decode($response, true);
        return count($commits);
    }

    function fetchRepoLanguages($username, $repoName) {
        $url = "https://api.github.com/repos/$username/$repoName/languages";

        // $opts = [
        //     "http" => [
        //         "method" => "GET",
        //         "header" => "User-Agent: JobPortal"
        //     ]
        // ];
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => [
                    "User-Agent: JobPortal",
                    "Authorization: token " . GITHUB_TOKEN

                ]
            ]
        ];

        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        if (!$response) return [];

        $languages = json_decode($response, true);
        return array_keys($languages); // only language names
    }

    function analyzeGitHubProfile($username) {

        $repos = fetchGitHubRepos($username);
        $repos = array_slice($repos, 0, 5); // limit repos

        $repoCount = count($repos);
        $totalCommits = 0;
        $allLanguages = [];

        foreach ($repos as $repo) {
            $repoName = $repo['name'];

            // commits
            $totalCommits += fetchRepoCommitCount($username, $repoName);

            // languages
            $languages = fetchRepoLanguages($username, $repoName);
            $allLanguages = array_merge($allLanguages, $languages);
        }

        return [
            'repos' => $repoCount,
            'commits' => $totalCommits,
            'languages' => array_unique($allLanguages)
        ];
    }

    $githubUsername = $user['github_username'];

    if (empty($githubUsername)) {
        $repoCount = 0;
        $commitCount = 0;
        $languages = '';
    } else {
        $githubData = analyzeGitHubProfile($githubUsername);
        $repoCount   = $githubData['repos'];
        

        $commitCount = $githubData['commits'];
        $languages   = implode(',', $githubData['languages']);
    }

    $skillScore = $skillController->calculateSkillScore(
        $matched,
        $repoCount,
        $commitCount
    );

    $status = ($skillScore >= 30) ? 'Shortlisted' : 'Applied';


        // Prevent duplicate applications
        $check = mysqli_query($conn,
            "SELECT id FROM applications WHERE job_id='$job_id' AND candidate_id='$candidate_id'"
        );

        if (mysqli_num_rows($check) > 0) {
            header("Location: jobs.php?msg=already_applied");
            exit;
        }

        $sql = "INSERT INTO applications (
            job_id,
            candidate_id,
            resume_skills,
            repositories,
            commits,
            languages,
            skill_score,
            status
        ) VALUES (
            '$job_id',
            '$candidate_id',
            '$resumeSkillsStr',
            '$repoCount',
            '$commitCount',
            '$languages',
            '$skillScore',
            '$status'
        )";

        if (mysqli_query($conn, $sql)) {
            header("Location: jobs.php?msg=applied");
        } else {
            header("Location: jobs.php?msg=error");
        }
}
