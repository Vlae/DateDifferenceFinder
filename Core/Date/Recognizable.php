<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 14.10.2017
 * Time: 10:31
 */

namespace Date;


interface Recognizable
{
    public function getDateFromString(string $date): string;

    public function checkMonths(int $months): bool;

    public function checkDays(int $days, int $month,  int $year): bool;

}