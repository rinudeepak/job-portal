<?php
 session_start(); 
include "../../models/db_connection/db.php";

$user_id = $_SESSION['user_id'] ?? 0;

// Add skill
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill_btn'])) {
    $skill = trim($_POST['skill_name']);

    if (!empty($skill)) {
        mysqli_query($conn, "INSERT INTO skills (user_id, skill_name) VALUES ('$user_id', '$skill')");
        header("Location: skills.php");
        exit;

    }
}

// Fetch skills
$result = mysqli_query($conn, "SELECT * FROM skills WHERE user_id='$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Skills</title>
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
                        <h1 class="mt-4">Skills</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Skills</li>
                        </ol>
                        
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Add Skill</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" name="skill_name" class="form-control" placeholder="Enter skill (e.g. PHP, MySQL)" required>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary w-100"  name="add_skill_btn">Add Skill</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Your Skills</strong>
                                </div>
                                <div class="card-body">
                                    <?php if (mysqli_num_rows($result) > 0) { ?>
                                        <ul class="list-group">
                                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <li class="list-group-item">
                                                    <?php echo htmlspecialchars($row['skill_name']); ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } else { ?>
                                        <p>No skills added yet.</p>
                                    <?php } ?>
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
