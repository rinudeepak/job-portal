<?php
session_start();
include "../../models/db_connection/db.php";

$recruiter_id = $_SESSION['user_id'];

$jobId = $_GET['job_id'] ?? null;
$jobTitle = $_GET['job_title'] ?? null;

// Fetch job required skills
$jobSkillStmt = $conn->prepare(
    "SELECT skills FROM jobs WHERE id = ? AND recruiter_id = ?"
);
$jobSkillStmt->bind_param("ii", $jobId, $recruiter_id);
$jobSkillStmt->execute();
$jobData = $jobSkillStmt->get_result()->fetch_assoc();

$jobRequiredSkills = $jobData['skills'] ?? '';


$sql = "
SELECT 
    a.status,
    a.resume_skills,
    a.repositories,
    a.commits,
    a.languages,
    a.skill_score,
    a.tech_score,
    a.tech_comment,
    a.hr_score,
    a.hr_comment,
    u.name,
    GROUP_CONCAT(s.skill_name SEPARATOR ', ') AS candidate_skills
FROM applications a
JOIN users u ON a.candidate_id = u.id
LEFT JOIN skills s ON s.user_id = u.id
WHERE a.job_id = ?
GROUP BY a.id
ORDER BY a.skill_score DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jobId);
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
        <title>Summary</title>
        <link href="../../assets/css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
                        <h1 class="mt-4"><?php echo $jobTitle; ?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $jobTitle; ?></li>
                        </ol>
                        <!-- Display job required skills -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <i class="fas fa-tools me-1"></i>
                                Job Required Skills
                            </div>
                            <div class="card-body">
                                <?php if (!empty($jobRequiredSkills)): ?>
                                    <?php 
                                        $skills = explode(',', $jobRequiredSkills);
                                        foreach ($skills as $skill): 
                                    ?>
                                        <span class="badge bg-secondary me-1 mb-1">
                                            <?= htmlspecialchars(trim($skill)); ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">No skills defined for this job.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table me-1"></i>
                                            <?php echo $jobTitle; ?>
                                        </div>
                                        <div class="card-body">
                                            <?php if ($result->num_rows > 0): ?>
                                            <table id="datatablesSimple">
                                                <thead>
                                                    <tr>
                                                        <th>Candidate</th>
                                                        <th>Candidate Added Skills</th>
                                                        <th>Resume Skills</th>
                                                        <th>GitHub repos</th>
                                                        <th>GitHub commits</th>
                                                        <th>Skill Score</th>
                                                        <th>GitHub languages</th>
                                                        <th>Tech Score</th>
                                                        <th>Tech Comments</th>
                                                        <th>HR Score</th>
                                                        <th>HR Comments</th>
                                                        <th>Status</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                     while ($row = $result->fetch_assoc()): ?>

                                                     
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['candidate_skills'] ?? '—'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['resume_skills']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['repositories']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['commits']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['skill_score']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['languages']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['tech_score']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['tech_comment']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['hr_score']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['hr_comment']); ?></td>
                                                        <td>
                                                            <span class="badge bg-primary">
                                                                <?php echo $row['status']; ?>
                                                            </span>
                                                        </td>
                                                        
                                                        
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


