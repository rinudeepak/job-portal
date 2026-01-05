<?php
session_start();
include "../../models/db_connection/db.php";

$recruiter_id = $_SESSION['user_id'];

$jobId = $_GET['job_id'] ?? null;
$jobTitle = $_GET['job_title'] ?? null;

$sql = "SELECT 
            a.id AS application_id,
            a.status,
            u.name,
            u.email,
            j.title
        FROM applications a
        JOIN users u ON a.candidate_id = u.id
        JOIN jobs j ON a.job_id = j.id
        WHERE a.status NOT IN ('Applied', 'Selected', 'Rejected')
        AND j.recruiter_id = ?";

if ($jobId) {
    $sql .= " AND j.id = ?";
}



$stmt = $conn->prepare($sql);

if ($jobId) {
    $stmt->bind_param("ii", $recruiter_id, $jobId);
} else {
    $stmt->bind_param("i", $recruiter_id);
}

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
        <title>Review</title>
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
                                                        <th>Email</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                        <th></th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                     while ($row = $result->fetch_assoc()): ?>

                                                     
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td>
                                                            <span class="badge bg-primary">
                                                                <?php echo $row['status']; ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php if ($row['status'] === 'Shortlisted'): ?>
                                                        <button 
                                                                class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#techReviewModal<?= $row['application_id']; ?>">
                                                                Tech Review
                                                            </button>
                                                            <?php elseif ($row['status'] === 'Technical Checked' || $row['status'] === 'HR Checked'): ?>
                                                                <span class="badge bg-success">Tech Reviewed</span>
                                                            <?php endif; ?>

                                                        </td>
                                                        <td>
                                                            <?php if ($row['status'] === 'Technical Checked'): ?>
                                                            <button 
                                                            class="btn btn-sm btn-warning"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#hrReviewModal<?= $row['application_id']; ?>">
                                                            HR Review
                                                            </button>
                                                            <?php elseif ($row['status'] === 'HR Checked'): ?>
                                                                <span class="badge bg-success">HR Reviewed</span>
                                                            <?php endif; ?>

                                                        </td>
                                                    </tr>
                                                    <!-- Tech Review Modal -->
                                                    <div class="modal fade" id="techReviewModal<?= $row['application_id']; ?>" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Technical Review</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <form method="POST" action="../../controllers/review_controller.php">
                                                                <div class="modal-body">
                                                                <input type="hidden" name="action" value="tech_review">
                                                                <input type="hidden" name="application_id" value="<?= $row['application_id']; ?>">
                                                                <input type="hidden" name="job_id" value="<?= $jobId; ?>">
                                                                <input type="hidden" name="job_title" value="<?= $row['title']; ?>">

                                                                <div class="mb-3">
                                                                    <label class="form-label">Technical Score (0–10)</label>
                                                                    <input type="number" name="tech_score" class="form-control" min="0" max="10" step="1" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Comment</label>
                                                                    <textarea name="tech_comment" class="form-control" required></textarea>
                                                                </div>

                                                                </div>

                                                                <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Submit Review</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- HR Review Modal -->
                                                     <div class="modal fade" id="hrReviewModal<?= $row['application_id']; ?>" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">HR Review</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <form method="POST" action="../../controllers/review_controller.php">
                                                                <div class="modal-body">
                                                                <input type="hidden" name="action" value="hr_review">
                                                                <input type="hidden" name="application_id" value="<?= $row['application_id']; ?>">
                                                                <input type="hidden" name="job_id" value="<?= $jobId; ?>">
                                                                <input type="hidden" name="job_title" value="<?= $row['title']; ?>">

                                                                <div class="mb-3">
                                                                    <label>HR Score  (0–10)</label>
                                                                    <input type="number" name="hr_score" class="form-control" min="0" max="10" step="1" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label>HR Comment</label>
                                                                    <textarea name="hr_comment" class="form-control" required></textarea>
                                                                </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div>
                                                        </div>

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


