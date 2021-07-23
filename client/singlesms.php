<?php

$message = 'Happy Birthday';
$senderid = '07032519605';
$to = '07032519605';
$token = 'Idv4WB1uLF6C5glthStrhoRKuFaarmUrfsRUjl0Ghy7RloLQW6p6bQYGfT1ruuxaouLrOeARRs3EucdzslkvIYn85uhbPSBbZpMH';
$baseurl = 'https://smartsmssolutions.com/api/json.php?';

$sms_array = array 
  (
  'sender' => $senderid,
  'to' => $to,
  'message' => $message,
  'type' => '0',
  'routing' => 3,
  'token' => $token
);

$params = http_build_query($sms_array);
$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL,$baseurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$errors = curl_error($ch);

curl_close($ch);

if($errors){
    echo $errors;
}

echo"<pre>";
print_r($response);
echo"</pre>"; // response code

?>