<?php

class Database {
    public static function instance() {
        static $instance = null;
        if($instance === null)
            $instance = new Database();
        return $instance;
    }

    private $host = "localhost";
    private $user = /*"u18015001";//*/"root";
    private $pass = /*"ORW5ZEPNIWANRQGTICMKOLHXDYVVBQVX";//*/"L19m2992@root";
    private $name = /*"u18015001_gameculture";//*/"gameculture";

    //connect first time 
    private function __construct() {
        $connection = new mysqli($this->host, $this->user, $this->pass);

        if($connection->connect_error) 
            die("First time connection failure -> " . $connection->connect_error);
    
        $connection->select_db($this->name);
        //echo "First time success!";
        $connection->close();
    }

    //connect 
    private function connect() {
        $connection = new mysqli($this->host, $this->user, $this->pass);

        if($connection->connect_error) 
            die("Connection failure -> " . connect_error);
    
        $connection->select_db($this->name);
        //echo "Connection success!";
        return $connection;
    }

    private function close($connection) {
        $connection->close();
    }

    //disconnect
    public function __destruct() {
    }

    //perform insert and return result, if any.
    public function InsertRecord($info) {
        if($info==null) {
            echo "No data to input";
            return;
        }

        $connection = $this->connect();

        $query = $connection->prepare("INSERT INTO Users VALUES (?, ?, ?, ?, ?, ?, ?)");

        $query->bind_param("sssssss",$info["num"],$info["name"],
            $info["surname"],$info["email"],$info["hash"], $info["key"], $info["secret"]);

        //if($connection->query($query) === true) {
        if($query->execute() === true) {
            //echo "insert sucessful";
            return;
        }
        else {
            echo "Insert error, data: ".$connection->query." \n error info:".$connection->error;
        }

        $this->close($connection);
    }

    //perform duplicate validation and return result
    //defunct
    public function is_duplicate_id($id) {
        $connection = $this->connect();
        
        $query = "SELECT * FROM Users WHERE id=\"".$id."\"";
        //echo $query;
        $reply = $connection->query($query);

        $this->close($connection);

        if($reply->num_rows >0)
            return true;
        
        return false;
    }


    //perform duplicate validation and return result
    public function validate_email($email) {
        $connection = $this->connect();
        $query = "SELECT * FROM Users WHERE email=\"".$email."\"";
        $reply = $connection->query($query);

        //$query = $connection->prepare("SELECT * FROM Users WHERE email=?");
        //$query->bind_param("s", $email);
        //$query->execute();

        $this->close($connection);

        if($reply->num_rows >0)
            return false;
        
        return true;
    }

    public function validate_Key($key) {
        $connection = $this->connect();
        $query = "SELECT * FROM Users WHERE API_Key=\"".$key."\"";
        $reply = $connection->query($query);
        //echo $query;
        //echo $reply;
        //echo $reply->num_rows;
        $this->close($connection);
        if($reply->num_rows >0)
            return true;
        return false;
    }

    public function NumberUsers() {
        $connection = $this->connect();
        $query = "SELECT * FROM Users";
        $ret = ($connection->query($query))->num_rows;
        //echo "ret: ".$ret;
        $this->close($connection);
        return $ret;
    }
}