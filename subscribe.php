<!DOCTYPE html>
<html lang="en">
    <head>
        <title>subscribe</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
    <?php

    // echo"<pre>";
    // print_r($_SERVER);
    // echo"</pre>";

 //at first its GET, when submitted it return error, cos it has been posted as it needs parameter
    if($_SERVER['REQUEST_METHOD']=='POST'){
        //create object of subscription class
        include("contactclasses.php");

        $obj = new Subscription;

        //make reference to intialized paystack method
        $output =$obj->initializePaystack($_POST['email'],$_POST['amount']);
        //gives the authorization url link
    //     echo"<pre>";
    // print_r($output);
    // echo"</pre>";
    $authorization_url = $output->data->authorization_url;

    header("location: $authorization_url");

    }
    ?>
    <!-- this form contained required parameters or field by paystack -->
    <form action="" method="POST">
    <!--remember fee is in kobo-->
    <input type="email" name="email" placeholder="email address">
    <!-- <input type="hidden" name="amount" value="500000"><br> -->
    <select name="amount">
        <option value="230000">&#8358; 2300 per month</option><!--add hidden field to add subtype-->
        <option value="2760000">&#8358; 27,600.00 per month</option>
    </select>
    <input type="submit" name="submit" value="Subscribe Now">
    </form>
    </body>
</html>