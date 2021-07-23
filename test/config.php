<?php
namespace Thirdparty\App;

class DatabaseConfig{
    //member variables
    public $dbcon; //database connection handler

    //member method
    public function __construct(){
        //create connection by instantiating my sqli class.
        // represent global namespace
        $this->dbcon = new \Mysqli("localhost","root","","contactsappdb");
        // check connection
        if($this->dbcon->connect_error){
            die('Connection Failed'.$this->dbcon->connect_error);
        }else{
            echo"successful, this is third party config";
        }
    }
}

?>