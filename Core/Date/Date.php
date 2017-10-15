<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 14.10.2017
 * Time: 13:19
 */

namespace Date;

class Date
{
    protected $years;
    protected $months;
    protected $days;
    protected $totalDays;
    protected $invent = false;


    public function __construct(string $sDate, string $eDate) {
        $date = new Recognizer($sDate);
        $endDate = new Recognizer($eDate);

       if ($sDate > $eDate) {
           $this->invent = Count::setInvent();
       }

        $this->years = Count::getYears($date, $endDate, $this->invent);
        $this->months = Count::getMouths($date, $endDate, $this->invent);
        $this->days = Count::getDays($date, $endDate, $this->invent);
        $this->totalDays = Count::getTotalDifference($date, $endDate, $this->invent);

        $this->notificateDifference($sDate, $eDate, $this->years, $this->months, $this->days, $this->totalDays);
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