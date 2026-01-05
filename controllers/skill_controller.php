<?php


class SkillController {


    function calculateSkillScore($resumeSkills, $repoCount, $commitCount) {
        $score = 0;

        $score += count($resumeSkills) * 10;
        $score += $repoCount * 10;
        $score += $commitCount * 0.1;
        
        return round($score);
    }



}
