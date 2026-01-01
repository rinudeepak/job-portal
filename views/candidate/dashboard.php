<?php
session_start();
require_once "../../models/db_connection/db.php";

$candidate_id = $_SESSION['user_id'];

$sql = "
SELECT 
    j.title,
    j.location,
    u.company_name,
    a.status,
    a.applied_at
FROM applications a
JOIN jobs j ON a.job_id = j.id
JOIN users u ON j.recruiter_id = u.id
WHERE a.candidate_id = ?
ORDER BY a.applied_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $candidate_id);
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
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../../assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Resume</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="upload_resume.php">View</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Skills</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="skills.php">View</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Jobs</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="jobs.php">View</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                My Applications
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Job Title</th>
                                            <th>Location</th>
                                            <th>Company</th>
                                            <th>Status</th>
                                            <th>Applied On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $row['title']; ?></td>
                                            <td><?= $row['location']; ?></td>
                                            <td><?= $row['company_name']; ?></td>
                                            <td><?= $row['status']; ?></td>
                                            <td><?= $row['applied_at']; ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </main>
                
                <!-- footer -->
                <?php include("../../templates/footer.php");?>
                <!-- footer -->
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../../assets/demo/chart-area-demo.js"></script>
        <script src="../../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../../assets/js/datatables-simple-demo.js"></script>
    </body>
</html>
