<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 14.10.2017
 * Time: 11:05
 */

require_once 'vendor/autoload.php';

use Date\Date;

?>

<form action="index.php" method="post">
    <input type="text" name="startDate" placeholder="Enter start date">
    <input type="text" name="endDate" placeholder="Enter end date">
    <input type="submit" value="submit">
</form>


<?php

//if ( isset($_POST) ) {
//    $post = $_POST;
//    if (!empty($post['startDate']) && !empty($post['endDate'])) {
//        $count = new Date($post['startDate'], $post['endDate']);
//    } else {
//        new Error('Both inputs shouldn\'t be empty!', 691);
//    }
//}

new Date('2015-12-13', '2015-11-12');
new Date('2015-11-12', '2015-12-13');

echo '<br>';

new Date('2013-12-13', '2015-11-12');
new Date('2015-11-12', '2013-12-13');

echo '<br>';

new Date('2013-05-13', '2015-11-12');
new Date('2015-11-12', '2013-05-13');

echo '<br>';

new Date('2010-05-13', '2015-11-12');
new Date('2015-11-12', '2010-05-13');
?>