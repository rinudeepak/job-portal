<?php

require_once __DIR__ . '../../models/JobModel.php';

class RecruiterController {

    public function postJob() {
        $error = "";
        $success = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_job_btn'])) {
            $title = $_POST['job_title'];
            $description = $_POST['job_description'];
            $skills = $_POST['skills_required'];
            $experience = $_POST['experience'];
            $location = $_POST['location'];
            $recruiter_id = $_SESSION['user_id'];

            $jobModel = new JobModel();
            $result = $jobModel->createJob($recruiter_id, $title, $description, $skills, $experience, $location);

            if ($result) {
                $success = "Job posted successfully!";
            } else {
                $error = "Failed to post job. Try again.";
            }
        }

        // Return messages to view
        return ['error' => $error, 'success' => $success];
    }

    public function listJobs() {
        $recruiter_id = $_SESSION['user_id'];
        $jobModel = new JobModel();
        return $jobModel->getJobsByRecruiter($recruiter_id);
    }
}
