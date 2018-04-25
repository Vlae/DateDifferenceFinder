<?php

namespace Date;

interface Countable {
    public function getTotalDifference(Recognizer $startDate, Recognizer $endDate) : int;

    public function getAmountOfYears(Recognizer $startDate, Recognizer $endDate) : int;

    public function getMouths(Recognizer $startDate, Recognizer $endDate) : int;

    public function getDays(Recognizer $startDate, Recognizer $endDate) : int;

    public function getAmountOfDaysBetweenYears(Recognizer $startDate, Recognizer $endDate) : int;
}
