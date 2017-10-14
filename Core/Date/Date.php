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
    protected $invent;


    public function __construct(string $sDate, string $eDate) {
        $date = new Recognizer($sDate);
        $endDate = new Recognizer($eDate);

       if ($sDate > $eDate) {
           Count::setInvent();
       }

       $this->years = Count::getYears($date->years, $endDate->years);
       $this->months = Count::getMouths($date->months, $endDate->months);
       $this->days = Count::getDays($date->days, $endDate->days);
       $this->totalDays = Count::getTotalDifference($date, $endDate);


    }

}