<?php

//no data from client application
include('../../contactclasses.php');
//create object of Contacts class
$obj = new Contacts;
$output = $obj->getContacts();
echo $output;

?>