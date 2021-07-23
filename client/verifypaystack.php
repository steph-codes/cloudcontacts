<?php

//var_dump($_REQUEST);
//get reference
$reference = $_GET['reference'];
//create obj of subscription class
include('../contactclasses.php');

$obj = new Subscription;

//access verify payment method
//$id = $_SESSION['userid]
$userid = 1;
$output = $obj->verifyPaystack($reference,$userid);
//var_dump($output);
if($output->data->status=='success'){
    $amount = $output->data->amount /100;
    $paymentmode = 'paystack';
    $trans_date =$output->data->paid_at;
    $subtype ='monthly';
    //insert into subscription table
    $obj->insertSubdata($userid, $subtype, $amount, $reference,$paymentmode,$trans_date);
}else{
    // redirect to failed page
}

?>