<?php
require_once __DIR__ . '/db_connection/db.php';

class JobModel {
    
    public function createJob($recruiter_id, $title, $description, $skills, $experience, $location) {
        global $conn;

        $stmt = $conn->prepare("
            INSERT INTO jobs (recruiter_id, title, description, skills, experience, location)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

            $stmt->bind_param(
            "isssis",
            $recruiter_id,
            $title,
            $description,
            $skills,
            $experience,
            $location
        );


        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getJobsByRecruiter($recruiter_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM jobs WHERE recruiter_id=? ORDER BY created_at DESC");
        $stmt->bind_param("i", $recruiter_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
