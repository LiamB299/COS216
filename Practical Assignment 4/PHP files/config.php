<?php

    //if(session_status()==PHP_SESSION_NONE) {
        session_start();
    //}

    //var_dump($_SESSION["logged_in"]);

    require("database.php");

//=============================================

    EstablishDatabase();

    if(isset($_POST["login"])) {
        //var_dump($_POST["login"]);
        if($_POST["login"]=="true") {
            //validate login - P4
            $_SESSION["logged_in"]=true;
            $_SESSION["username"]="Test User";
            response(["user" => "Test User"]);
        }
        else {
            //echo "Test out";
            $_SESSION["logged_in"]=false;
            $_SESSION["username"]="";
            //end_session();
            response([]);
        }
    }
    else {
        //do nothing
    }

//=============================================

    function response($data) {
        header("Content-Type: application/json; charset=UTF-8");
        header("HTTP/1.1 200 OK");

        echo json_encode (
            $data
        );
    }

    function EstablishDatabase() {
        $GLOBALS["db"] = Database::instance();
    }

    function end_session() {
        session_unset();
        session_destroy();
    }

?>