<?php
$trans_date ="2021-02-25 01:02:45";

//transdate is the date of transaction not the current date.
$end_date = date('Y-m-d h:i:s', strtotime("+30 days", strtotime($trans_date)));

$end_date2 = date('Y-m-d h:i:s', strtotime("+365 days", strtotime($trans_date)));//int
echo $end_date ."<br>";
echo $end_date2;

?>