<?php
//header to allow people access with access-control-allow-origin,else have cors issues
// it as well as the content type i.e in json format,
// using only POST method
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include('../../contactclasses.php');
//create object of Contacts class
$obj = new Contacts;

//get raw request from body, get json from clientside ,change to array and  send to database
//by default json_decode returns object=false, array=true
$rawdata = file_get_contents("php://input");//POSTED json files are stored in rawdata
$data = json_decode($rawdata);

//insert into contacts table
$userid = 1;
$output =$obj->createContact($data->nickname, $data->fullname, $data->gender, $data->phonenumber,
$data->email, $data->meetat, $userid);

echo $output;
?>