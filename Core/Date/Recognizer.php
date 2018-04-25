<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * DateOutput: 14.10.2017
 * Time: 10:51
 */

namespace Date;

class Recognizer {
    protected $maxMonths = 12;

    public $year;
    public $month;
    public $days;

    public function __construct(string $date) {
        $this->getDateFromString($date);
    }


    /**
     * Gets date from string formatted by «YYYY-MM-DD», if string isn't date - pops error
     * @var $date
     * @return boolean|\Error
     */

    public function getDateFromString(string $date): bool {
        $pattern = '/(\d{4})\-(\d{2})\-(\d{2})/';

        if (1 === preg_match($pattern, $date, $matches)) {
            $this->year = (int) $matches[1];
            $this->month = (int) $matches[2];
            $this->days = (int) $matches[3];

            if ($this->checkMonths($this->month) && $this->checkDays($this->days, $this->month, $this->days)) {
                return true;
            } else {
                throw new \Error('Incorrect mounts or days inserted', 1);
            }
        } else {
            throw new \Error('"' . $date . '" is incorrect format of date, insert date in «YYYY-MM-DD» format', 2);
        }
    }

    /**
     * @var int $months
     * @return bool
     */
    public function checkMonths(int $months): bool {
        $bool = true;
        if ($months > $this->maxMonths || $months < 1) {
            $bool = false;
        }

        return $bool;
    }

    /**
     * @var int $months
     * @var int $month
     * @var int $year
     * @return bool
     */
    public function checkDays(int $days, int $month,  int $year): bool {
        $bool = true;
        $calendar = new Calendar($year);

        if ($days > $calendar->getNumberOfDaysInMonth($month)) {
            $bool = false;
        }

        return $bool;
    }



}