<?php

namespace App\Services;

use Carbon\Carbon;

class ScaleService
{

    private array $sunday;

    private array $scales;

    public function getSundays(array $data): array {
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $data['month'], $data['year']);

        for ($day = 1; $day <= $totalDays; $day++) {
            $date = Carbon::createFromFormat('Y-m-d', $data['year'].'-'.$data['month'].'-'.$day)->format('Y-m-d');

            if (date('w', strtotime($date)) == 0) { // 0 representa domingo
                $this->sunday[] = $date;
            }
        }

        return $this->sunday;
    }

    public function scaleCalculate(string $last_day_off,int $cycle, array $sundays): array {

        $last_day_off = strtotime($last_day_off);
        $count  = 0;

        foreach ($sundays as $sunday) {
            $sunday_time = strtotime($sunday);
            $days_since_last_sheet = ($sunday_time - $last_day_off) / (60 * 60 * 24 * 7);


            if ($cycle == 0 || ($days_since_last_sheet > 0 && $days_since_last_sheet % ($cycle + 1) == 0)) {
                $this->scales[$sunday] = 'Folga';;
                $count = 0;
            } else {
                $this->scales[$sunday] = 'Trabalha';
                $count++;
                if ($count >= $cycle) {
                    $count = 0;
                }
            }


        }

        return $this->scales;
    }

}
