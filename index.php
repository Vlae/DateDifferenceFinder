<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * DateOutput: 14.10.2017
 * Time: 11:05
 */

require_once 'vendor/autoload.php';

use Date\DateOutput;

?>

<form action="index.php" method="post">
    <input type="text" name="startDate" placeholder="First date <<YYYY-MM-DD>>">
    <input type="text" name="endDate" placeholder="End date <<YYYY-MM-DD>>">
    <input type="submit" value="submit">
</form>


<?php

if ( isset($_POST) ) {
    $post = $_POST;
    if (!empty($post['startDate']) && !empty($post['endDate'])) {
        $count = new DateOutput($post['startDate'], $post['endDate']);
    } else {
        new Error('Both inputs shouldn\'t be empty!', 691);
    }
}

new DateOutput('2015-11-25', '2015-11-26');
new DateOutput('2015-11-25', '2015-10-25');
new DateOutput('2015-11-25', '2012-10-26');
new DateOutput('2012-10-26', '2015-11-25');

?>