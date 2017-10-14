<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 14.10.2017
 * Time: 11:05
 */

require_once 'vendor/autoload.php';

use Date\Count;

$count = new Count('2015-03-05');

var_dump($count);