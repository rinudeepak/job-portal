<?php
 session_start(); 
 
require_once __DIR__ . '/../../controllers/recruiter_controller.php';
$controller = new RecruiterController();
$result = $controller->postJob();
$error = $result['error'] ?? "";
$success = $result['success'] ?? "";
$jobs = $controller->listJobs();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Jobs</title>
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
                        <h1 class="mt-4">Jobs</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Jobs</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="text-center">Post a New Job</h3>
                                </div>
                                <div class="card-body">
                                        <?php
                                            if (isset($error) && $error != "") {
                                                echo '<div class="alert alert-danger">' . $error . '</div>';
                                            }
                                            if (isset($success) && $success != "") {
                                                echo '<div class="alert alert-success">' . $success . '</div>';
                                            }
                                        ?>
                                        <form method="post" action="post_job.php">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="job_title" id="jobTitle" placeholder="Job Title" required>
                                                <label for="jobTitle">Job Title</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" name="job_description" id="jobDescription" placeholder="Job Description" style="height: 100px" required></textarea>
                                                <label for="jobDescription">Job Description</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" name="skills_required" id="skillsRequired" placeholder="Skills Required" required>
                                                        <label for="skillsRequired">Skills Required (comma separated)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control" name="experience" id="experience" placeholder="Experience in years" required>
                                                        <label for="experience">Experience (in years)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="location" id="location" placeholder="Location" required>
                                                <label for="location">Location</label>
                                            </div>
                                            <div class="d-grid">
                                                <button type="submit" name="post_job_btn" class="btn btn-primary btn-block">Post Job</button>
                                            </div>
                                            

                                        </form>
                                    </div>
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
    </body>
</html>
