<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 14.10.2017
 * Time: 13:19
 */

namespace Date;

use Date\Count;

class Date
{
    protected $years;
    protected $months;
    protected $days;
    protected $totalDays;
    protected $invent = false;


    public function __construct(string $rawStartDate, string $rawEndDate) {
        $startDate = new Recognizer($rawStartDate);
        $endDate = new Recognizer($rawEndDate);
        $count = new Count();

       if ($startDate > $endDate) {
           $this->invent = $count->setInvent();
       }

        $this->years = $count->getYears($startDate, $endDate, $this->invent);
        $this->months = $count->getMouths($startDate, $endDate, $this->invent);
        $this->days = $count->getDays($startDate, $endDate, $this->invent);
        $this->totalDays = $count->getTotalDifference($startDate, $endDate, $this->invent);

        $this->notificateDifference($rawStartDate, $rawEndDate, $this->years, $this->months, $this->days, $this->totalDays);
    }


    private function notificateDifference(string $firstDate, string $secondDate, int $years, int $months, int $days, int $totalDays) {
        $text = '<br>Difference between ' . $firstDate . ' and ' . $secondDate . ' :<br>';
        if ($years) {
            $text .= $years . ' years ';
        }

        if ($months) {
            $text .= $months . ' months ';
        }

        if ($days) {
            $text .= $days . ' days ';
        }

        $text .= '<br>';
        $text .= 'Total difference in days : '. $totalDays;

        echo $text;
    }

}