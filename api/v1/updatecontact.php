<?php

include("../../contactclasses.php");
$obj = new Contacts;

$contact_id = 2;
$output=$obj->update_contacts($contact_id,$userid,$nickname,$fullname,$gender,$phonenumber,
$emailaddress,$meetat);
echo $output;
?>