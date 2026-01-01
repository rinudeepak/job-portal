<?php
session_start();
require_once "../../models/db_connection/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_btn'])) {

    $job_id = $_POST['job_id'];
    $candidate_id = $_SESSION['user_id'];

    // Prevent duplicate applications
    $check = mysqli_query($conn,
        "SELECT id FROM applications WHERE job_id='$job_id' AND candidate_id='$candidate_id'"
    );

    if (mysqli_num_rows($check) > 0) {
        header("Location: jobs.php?msg=already_applied");
        exit;
    }

    $sql = "INSERT INTO applications (job_id, candidate_id) 
            VALUES ('$job_id', '$candidate_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: jobs.php?msg=applied");
    } else {
        header("Location: jobs.php?msg=error");
    }
}
