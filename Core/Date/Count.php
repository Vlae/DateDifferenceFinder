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
        $days = Count::getDays($startDate, $endDate, $invent);

        $yearsDays = Count::getYearDays($startDate, $endDate, $invent);
        $monthsDays = Count::getMonthsDays($startDate, $endDate, $invent);


        return $yearsDays + $monthsDays + $days;

    }

    public static function getYears(Recognizer $start, Recognizer $end, bool $invent) : int {
        $years = abs($start->years - $end->years);
        $years = Count::removeNotFullYear($start, $end, $invent, $years);

        return $years;
    }


    public static function getMouths(Recognizer $start, Recognizer $end, bool $invent) : int {
        $months = abs($start->months - $end->months);

        if ($start->years === $end->years) {
            if (!$invent && $months === 1 && $start->days > $end->days) {
                $months--;
            } elseif ($invent && $months === 1 && $start->days < $end->days) {
                $months--;
            }
        }

        return $months;
    }

    public static function getDays(Recognizer $start, Recognizer $end, bool $invent) : int {
        $days = abs($start->days - $end->days);
        $months = Count::getMouths($start, $end, $invent);
        $calendar = new Calendar($end->years);

        $invent ? $startMonths = $end->months : $startMonths = $start->months;

        if (!$invent && $months === 0 && $start->days > $end->days) {
            $days = $calendar->days[$startMonths] - $start->days + $end->days;
        } elseif($invent && $months === 0 && $end->days > $start->days) {
            $days = $calendar->days[$startMonths] + $start->days - $end->days;
        }

        return $days;
    }

    public static function setInvent() : bool {
        return true;
    }

    public static function getYearDays(Recognizer $start, Recognizer $end, bool $invent) : int {
        $daysTotal = 0;
        $obj = Count::getInventedVariables($start, $end, $invent);
        $obj->endYear = Count::removeNotFullYear($start, $end, $invent, $obj->endYear);

        for (; $obj->startYear < $obj->endYear; $obj->startYear++) {
            $calendar = new Calendar($obj->startYear);
            $daysTotal += $calendar->yearDays;
        }

        return $daysTotal;
    }

    public static function getMonthsDays(Recognizer $start, Recognizer $end, bool $invent) : int {
        $daysTotal = 0;
        $obj = Count::getInventedVariables($start, $end, $invent);

        $calendar = new Calendar($obj->endYear);

        if (abs($obj->startMonth - $obj->endMonth) !== 1) {
            if ($obj->startMonth > $obj->endMonth) {
                $var = $obj->startMonth;
                $obj->startMonth = $obj->endMonth;
                $obj->endMonth = $var;
            }

            for (; $obj->startMonth < $obj->endMonth; $obj->startMonth++) {
                if ($obj->startMonth + 1 !== $obj->endMonth) {
                    $daysTotal += $calendar->days[$obj->startMonth];
                } else {
                    $invent
                        ? $daysTotal += $calendar->days[$obj->startMonth] - $start->days + $end->days
                        : $daysTotal += $calendar->days[$obj->startMonth] - $end->days + $start->days;
                }
            }
        } else {
            // if month is ended
            if ($obj->startDay < $obj->endDay) {
                $invent
                    ? $daysTotal = $calendar->days[$obj->startMonth] - $start->days + $end->days
                    : $daysTotal = $calendar->days[$obj->startMonth] - $end->days + $start->days;

                if ($daysTotal > 31) {
                    $daysTotal = 31;
                }
            }
        }

        return $daysTotal;

    }

    private static function getInventedVariables(Recognizer $start, Recognizer $end, bool $invent) : \stdClass {
        $obj = new \stdClass;

        if ($invent) {
            $obj->startYear = $end->years;
            $obj->endYear = $start->years;
            $obj->startMonth = $end->months;
            $obj->endMonth = $start->months;
            $obj->startDay = $end->days;
            $obj->endDay = $start->days;
        } else {
            $obj->startMonth = $start->months;
            $obj->endMonth = $end->months;
            $obj->startYear = $start->years;
            $obj->endYear = $end->years;
            $obj->startDay = $start->days;
            $obj->endDay = $end->days;
        }

        return $obj;
    }

    /**
     * Checks is last year ended. If not remove not ended year
     *
     * @param Recognizer $start
     * @param Recognizer $end
     * @param bool $invent
     * @param int $years
     * @return int
     */
    private static function removeNotFullYear(Recognizer $start, Recognizer $end, bool $invent, int $years) : int {
        if (
            !$invent
            && ($start->months > $end->months || ($start->months === $end->months && $start->days > $end->days) )
        ) {
            $years--;
        } elseif (
            $invent
            && ($start->months < $end->months || ($start->months === $end->months && $start->days < $end->days) )
        ) {
            $years--;
        }

        return $years;
    }
}