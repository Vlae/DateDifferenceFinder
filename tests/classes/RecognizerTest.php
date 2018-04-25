<?php

use Date\Recognizer;

class RecognizerTest extends PHPUnit_Framework_TestCase {
    /**
     * @dataProvider dataProvider
     * @var $years
     * @var $months
     * @var $days
     * @var $date
     */
    function testGetDateFromString(int $years, int $months, int $days, string $date){
        $recognizer = new Recognizer($date);
        $this->assertEquals($years, $recognizer->years);
        $this->assertEquals($months, $recognizer->months);
        $this->assertEquals($days, $recognizer->days);
    }

    /**
     * @dataProvider exceptionProvider
     * @expectedException Error
     * @var $wrongString
     */
    function testGetDateFromStringException(string $wrongDate) {
        new Recognizer($wrongDate);
    }

    /**
     * @dataProvider dateProvider
     * @var $date
     */
    function testCheckMonths(string $date) {
        $recognizer = new Recognizer($date);
        $this->assertTrue($recognizer->checkMonths($recognizer->months));
    }

    /**
     * @dataProvider dateProvider
     * @var $date
     */
    function testCheckDays(string $date) {
        $recognizer = new Recognizer($date);
        $this->assertTrue($recognizer->checkDays($recognizer->days, $recognizer->months, $recognizer->years));
    }

    /**
     * @expectedException Error
     */
    function testCheckDays1() {
        $recognizer = new Recognizer('2015-11-32');
        $this->assertFalse($recognizer->checkDays($recognizer->days, $recognizer->months, $recognizer->years));
    }

    public function dataProvider()
    {
        return [
            [2012, 1, 13, '2012-01-13'],
            [1992, 06, 27, '1992-06-27'],
            [1003, 12, 10, '1003-12-10'],
            [2018, 4, 18, '2018-04-18'],
        ];
    }

    public function dateProvider() {
        return [
            ['2012-01-13', '1992-06-27', '1003-12-10', '2018-04-18']
        ];
    }

    public function exceptionProvider() {
        return [
            ['12-01-13', '2015-06-33', '1003-19-10']
        ];
    }


}