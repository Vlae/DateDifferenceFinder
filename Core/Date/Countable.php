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

    abstract public static function getTotalDifference(Recognizer $startDate, Recognizer $endDate, bool $invent) : int;

    abstract public static function getYears(Recognizer $startDate, Recognizer $endDate, bool $invent) : int;

    abstract public static function getMouths(Recognizer $startDate, Recognizer $endDate, bool $invent) : int;

    abstract public static function getDays(Recognizer $start, Recognizer $end, bool $invent) : int;

    abstract public static function setInvent() : bool;


}