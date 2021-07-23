

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The Poets</title>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <style type="text/css">
        .box {
            width:250px;
            height:250px;
            float:left;
            border:1px solid #000000;
        }
        .imgsize{
            width:200px;
            height:200px;
        }
        </style>
    </head>
    <body>
    <?php
//we are given the URL
    $url =  "https://naijapoetry.com/api/PoetsAPI";
//step1 : initialize CURL
    $curlsession = curl_init();
//step 2: set curl options, set the baseurl and endpoint and the methods,just as it is done in postman curl_setopt(option,value)
    curl_setopt($curlsession, CURLOPT_URL, $url);
    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER,true);//set curl_opt return transfer to true, return a string so we can consume GET api endpoint ,step:3 under options execute CURL i.e this is the curl ur executing, the result is stored in response, can do a print_r of response
    curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false);//allows u connect with SSl
//step:3 execute curl 
    $response = curl_exec($curlsession);
    $errors = curl_error($curlsession);
//step 4:close curl session and parse the initiliazed curl session
    curl_close($curlsession);
   
    if($errors){
        echo $errors;
    }else{
        // echo"<pre>";
        // print_r($response);
        // echo"</pre>";
    }
    $result = json_decode($response);// it has been changed to an object here
    //  echo"<pre>";
    //     print_r($result);
    //     echo"</pre>";
    if(count($result)>0){
    foreach($result as $key=> $value){

   
?>
    <div class="box">
        <?php if($value->PoetImageUrl!=""){ ?>
        <img src="<?php echo "https://naijapoetry.com".$value->PoetImageUrl?>"
         alt="<?php echo $value->Firstname ?>"
        class="imgsize">
        <?php }else{ ?>
        <img src="../images/female_avatar.png" alt="<?php echo $value->Firstname ?>"
        class="imgsize">
        <?php } ?>
        <div><?php echo $value->Firstname. "  ".$value->Surname?></div>
    </div>
<?php
        }
    }else{
        echo "no data";
    }
 ?>
    </body>
</html>