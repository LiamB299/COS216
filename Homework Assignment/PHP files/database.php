<?php

class Database {
    public static function instance() {
        static $instance = null;
        if($instance === null)
            $instance = new Database();
        return $instance;
    }

 

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
    public function InsertRecord_users($info) {
        if($info==null) {
            echo "No data to input";
            return;
        }

        $connection = $this->connect();

        $query = $connection->prepare("INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?)");

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
        
        $query = "SELECT * FROM users WHERE id=\"".$id."\"";
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
        $query = "SELECT * FROM users WHERE email=\"".$email."\"";
        $reply = $connection->query($query);

        //$query = $connection->prepare("SELECT * FROM Users WHERE email=?");
        //$query->bind_param("s", $email);
        //$query->execute();

        if($reply->num_rows >0) {
            $this->close($connection);
            return false;
        }
        $this->close($connection);
        return true;
    }

    //perform duplicate validation and return result
    public function is_duplicate_entry($table, $fieldname, $field) {
        $connection = $this->connect();
        $sql = "select * from ".$table." where ".$fieldname."=?";
        $query = $connection->prepare($sql);
        $query->bind_param("s",$field);
        if($query->execute() == false) {
            echo "select error";
        }
        //var_dump($query->num_rows);
        $result = $query->get_result();
        //var_dump($result);
        //var_dump($result->num_rows);
        //$tuples = $result->fetch_all(MYSQLI_ASSOC);
        //var_dump($tuples);
        //var_dump($tuples);
        $this->close($connection);
        //echo $num;
        if($result->num_rows >0) {
            //var_dump("test");
            return true;
        }

        return false;
    }

    // $data must be in order of insertion for db
    public function insert_record($table, $data, $types) {
        //var_dump($data);
        $connection = $this->connect();

        $sql = "INSERT INTO ".$table." VALUES (";

        foreach($data as $val) {
            $sql .= "?, ";
        }
        $sql = substr($sql, 0, strlen($sql)-2);
        $sql .=")";

        $query = $connection->prepare($sql);
        $query->bind_param($types,...$data);

        $res = $query->execute();

        if($res == false) {
            echo $connection->error;
            $this->close($connection);
            return false;
        }
        else {
            $this->close($connection);
            return true;
        }
    }

    // one at a time for simplification
    public function update_record($table, $s_col, $s_new, $w_col, $w_val, $type) {
        $connection = $this->connect();

        $sql = "UPDATE ".$table." SET ".$s_col."=? WHERE ".$w_col."=".$w_val;
        //echo $sql;

        $query = $connection->prepare($sql);
        //if($query === false)
        //    echo $connection.error_get_last();
        $query->bind_param($type,$s_new);

        if($query->execute() == false) {
            echo "update failure";
        }
        $this->close($connection);
        return true;
    }

    public function validate_Key($key) {
        $connection = $this->connect();
        $query = "SELECT * FROM users WHERE API_Key=\"".$key."\"";
        $reply = $connection->query($query);
        //echo $query;
        //echo $reply;
        //echo $reply->num_rows;

        if($reply->num_rows >0) {
            $this->close($connection);
            return true;
        }
        $this->close($connection);
        return false;
    }

    public function getValues($table, $w_col, $w_val, $types, $get="*") {
        $connection = $this->connect();

        if(!is_int($w_col))
            $w_col = "`".$w_col."`";
        $sql = "SELECT ".$get." FROM ".$table." WHERE ".$w_col."=?";
        $query = $connection->prepare($sql);
        //echo $sql;
        $query->bind_param($types, $w_val);

        if($query->execute() == false) {
            echo "select rows failed";
        }

        if($result = $query->get_result()) {
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $this->close($connection);
            return $result;
        }
        else {
            $this->close($connection);
            return null;
        }
    }

    function getValuesCustom($sql) {
        $connection = $this->connect();
        //var_dump($sql);
        $query = $connection->prepare($sql);

        if($query == false)
            echo $connection->error;

        if($query->execute() == false) {
            echo "select rows failed";
        }
        $result = $query->get_result();
        if(is_bool($result)===false) {
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $this->close($connection);
            return $result;
        }
        else {
            if($query->affected_rows==1) {
                $this->close($connection);
                return true;
            }
            return false;
        }
    }


    public function NumberUsers() {
        $connection = $this->connect();
        $query = "SELECT * FROM users";
        $ret = ($connection->query($query))->num_rows;
        //echo "ret: ".$ret;
        $this->close($connection);
        return $ret;
    }
}