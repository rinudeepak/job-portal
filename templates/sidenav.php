<?php
include "../../models/db_connection/db.php";


?>


<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            
            <div class="nav">
                <?php  $role = $_SESSION['role']; 
                if ($role == "candidate") {?>
                    <a class="nav-link" href="dashboard.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="upload_resume.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Resume
                    </a>
                    <a class="nav-link" href="skills.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Skills
                    </a>
                    <a class="nav-link" href="jobs.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Jobs
                    </a>
                <?php }
                else {
                    $recruiter_id = $_SESSION['user_id'];
                    $sql = "SELECT * FROM jobs WHERE recruiter_id = ?";
                    $stmt = $conn->prepare($sql);

                    if (!$stmt) {
                        die("Prepare failed: " . $conn->error);
                    }

                    $stmt->bind_param("i", $recruiter_id);
                    $stmt->execute();
                    $jobs = $stmt->get_result();
                    ?>
                    <a class="nav-link" href="dashboard.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="post_job.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Post Job
                    </a>
                    <div class="sb-sidenav-menu-heading">Jobs</div>
                    <?php while ($job = $jobs->fetch_assoc()): 
                        $collapseId = "jobCollapse_" . $job['id'];
                    ?>
                        <!-- Job Title -->
                        <a class="nav-link collapsed"
                        href="#"
                        data-bs-toggle="collapse"
                        data-bs-target="#<?= $collapseId; ?>"
                        aria-expanded="false"
                        aria-controls="<?= $collapseId; ?>">

                            <div class="sb-nav-link-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>

                            <?= htmlspecialchars($job['title']); ?>

                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>

                        <!-- Job Menu -->
                        <div class="collapse"
                            id="<?= $collapseId; ?>"
                            data-bs-parent="#sidenavAccordion">

                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                href="review.php?job_id=<?= $job['id']; ?>&job_title=<?= urlencode($job['title']); ?>">
                                    Review
                                </a>

                                <a class="nav-link"
                                href="summary.php?job_id=<?= $job['id']; ?>&job_title=<?= urlencode($job['title']); ?>">
                                    Summary
                                </a>
                            </nav>
                        </div>
                    <?php endwhile; ?>
                
                <?php }?>
            </div>
        </div>
        <?php 
       
            if($_SESSION["user_id"]!="") {?>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo $_SESSION["user_name"]; ?>
        </div>
        <?php } ?>
    </nav>
</div>