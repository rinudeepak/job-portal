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
                <?php }else{?>
                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="post_job.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Post Job
                </a>
                <a class="nav-link" href="applicants.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Applicants
                </a>
                
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