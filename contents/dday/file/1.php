<p class='dday'>개학
<?php
$date = '2020-04-06';
$todate = date("Ymd");
$ddy = (strtotime($todate) - strtotime($date)) / 86400;
echo 'D'.$ddy;
?>