<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 14.10.2017
 * Time: 11:36
 */

namespace Date;

class Count extends Countable
{
    public static function getTotalDifference(Recognizer $startDate, Recognizer $endDate, bool $invent) : int {
        $years = Count::getYears($startDate, $endDate, $invent);
        $months = Count::getMouths($startDate, $endDate, $invent);
        $days = Count::getDays($startDate, $endDate, $invent);


        if ( $years !== 0 && $months !== 0 && $days !== 0 ) {
            $yearsDays = Count::getYearDays($startDate->years, $endDate->years, $invent);
            $monthsDays = Count::getMonthsDays($startDate, $endDate, $invent);
            $total = $yearsDays + $monthsDays + $days;
        } elseif ($years === 0 && $months !== 0 && $days !== 0) {
            echo 'vlae2';
            $total = $months * $days;
        } elseif ($years === 0 && $months === 0 && $days !== 0) {
            echo 'vlae3';
            $total = $days;
        } else {
            echo 'vlae4';
            $total = 0;
        }

        return $total;
    }

    public static function getYears(Recognizer $start, Recognizer $end, bool $invent) : int {
        $years = abs($start->years - $end->years);

        if (
            !$invent
            && $years === 1
            && ($start->months > $end->months || $start->months === $end->months && $start->days > $end->days)
        ) {
            $years--;
        } elseif (
            $invent
            && $years
            && ($start->months < $end->months || $start->months === $end->months && $start->days < $end->days)
        ) {
            $years--;
        }

        return $years;
    }


    public static function getMouths(Recognizer $start, Recognizer $end, bool $invent) : int {
        $months = abs($start->months - $end->months);

        if (!$invent && $months === 1 && $start->days > $end->days) {
            $months--;
        } elseif ($invent && $months === 1 && $start->days < $end->days) {
            $months--;
        }

        return $months;
    }

    public static function getDays(Recognizer $start, Recognizer $end, bool $invent) : int {
        $months = Count::getMouths($start, $end, $invent);

        if ($invent) {
            $startDays = $start->days;
            $start->days = $end->days;
            $end->days = $startDays;

            unset($startDays);
        }
        if ($months !== 0) {
            $days = abs($start->days - $end->days);
        } else {
            $calendar = new Calendar($end->years);
            $days = $calendar->days[$start->months] - $start->days + $end->days;
        }


        return $days;
    }

    public static function setInvent() : bool{
        return true;
    }

    public static function getYearDays($startYear, $endYear, bool $invent) : int {
        $daysTotal = 0;
        if ($invent) {
            $start = $startYear;

            $startYear = $endYear;
            $endYear = $start;

            unset($start);
        }

        for (; $startYear < $endYear; $startYear++) {
            $calendar = new Calendar($startYear);
            $daysTotal += $calendar->yearDays;
        }

        return $daysTotal;
    }

    public static function getMonthsDays(Recognizer $start, Recognizer $end, bool $invent) : int {
        $daysTotal = 0;
        $calendar = new Calendar($end->years);

        if ($invent) {
            $startMonth = $end->months;
            $endMonth = $start->months;
            $startDays = $start->days;
            $start->days = $end->days;
            $end->days = $startDays;
        } else {
            $startMonth = $start->months;
            $endMonth = $end->months;
        }


        if (abs($startMonth - $endMonth) !== 1) {
            for (; $startMonth < $endMonth; $startMonth++) {
                if ($startMonth + 1 !== $endMonth) {
                    $daysTotal += $calendar->days[$startMonth];
                } else {
                    $daysTotal = $calendar->days[$startMonth] - $start->days + $end->days;
                }
            }
        } else {
            $daysTotal = $calendar->days[$startMonth] - $start->days + $end->days;
            var_dump($calendar->days[$startMonth]);
            var_dump($start->days);
            var_dump($end->days);
        }

        if ($daysTotal > 31) {
            $daysTotal = 31;
        }

        var_dump($daysTotal);
        return $daysTotal;

    }


}