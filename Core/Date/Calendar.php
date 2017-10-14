<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 14.10.2017
 * Time: 10:49
 */

namespace Date;

class Calendar {
    // defines how much days in each month
    public $days = [
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
     * @param int $years
     *
     */
    public function __construct(int $years) {
        if ($years % 4 === 0) {
            $this->days[2] = 29;
        }

        return $this->days;
    }
}