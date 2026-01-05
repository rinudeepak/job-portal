<?php session_start(); 
 include "../../models/db_connection/db.php";

$recruiter_id = $_SESSION['user_id'];

$sql = "
SELECT 
    j.id,
    j.title,
    COUNT(a.id) AS total_applicants,
    SUM(CASE WHEN a.status = 'Selected' THEN 1 ELSE 0 END) AS selected_count,
    SUM(CASE WHEN a.status = 'Rejected' THEN 1 ELSE 0 END) AS rejected_count,
    SUM(
        CASE 
            WHEN a.status NOT IN ('Selected', 'Rejected') 
            THEN 1 ELSE 0 
        END
    ) AS in_progress_count
FROM jobs j
LEFT JOIN applications a ON a.job_id = j.id
WHERE j.recruiter_id = ?
GROUP BY j.id
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recruiter_id);
$stmt->execute();
$jobs_result = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard </title>
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
                        <!-- <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jobs</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="post_job.php">Post</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Review( Tech & HR)</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="applicants.php">Review</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div> -->

                        <div class="row">
                            <?php while ($job = $jobs_result->fetch_assoc()): ?>
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?= htmlspecialchars($job['title']); ?>
                                            </h5>

                                            <p class="mb-2">
                                                <strong>Total Applicants:</strong>
                                                <?= $job['total_applicants']; ?>
                                            </p>

                                            <div class="d-flex justify-content-between">
                                                <span class="badge bg-success">
                                                    Selected: <?= $job['selected_count']; ?>
                                                </span>

                                                <span class="badge bg-danger">
                                                    Rejected: <?= $job['rejected_count']; ?>
                                                </span>

                                                <span class="badge bg-warning text-dark">
                                                    In Progress: <?= $job['in_progress_count']; ?>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="card-footer text-end bg-light">
                                            <a href="summary.php?job_id=<?= $job['id']; ?>&job_title=<?= urlencode($job['title']); ?>"
                                            class="btn btn-sm btn-primary">
                                                View Summary
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
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
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
        <!-- <script src="../../assets/demo/chart-area-demo.js"></script>
        <script src="../../assets/demo/chart-bar-demo.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <!-- <script src="../../assets/js/datatables-simple-demo.js"></script> -->
    </body>
</html>
