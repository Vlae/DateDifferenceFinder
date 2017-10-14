<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 14.10.2017
 * Time: 11:05
 */

require_once 'vendor/autoload.php';

use Date\Date;

$count = new Date('2015-03-13', '2017-04-16');
echo '<br>';
$count1 = new Date('2017-04-16', '2015-03-13');
echo '<br>';
var_dump($count);
echo '<br>';
var_dump($count1);