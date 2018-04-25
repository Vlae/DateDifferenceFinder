<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * DateOutput: 14.10.2017
 * Time: 10:49
 */

namespace Date;

class Calendar {

    protected $daysInYear = 364;
    // defines how much days in each month
    protected $days = [
        1 => 31, // Jun
        2 => 28, // Feb
        3 => 31, // Mar
        4 => 30, // Apr
        5 => 31, // May
        6 => 30, // Jub
        7 => 31, // Jul
        8 => 31, // Aug
        9 => 30, // Sep
        10 => 31, // Oct
        11 => 30, // Nov
        12 => 31 // Dec
    ];

    /**
     * Calendar constructor. Finds out how much years in February
     * @param int $year
     *
     */
    public function __construct(int $year) {
        if ($this->isYearLeap($year)) {
            $this->days[2] = 29;
            $this->daysInYear = 365;
        }
    }

    public function getNumberOfDaysInMonth(int $month) {
        return $this->days[$month];
    }

    public function getNumberOfDaysInYear() {
        return $this->daysInYear;
    }

    public function isYearLeap(int $year) {
        if ($year % 4 === 0) {
            return true;
        }

        return false;
    }

}