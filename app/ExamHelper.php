<?php

namespace App;

trait ExamHelper
{
    public function makeExamCode($digits=6){
        $characters = "123456789ABCDEF123456789GHJ123456789KMN123456789PQRST123456789UVW123456789XYZ123456789";
        $characters = str_shuffle($characters);
        $code = '';
        for ($i = 0; $i < $digits; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }
}
