<?php
session_start();
include "../../models/db_connection/db.php";
require_once '../../controllers/skill_controller.php';

$recruiter_id = $_SESSION['user_id'];

$sql = "SELECT a.*, u.name, u.email, j.title,
j.skills, u.github_username, r.file_path, u.id AS uid
        FROM applications a
        JOIN users u ON a.candidate_id = u.id
        JOIN jobs j ON a.job_id = j.id
        JOIN resumes r ON u.id = r.user_id
        WHERE j.recruiter_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $recruiter_id);
$stmt->execute();
$result = $stmt->get_result();

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Applicants</title>
        <link href="../../assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- header -->
        <?php include("../../templates/header.php");?>
        <!-- header -->
        <div id="layoutSidenav">
            <!-- sidenav -->
            <?php include("../../templates/sidenav.php");?>
            <!-- sidenav -->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Applicants</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Applicants</li>
                        </ol>
                        
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table me-1"></i>
                                            Applicants
                                        </div>
                                        <div class="card-body">
                                            <?php if ($result->num_rows > 0): ?>
                                            <table id="datatablesSimple">
                                                <thead>
                                                    <tr>
                                                        <th>Job Title</th>
                                                        <th>Candidate</th>
                                                        <th>Email</th>
                                                        <th>Status</th>
                                                        <th>Technical skill score</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                     while ($row = $result->fetch_assoc()): ?>

                                                        <?php
                                                            $controller = new SkillController();
                                                            
                                                            // GitHub data
                                                            $repos = $controller->fetchGitHubRepos($row['github_username']);
                                                            $repoCount = count($repos);

                                                            $languages = [];
                                                            foreach ($repos as $repo) {
                                                                if (!empty($repo['language'])) {
                                                                    $languages[] = strtolower($repo['language']);
                                                                }
                                                            }
                                                            $languages = array_unique($languages);
                                                            
                                                            // Resume skills
                                                            $resumeSkills = $controller->extractSkillsFromResumeSimple(
                                                                $row['file_path'],
                                                                $row['skills']
                                                            );

                                                            // Final skill score
                                                            $skillScore = $controller->calculateSkillScore($resumeSkills, $repoCount, $languages);

                                                            
                                                            // application id from applications table
                                                            $applicationId = $row['id'];

                                                            $controller->updateApplicationStatus($applicationId, $skillScore, $conn);

                                                        ?>



                                                     
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td>
                                                            <span class="badge bg-primary">
                                                                <?php echo $row['status']; ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php echo $skillScore ?? 'Not evaluated'; ?>
                                                        </td>
                                                        <!-- <td> -->
                                                            <!-- Tech Review Button -->
                                                            <!-- <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#techReviewModal<?= $row['id'] ?>">
                                                                Tech Review
                                                            </button> -->
                                                            
                                                            <!-- HR Review Button -->
                                                            <!-- <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#hrReviewModal<?= $row['id'] ?>">
                                                                HR Review
                                                            </button> -->
                                                        <!-- </td> -->

                                                    </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                            

                                            <?php else: ?>
                                                <p>No applicants yet.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                        <div style="height: 100vh"></div>
                        
                    </div>
                </main>
                <!-- footer -->
                <?php include("../../templates/footer.php");?>
                <!-- footer -->
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../assets/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../../assets/js/datatables-simple-demo.js"></script>
    </body>
</html>


