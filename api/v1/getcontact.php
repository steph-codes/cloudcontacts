<?php


include('../../contactclasses.php');
$obj = new Contacts;



 $contact_id = 2;
$output = $obj->getcontact($contact_id);//col name
echo $output; 

?>