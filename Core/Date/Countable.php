<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 14.10.2017
 * Time: 11:22
 */

namespace Date;

/**
 * abstract class Count
 *
 * @var int $years
 * @var int $months
 * @var int $days
 * @var int $totalDays
 * @var bool $invent
 *
 */

abstract class Countable {

    abstract public static function getTotalDifference(Recognizable $recognizable, Recognizable $recognizable2);

    abstract public static function getYears($start, $end);

    abstract public static function getMouths($start, $end);

    abstract public static function getDays($start, $end);

    abstract public static function setInvent();


}