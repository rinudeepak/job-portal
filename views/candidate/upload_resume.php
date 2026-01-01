<?php
session_start();
require_once __DIR__ . '/../../models/db_connection/db.php';

$error = "";
$success = "";
global $conn;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_resume'])) {

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === 0) {

        $fileName = $_FILES['resume']['name'];
        $fileTmp  = $_FILES['resume']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileExt !== 'pdf') {
            $error = "Only PDF files are allowed";
        } else {

            $newName = time() . "_" . $_SESSION['user_id'] . ".pdf";
            $uploadPath = "../../uploads/resumes/" . $newName;

            if (move_uploaded_file($fileTmp, $uploadPath)) {
                $relativePath = "uploads/resumes/" . $newName;
                $userId = $_SESSION['user_id'];

                $sql = "INSERT INTO resumes (user_id, file_path)
                        VALUES ('$userId', '$relativePath')";

                mysqli_query($conn, $sql);
                $success = "Resume uploaded successfully";

                
            } else {
                $error = "Upload failed. Try again.";
            }
        }
    } else {
        $error = "Please select a resume file";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Resume</title>
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
                        <h1 class="mt-4">Resume</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Resume</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-upload me-1"></i>
                                    Upload Resume
                                </div>
                                <div class="card-body">

                                    <?php if (!empty($error)) : ?>
                                        <div class="alert alert-danger"><?= $error ?></div>
                                    <?php endif; ?>

                                    <?php if (!empty($success)) : ?>
                                        <div class="alert alert-success"><?= $success ?></div>
                                    <?php endif; ?>

                                    <form method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="form-label">Upload Resume (PDF only)</label>
                                            <input type="file" name="resume" class="form-control" required>
                                        </div>

                                        <button type="submit" name="upload_resume" class="btn btn-primary">
                                            Upload Resume
                                        </button>
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
