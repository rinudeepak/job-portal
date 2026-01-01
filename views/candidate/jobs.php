<?php
session_start();
require_once "../../models/db_connection/db.php";

$result = mysqli_query($conn, "SELECT * FROM jobs ORDER BY created_at DESC");
?>
<?php
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'applied') {
        echo '<div class="alert alert-success">Job applied successfully!</div>';
    }
    if ($_GET['msg'] == 'already_applied') {
        echo '<div class="alert alert-warning">You have already applied for this job.</div>';
    }
    if ($_GET['msg'] == 'error') {
        echo '<div class="alert alert-danger">Something went wrong.</div>';
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
                                    <h4>Available Jobs</h4>
                                </div>
                                <div class="card-body">

                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php while ($job = mysqli_fetch_assoc($result)): ?>
                                            <div class="border p-3 mb-3 rounded">
                                                <h5><?php echo htmlspecialchars($job['title']); ?></h5>
                                                <p><strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>
                                                <p><strong>Skills:</strong> <?php echo htmlspecialchars($job['skills']); ?></p>
                                                <p><strong>Experience:</strong> <?php echo $job['experience']; ?> years</p>
                                                <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>

                                                <form method="post" action="apply_job.php">
                                                    <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                                    <button type="submit" name="apply_btn" class="btn btn-primary btn-sm">
                                                        Apply
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <p>No jobs available right now.</p>
                                    <?php endif; ?>

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
