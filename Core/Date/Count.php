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
    public function getTotalDifference(Recognizer $startDate, Recognizer $endDate, bool $invented) : int {
        $days = $this->getDays($startDate, $endDate, $invented);
        $yearsDays = $this->getYearDays($startDate, $endDate, $invented);
        $monthsDays = $this->getMonthsDays($startDate, $endDate, $invented);

        return $yearsDays + $monthsDays + $days;
    }

    public function getYears(Recognizer $startDate, Recognizer $endDate, bool $invented) : int {
        $years = abs($startDate->years - $endDate->years);
        $years = $this->removeNotFullYear($startDate, $endDate, $invented, $years);

        return $years;
    }


    public function getMouths(Recognizer $startDate, Recognizer $endDate, bool $invented) : int {
        $months = abs($startDate->months - $endDate->months);

        if ($startDate->years === $endDate->years) {
            if (!$invented && $months === 1 && $startDate->days > $endDate->days) {
                $months--;
            } elseif ($invented && $months === 1 && $startDate->days < $endDate->days) {
                $months--;
            }
        }

        return $months;
    }

    public function getDays(Recognizer $startDate, Recognizer $endDate, bool $invented) : int {
        $days = abs($startDate->days - $endDate->days);
        $months = $this->getMouths($startDate, $endDate, $invented);
        $calendar = new Calendar($endDate->years);

        $invented ? $startDateMonths = $endDate->months : $startDateMonths = $startDate->months;

        if (!$invented && $months === 0 && $startDate->days > $endDate->days) {
            $days = $calendar->days[$startDateMonths] - $startDate->days + $endDate->days;
        } elseif($invented && $months === 0 && $endDate->days > $startDate->days) {
            $days = $calendar->days[$startDateMonths] + $startDate->days - $endDate->days;
        }

        return $days;
    }

    public function setInvent() : bool {
        return true;
    }

    public function getYearDays(Recognizer $startDate, Recognizer $endDate, bool $invented) : int {
        $daysTotal = 0;
        $obj = $this->getInventedVariables($startDate, $endDate, $invented);
        $obj->endYear = $this->removeNotFullYear($startDate, $endDate, $invented, $obj->endYear);

        for (; $obj->startYear < $obj->endYear; $obj->startYear++) {
            $calendar = new Calendar($obj->startYear);
            $daysTotal += $calendar->yearDays;
        }

        return $daysTotal;
    }

    public function getMonthsDays(Recognizer $startDate, Recognizer $endDate, bool $invented) : int {
        $daysTotal = 0;
        $obj = $this->getInventedVariables($startDate, $endDate, $invented);

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
                    $invented
                        ? $daysTotal += $calendar->days[$obj->startMonth] - $startDate->days + $endDate->days
                        : $daysTotal += $calendar->days[$obj->startMonth] - $endDate->days + $startDate->days;
                }
            }
        } else {
            // if month is ended
            if ($obj->startDay < $obj->endDay) {
                $invented
                    ? $daysTotal = $calendar->days[$obj->startMonth] - $startDate->days + $endDate->days
                    : $daysTotal = $calendar->days[$obj->startMonth] - $endDate->days + $startDate->days;

                if ($daysTotal > 31) {
                    $daysTotal = 31;
                }
            }
        }

        return $daysTotal;

    }

    private function getInventedVariables(Recognizer $startDate, Recognizer $endDate, bool $invented) : \stdClass {
        $obj = new \stdClass;

        if ($invented) {
            $obj->startYear = $endDate->years;
            $obj->endYear = $startDate->years;
            $obj->startMonth = $endDate->months;
            $obj->endMonth = $startDate->months;
            $obj->startDay = $endDate->days;
            $obj->endDay = $startDate->days;
        } else {
            $obj->startMonth = $startDate->months;
            $obj->endMonth = $endDate->months;
            $obj->startYear = $startDate->years;
            $obj->endYear = $endDate->years;
            $obj->startDay = $startDate->days;
            $obj->endDay = $endDate->days;
        }

        return $obj;
    }

    /**
     * Checks is last year ended. If not - remove not ended year
     *
     * @param Recognizer $startDate
     * @param Recognizer $endDate
     * @param bool $invented
     * @param int $years
     * @return int
     */
    private function removeNotFullYear(Recognizer $startDate, Recognizer $endDate, bool $invented, int $years) : int {
        if (
            !$invented
            && ($startDate->months > $endDate->months || ($startDate->months === $endDate->months && $startDate->days > $endDate->days) )
        ) {
            $years--;
        } elseif (
            $invented
            && ($startDate->months < $endDate->months || ($startDate->months === $endDate->months && $startDate->days < $endDate->days) )
        ) {
            $years--;
        }

        return $years;
    }
}