<?php

require("config.php");

if(!isset($_POST["email"])) {
    error_response("Email not set");
    return;
}
if(!isset($_POST["password"])) {
    error_response("Password not set");
    return;
}

if(!$GLOBALS["db"]->is_duplicate_entry("users", "email", $_POST["email"])) {
    error_response("User not found. Please check email");
    return;
}

if(!$GLOBALS["db"]->is_duplicate_entry("users", "password", hash_pass($_POST["password"]))) {
    error_response("Password incorrect");//"The password is incorrect");
    return;
}

response([
    "status" => "success"
]);

function hash_pass($password) {
    //$salt = substr($password,0, strlen($password)/2);
    //$pass = $_POST["password"] . $salt;
    //$pass = password_hash($pass, PASSWORD_ARGON2I);
    //$pos = strpos($pass,"p=");
    //return substr($pass, $pos+2, strlen($pass)-$pos+1);
    return hash("sha512", $password, false);
}
