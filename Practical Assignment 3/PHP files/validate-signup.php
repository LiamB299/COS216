<?php

    //validate and submit user
    require("config.php");

    function response_post($jason) {
        header("HTTP/1.1 200 OK");
        header("Content-Type: application/json");

        echo json_encode (
            $jason
        );
    }

    //===========================================
    if(all_set()) {
        //validate user
        if(validate_email($_POST["email"])==false || validate_password($_POST["password"], $_POST["con_password"])==false || validate_fields()==false) {
            //echo "here";
            return;
        }
        else
            submit_user(hash_pass($_POST["password"]));
    }
    else if(isset($_POST["end"])) {
        end_session();
        return;
    }
    else {
        response_post([
            "command" => "empty-parameter"
        ]); 
        return;
    }

    function all_set() {
        //isset($_POST["id"]) &&
        return isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["email"]) && 
            isset($_POST["password"]) && isset($_POST["con_password"]);
    }

    //============================================
    
    //============================================
    function validate_password($pass, $con_pass) {
        //matching error
        if($pass!=$con_pass) {
            response_post([
                "command" => "match-pass"
            ]);
            return false;
        }
        //regex error
        else if(false) {
            response_post([
                "command" => "regex-pass"
            ]);
                return false;
        }
        //length error
        else if(strlen($pass)<8) {
            response_post([
                "command" => "length-pass"
            ]);
                return false;
        }
        //echo "pass valid";
        return true;
    } 

    function validate_email($email) {
        if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",$email)) {
            response_post([
                "command" => "regex-email"
            ]);
                return false;
        }
        if($GLOBALS["db"]->validate_email($email)==false) {
            response_post([
                "command" => "email-already-exists"
            ]);
                return false;
        }
        //echo "email valid";
        return true;
    }

    function validate_fields() {
        //$field = $_POST["id"];
        //if(strlen($field)!=13) {
        //    response_post([
        //        "command" => "id-length"
        //    ]);
        //        return false;
        //}
        //if($GLOBALS["db"]->is_duplicate_id($field)==true) {
        //    response_post([
        //        "command" => "id-already-exists"
        //    ]);
        //        return false;
        //}
        //if(!is_numeric($field)) {
        //    response_post([
        //        "command" => "id-not-number"
        //    ]);
        //        return false;
        //}
        
        $field = $_POST["name"];
        if(!preg_match("/^[a-zA-Z]+$/", $field)) {
            response_post([
                "command" => "name-failure"
            ]);
                return false;
        }

        $field = $_POST["surname"];
        if(!preg_match("/^[a-zA-Z]+$/", $field)) {
            response_post([
                "command" => "surname-failure"
            ]);
                return false;
        }
        return true;
    }

    /****************************************/

    function submit_user($hash) {
        //echo strlen($hash);
        $data = gen_APIkey("requests");
        
        //$info = "'".$GLOBALS["db"]->NumberUsers()."',"."'".$_POST["name"]."',"."'".$_POST["surname"]."',"."'".$_POST["email"]."',"."'".$hash."',"."'".$data["key"]."',"."'".$data["secret"]."'";
        $info["num"] = $GLOBALS["db"]->NumberUsers();
        $info["name"]= $_POST["name"];
        $info["surname"] = $_POST["surname"];
        $info["email"] = $_POST["email"];
        $info["hash"] = $hash;
        $info["key"] = $data["key"];
        $info["secret"] = $data["secret"];
        //echo $info;
        $GLOBALS["db"]->InsertRecord($info);

        //submit to database
        response_post([
            "command" => "user-submitted",
            "key" => $data["key"]
        ]);
            //end_session();
        return;
    } 

    /***************************************/
    //hash function
    //SHA-- options are not considered secure
    //Argon standards are considered secure
    function hash_pass($password) {
        $salt = substr($password,0, strlen($password)/2);
        $pass = $_POST["password"] . $salt;
        $pass = password_hash($pass, PASSWORD_ARGON2I);
        $pos = strpos($pass,"p=");
        return substr($pass, $pos+2, strlen($pass)-$pos+1);
    }


    //basic API key = hash of user number in db + a random number + their email
    // the random number may be regenerated if the key is in use.

    //signature:
    //hash a value -> digest
    //encrypt using secret key
    //
    function gen_APIkey($priv="requests") {
        $secret = substr(hash("sha256", $_POST["surname"] . $_POST["email"]), 2, 10);
        $key = $GLOBALS["db"]->NumberUsers(). random_int(1000,10000) . $_POST["email"];//.$priv;
        //$key .= pad($key);
        //more advanced security option uses a private key
        //and encryption
        //$key = openssl_encrypt($key, "AES-128-CTR", $secret); 
        
        //$key = base64_encode($key);
        $key = substr(md5($key),0,10);
        while($GLOBALS["db"]->validate_Key($key)==true) {
            $key = $GLOBALS["db"]->NumberUsers(). random_int(1000,10000) . $_POST["email"];
            $key = substr(md5($key),0,10);
        }
        $ret = array("secret" => $secret,
            "key" => $key);
        return $ret;
    }

    function pad($line) {
        $length = 20 - strlen($line);
        if($length<=0)
            return;
        return str_pad($line, 20-strlen($line), "#");
        //return openssl_random_pseudo_bytes ($length);
    }

