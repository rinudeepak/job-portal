<?php
require_once "../models/ApplicationModel.php";

if ($_POST['action'] === 'tech_review') {

    $applicationId = $_POST['application_id'];
    $jobId = $_POST['job_id'];
    $jobTitle = $_POST['job_title'];
    $score = $_POST['tech_score'];
    $comment = $_POST['tech_comment'];

    $status = ($score >= 5) ? 'Technical Checked' : 'Rejected';

    $model = new ApplicationModel();
    $model->saveTechReview($applicationId, $score, $comment, $status);

    header(
    "Location: ../views/recruiter/review.php?job_id=" . $jobId .
    "&job_title=" . urlencode($jobTitle)
);

}

if ($_POST['action'] === 'hr_review') {

    $applicationId = $_POST['application_id'];
    $jobId = $_POST['job_id'];
    $jobTitle = $_POST['job_title'];
    $score = $_POST['hr_score'];
    $comment = $_POST['hr_comment'];

    $status = ($score >= 5) ? 'HR Checked' : 'Rejected';

    $model = new ApplicationModel();
    $model->saveHRReview($applicationId, $score, $comment, $status);
    // Recalculate final selection
    $model->updateFinalSelection($jobId);

    header(
    "Location: ../views/recruiter/review.php?job_id=" . $jobId .
    "&job_title=" . urlencode($jobTitle)
);

}
