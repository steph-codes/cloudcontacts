<?php

// database connection class
class DatabaseConfig{
    //member variables
    public $dbcon; //database connection handler

    //member method
    public function __construct(){
        //create connection by instantiating my sqli class.
        $this->dbcon = new Mysqli("localhost","root","","contactsappdb");
        // check connection
        if($this->dbcon->connect_error){
            die('Connection Failed'.$this->dbcon->connect_error);
        }else{
            //echo"successful";
        }
    }
}

// contacts class definition start here
class Contacts{
    // member variables
    public $dbobj;
    public $nickname;
    public $fullname;
    public $gender;
    public $phonenumber;
    public $emailaddress;
    public $meetat;
    public $userid;
    public $contact_id;
    //column names 

    //member method
    public function __construct(){
        //create obj or instantiate DatabaseConfig class
        $this->dbobj = new DatabaseConfig;
    }
    public function createContact($mynickname,$myfullname,$mygender,$myphonenumber,
    $myemail,$mymeetat,$myuserid){
       //write sql query //column name in brackets ,values as parameters
       $sql = "INSERT INTO contacts(user_id,nickname,fullname,phonenumber,emailaddress,gender,meetat)
        VALUES('$myuserid' ,'$mynickname','$myfullname','$myphonenumber','$myemail','$mygender','$mymeetat')";
        //run the query
        if($result=$this->dbobj->dbcon->query($sql)){
            // $data = $result->fetch_assoc();//fetch_all fetches all
            // $jsondata = json_encode($data); //convert to json
            $response = <<<RES
            {
                "status":true,
                "message":"Contact creation was successful",
                "data": []
            }
            RES;
        }else{
            $response = <<<RES
            {
                "status": false,
                "message":"Oops!, could not create Contact",
                "data":[]
            }
        RES; 
        }
        return $response;
    }
    //get all contacts
    function getcontacts(){
        //write query
        $sql =" SELECT * from contacts";
        //execute/run query
        if($result = $this->dbobj->dbcon->query($sql)){
            $output = $result->fetch_all(MYSQLI_ASSOC);
            $jsondata = json_encode($output);    
            //array to json
            
            $response = <<<RES
            {
            "status":true,
            "message":"list of contacts",
            "data":$jsondata
            }
            RES;
            
        }else{
            $error = $this->dbobj->dbcon->error;
            $response="
            'status': false;
            'message':'oops!; Could not display Contacts',
            'data':$error
            ";
        }
        return $response;
    }
    function getcontact($mycontactid){
        $sql="SELECT * FROM contacts WHERE contact_id ='$mycontactid'";
        if($result=$this->dbobj->dbcon->query($sql)){
            $output = $result->fetch_assoc();
            $jsondata = json_encode($output);
            //convert array to json
            $response= <<<RES
            {
            "status":true,
            "message":"list only contact with the specified contactid",
            "data":$jsondata
            }
            RES;
        }else{
            $error = $this->dbobj->dbcon->error;
            $response= <<<RES
            "status":false;
            "message":"Oops!,cant get contact",
            "data":$error
        }
        RES;
        }
        return $response;
    }
    public function update_contacts($mycontactid,$mynickname,$myfullname,$mygender,$myphonenumber,
    $myemail,$mymeetat){
        $sql = "UPDATE  contacts SET nickname='tesla', fullname='elon tesla musk',
        phonenumber='09067589023', meetat='New york city, naija' WHERE contact_id ='$mycontactid'";
        if($result = $this->dbobj->dbcon->query($sql)){
            $output=$result->fetch_assoc();
            $jsondata=json_encode($output);
            //convert to array
            $response= <<<RES
            {
            "status":true,
            "message":"contact successfully updated"
            "data":$jsondata;
            }
            RES;
        }else{
            $error=$this->dbobj->dbcon->error;
            $response= <<<RES
            {
            "status":false,
            "message":"couldnt update, try again",
            "data":$error
            }
            RES;
        }
        return $response;
    }
}

//define subscription class

class Subscription{
    //member variables
    public $dbobj;

    //member methods
    public function __construct(){
        //create obj or instantiate DatabaseConfig class
        $this->dbobj = new DatabaseConfig;
    }
    public function initializePaystack($email, $amount){
        $url = "https://api.paystack.co/transaction/initialize";
        $callback = "http://localhost/cloudcontacts/client/verifypaystack.php";
        $fields = [
            'email' => "$email",
            'amount' => "$amount",
            'callback_url' => $callback
        ];
        $fields_string = http_build_query($fields);//format parameters as query strings
        //open connection
        $ch = curl_init();//step1
        
        //set the url, number of POST vars, POST 
        //step2 setoptions
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);//converts them to query string that endpoint accepts postfield is the data ur sending
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_test_67c2b4cb50d585d1992b576991862e17bdd9fb1e",//you insert ur saved token
            "Cache-Control: no-cache",
        ));//send array to curlopt_httpheader specific header
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        
        //step 3 execute post
        $response = curl_exec($ch);
        $errors = curl_error($ch);
        //step 4 close curl
        curl_close($ch);
        
        if($errors){
            $output = $errors;
        }
        $output =json_decode($response);

        return $output;
    }

    //verify paystack transaction
    //store user id in session userid = $_SESSION
    //refernce is always GET because curl was initially posted, the string returned is in string format that's why we are using GET
    //turning http_build_field($field)turning the $ into a string
    function verifyPaystack($reference, $userid){
        $url="https://api.paystack.co/transaction/verify/$reference";

        //step1: initialize curl session
        $curlsession = curl_init();
        //step2:set  the url headers
        curl_setopt($curlsession, CURLOPT_URL,$url);
        curl_setopt($curlsession, CURLOPT_CUSTOMREQUEST,'GET');
         //curlopt header has an array value, the bearer and test secret, specify cache control as well so it doesnt store the request
        curl_setopt($curlsession, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_test_67c2b4cb50d585d1992b576991862e17bdd9fb1e",
            "Cache-control: no-cache",
        ));
        curl_setopt($curlsession,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false); 
        
        //step:3 execute curl
        $response = curl_exec($curlsession);
        $errors = curl_error($curlsession);

        //step4: close curlsession
        curl_close($curlsession);

        if($errors){
            echo $errors;
        }

        //do whatever you want
        //insert into subsrciption table
        $result = json_decode($response);       


        // echo "<pre>";
        // print_r($response);
        // echo "</pre>";

        return $result;

    }
    //insert into subscription
    public function insertSubdata($userid, $subtype, $amount, $reference,$paymentmode,$trans_date){
        //end date
        //$end_date 
        //format startdate
        $trans_date = date('Y-m-d h:i:s', strtotime($trans_date));

        if($subtype=='monthly'){
            $end_date = date('Y-m-d h:i:s', strtotime("+30 days", strtotime($trans_date)));
        }else{
            $end_date = date('Y-m-d h:i:s', strtotime("+365 days", strtotime($trans_date)));
            
        }
        //write query
        $sql = "INSERT into subscription(user_id, subtype, amount,transid,paymentmode,trans_status,
        start_date,end_date)
        VALUES('$userid', '$subtype', '$amount', '$reference',
        '$paymentmode', 'completed', '$trans_date', '$end_date')";
        //run the query
        //var_dump($sql);
        //exit();
        if($this->dbobj->dbcon->query($sql)==true){
            //redirect to success page
            header("Location: http://localhost/cloudcontacts/paymentsuccess.php");
        }else{
            echo $this->dbobj->dbcon->error;
        }
    }
}
?>