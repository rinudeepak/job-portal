<?php
require_once __DIR__ . '/db_connection/db.php';

class ApplicationModel {

    public function saveTechReview($appId, $score, $comment, $status) {
        global $conn;

        $sql = "UPDATE applications 
                SET tech_score = ?, tech_comment = ?, status = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issi", $score, $comment, $status, $appId);
        return $stmt->execute();
    }
    public function saveHRReview($appId, $score, $comment, $status) {
        global $conn;
        
        $sql = "UPDATE applications 
                SET hr_score = ?, hr_comment = ?, status = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issi", $score, $comment, $status, $appId);
        return $stmt->execute();

        

    }

    public function updateFinalSelection($jobId) {
        global $conn;


        //  Select TOP 3 by total score
        $topSql = "
            SELECT id
            FROM applications
            WHERE job_id = ?
            AND tech_score > 5
            AND hr_score > 5
            ORDER BY (skill_score + tech_score + hr_score) DESC
            LIMIT 3
        ";

        $stmt = $conn->prepare($topSql);
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $result = $stmt->get_result();

        $selectedIds = [];
        while ($row = $result->fetch_assoc()) {
            $selectedIds[] = $row['id'];
        }

        if (count($selectedIds) > 0) {
            $ids = implode(',', $selectedIds);

            // 3. Mark top 3 as Selected
            $updateSql = "
                UPDATE applications
                SET status = 'Selected'
                WHERE id IN ($ids)
            ";
            $conn->query($updateSql);
        }
    }

}
