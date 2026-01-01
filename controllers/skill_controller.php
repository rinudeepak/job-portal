<?php



class SkillController {


    function fetchGitHubRepos($username) {
        if (!$username) return [];

        $url = "https://api.github.com/users/$username/repos";
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "User-Agent: JobPortal"
            ]
        ];
        $context = stream_context_create($opts);
        $response = @file_get_contents($url, false, $context);

        return $response ? json_decode($response, true) : [];
    }

    function extractSkillsFromResumeSimple($filePath, $jobSkills) {
        $resumeText = strtolower($filePath); 
        $skills = explode(',', strtolower($jobSkills));

        $matched = [];
        foreach ($skills as $skill) {
            if (strpos($resumeText, trim($skill)) !== false) {
                $matched[] = trim($skill);
            }
        }
        return $matched;
    }

    function calculateSkillScore($resumeSkills, $repoCount, $languages) {
        $score = 0;
        $score += count($resumeSkills) * 10;
        $score += $repoCount * 5;
        $score += count($languages) * 10;
        return $score;
    }

    function updateApplicationStatus($application_id, $skill_score, $conn) {
        if (!function_exists('getHiringStatusByScore')) {
            function getHiringStatusByScore($score) {
                if (!is_numeric($score)) return 'Applied';
                if ($score >= 85) return 'Selected';
                if ($score >= 70) return 'HR Checked';
                if ($score >= 50) return 'Technical Checked';
                if ($score >= 30) return 'Shortlisted';
                return 'Applied';
            }
        }

        $status = getHiringStatusByScore($skill_score);

        $stmt = $conn->prepare(
            "UPDATE applications 
            SET skill_score = ?, status = ? 
            WHERE id = ?"
        );

        $stmt->bind_param("isi", $skill_score, $status, $application_id);
        $stmt->execute();
    }


}
