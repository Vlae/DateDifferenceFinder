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

        $this->totalDays = Count::getTotalDifference($date, $endDate, $this->invent);
        $this->years = Count::getYears($date, $endDate, $this->invent);
        $this->months = Count::getMouths($date, $endDate, $this->invent);
        $this->days = Count::getDays($date, $endDate, $this->invent);


    }

}