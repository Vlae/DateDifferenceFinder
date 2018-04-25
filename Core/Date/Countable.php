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

    abstract public function getTotalDifference(Recognizer $startDate, Recognizer $endDate, bool $invented) : int;

    abstract public function getYears(Recognizer $startDate, Recognizer $endDate, bool $invented) : int;

    abstract public function getMouths(Recognizer $startDate, Recognizer $endDate, bool $invented) : int;

    abstract public function getDays(Recognizer $startDate, Recognizer $endDate, bool $invented) : int;

    abstract public function setInvent() : bool;


}