<?php
// TODO::Rework logic on inverted
/**
 * Created by PhpStorm.
 * User: Valeriy
 * DateOutput: 14.10.2017
 * Time: 11:36
 */

namespace Date;

class InvertedCount extends CountableStrategy
{
    public function getTotalDifference(Recognizer $startDate, Recognizer $endDate) : int {
        $yearsDays = $this->getAmountOfDaysBetweenYears($startDate, $endDate);
        $monthsDays = $this->getMonthsDays($startDate, $endDate);
        $days = $this->getDays($startDate, $endDate);

        return $yearsDays + $monthsDays + $days;
    }

    /**
     * Used as output
     * @param Recognizer $startDate
     * @param Recognizer $endDate
     * @return int
     */
    public function getAmountOfYears(Recognizer $startDate, Recognizer $endDate) : int {
        $years = abs($startDate->year - $endDate->year);
        if ($years !== 0) {
            $years = $this->decrementLastYearIfNotFull($startDate, $endDate, $years);
        }

        return $years;
    }

    public function getMouths(Recognizer $startDate, Recognizer $endDate) : int {
        $months = abs($startDate->month - $endDate->month);

        if ($months === 1 && $startDate->days < $endDate->days && $months !== 0) {
            $months--;
        }
        return $months;
    }

    public function getDays(Recognizer $startDate, Recognizer $endDate) : int {
        $calendar = new Calendar($endDate->year);

        $days = abs($startDate->days - $endDate->days);
        $months = $this->getMouths($startDate, $endDate);
        $startDateMonth = $startDate->month;

        if ($months === 0 && $endDate->days > $startDate->days) {
            $days = $calendar->getNumberOfDaysInMonth($startDateMonth) + $startDate->days - $endDate->days;
        }

        return $days;
    }

    public function getAmountOfDaysBetweenYears(Recognizer $startDate, Recognizer $endDate) : int {
        $daysTotal = 0;
        $this->decrementLastYearIfNotFull($startDate, $endDate, $endDate->year);
        $startYear = $startDate->year;
        $endYear = $endDate->year;

        for (; $startYear < $endYear; $startYear++) {
            $startYear % 4 === 0 ? $daysTotal =+ 365 : $daysTotal =+ 364;
        }

        return $daysTotal;
    }

    public function getMonthsDays(Recognizer $startDate, Recognizer $endDate) : int {
        $daysTotal = 0;
        $calendar = new Calendar($endDate->year);
        $monthsArray = $this->getMonthsAsArray($startDate->month, $endDate->month);

        // if difference between months is 1, means its could be not ended
        if (abs($monthsArray['startMonth'] - $monthsArray['endMonth']) !== 1) {
            for (; $monthsArray['startMonth'] < $monthsArray['endMonth']; $monthsArray['startMonth']++) {
                if ($monthsArray['startMonth'] + 1 !== $monthsArray['endMonth']) {
                    $daysTotal += $calendar->getNumberOfDaysInMonth($monthsArray['startMonth']);
                } else {
                    $daysTotal += $calendar->getNumberOfDaysInMonth($monthsArray['startMonth']) - $endDate->days + $startDate->days;
                }
            }
        } else {
            // if month is ended
            if ($monthsArray['startMonth'] < $monthsArray['endMonth']) {
                $daysTotal = $calendar->getNumberOfDaysInMonth($monthsArray['startMonth']) - $endDate->days + $startDate->days;
                if ($daysTotal > 31) {
                    $daysTotal = 31;
                }
            }
        }

        return $daysTotal;

    }

    /**
     * Checks is last year has been ended. If not - decrement variable passed as third parameter
     * (which represents count of years)
     *
     * @param Recognizer $startDate
     * @param Recognizer $endDate
     * @param int $decrementVariable
     * @return int
     */
    private function decrementLastYearIfNotFull(Recognizer $startDate, Recognizer $endDate, int $decrementVariable) : int {
        if (
            (
                $startDate->month > $endDate->month || (
                    $startDate->month === $endDate->month && $startDate->days > $endDate->days
                )
            )
        ) {
            $decrementVariable--;
        }

        return $decrementVariable;
    }

    /**
     * Returns as array values of months, and sorts it for usage
     * @param $startMonth
     * @param $endMonth
     * @return array
     */
    private function getMonthsAsArray(int $startMonth, int $endMonth) : array {
        if ($startMonth > $endMonth) {
            $array = [
              'startMonth' => $startMonth,
              'endMonth' => $endMonth,
            ];
        } else {
            $array = [
                'startMonth' => $endMonth,
                'endMonth' => $startMonth,
            ];
        }

        return $array;
    }
}