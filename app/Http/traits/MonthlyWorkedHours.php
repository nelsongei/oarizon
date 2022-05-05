<?php

namespace App\Http\traits;

Trait MonthlyWorkedHours {
    public function totalWorkedHours($employee)
    {
        if(is_null($employee->attendance))
        {
            return 0;
        }else{
            $total = 0;
            foreach($employee->attendance as $a){
                sscanf($a->total_work, '%d:%d',$hour, $min);
                $total += $hour* 60 +$min;
            }

            if($h = floor($total/60))
            {
                $total %= 60;
            }
            $sum_total = sprintf('%02d:%02d',$h, $total);
            return $sum_total;
        }
    }
}