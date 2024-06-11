<?php

namespace App\Traits;

trait Helpers
{
    public function ModifyDate($date): string
    {
        // calculate the difference, displays in two parts e.g: '1w 2d from now'
        $diff = now()->shortRelativeToNowDiffForHumans($date, 2);
        // separate the parts
        $diff = explode(' ', $diff);
        // store the two main parts
        $diffFirst = $diff[0];
        $diffSecond = $diff[1];

        $month = $date->shortEnglishMonth;
        $day = $date->day;
        $year = $date->year;

        if (preg_match('/^\d+(s)$/i', $diffFirst)) {
            if (substr($diffFirst, 0, -1) <= 9) return "Just now";
            return $diffFirst;
        }

        if (preg_match('/^\d+(s|m|h|d)$/i', $diffFirst)) {
            return $diffFirst;
        }

        if (
            str_contains($diffFirst, '1w')
            && !preg_match('/^\d+(d)$/i', $diffSecond)
        ) {
            return $diffFirst;
        }

        if (preg_match('/^\d+(w|mo)$/i', $diffFirst)) {

            return "$month $day";
        }

        if (preg_match('/^\d+(yr)$/i', $diffFirst)) {
            return "$month $day, $year";
        }

        return $diffFirst;
    }
}
