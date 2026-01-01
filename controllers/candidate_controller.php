<?php 
require_once __DIR__ . '/../models/ResumeModel.php';

$resumeModel = new ResumeModel();

$text = $resumeModel->extractTextFromPDF($uploadPath);

$skillsFromJob = explode(',', $job['skills_required']); // from jobs table
$matchedSkills = $resumeModel->extractSkills($text, $skillsFromJob);

// Example score
$skillScore = count($matchedSkills) * 10;
?>
