<?php

    //if(session_status()==PHP_SESSION_NONE)
    //    session_start();

    require("PHP files" . DIRECTORY_SEPARATOR . "footer.php");
    require("PHP files" . DIRECTORY_SEPARATOR . "header.php");

    printPage();

    function printPage() {
    //echo $_SESSION["username"];
    printTop();
    gen_Navbar("login");
    printBody();
    genIncludes_End();
    footer();
    echo "</html>";
    }

    function printTop() {
        echo "
        <!DOCTYPE html>
        <html lang=\"en\">
        <link rel=\"stylesheet\" href=\"style_sheets/my_styles.css\">
        <link rel=\"stylesheet\" href=\"style_sheets/signup.css\">
        <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\">
        <head>
        <meta charset=\"UTF-8\">
        <title>Login</title>
        </head>
        <body>
        ";
    }

    function printBody() {
        echo "
        <div id=\"loging-head\">Login to GameCulture</div>
        <div id=\"response-fail\">
        <label>User not found</label>
        </div>
        <div id=\"response-logged\">
        <label id\" response-login\">Logged in!</label>
        </div>
        <form id=\"login-form\">
        <label class=\"labels\" for=\"email\">Email</label><br>
        <input class=\"fields\" id=\"email\" value=\"LiamBurgess299@gmail.com\"><br>
        <label class=\"labels\" for=\"password\">Password</label><br>
        <input type=\"password\" class=\"fields\" id=\"password\" value=\"pass\">
        <input class=\"cb\" type=\"checkbox\" id=\"showpass\"><br><br>
        <input class=\"subButton\" type=\"button\" id=\"login-button\" value=\"Login!\">
        </form>
        </body> 
        ";
    }

    function genIncludes_End() {
        echo "
            <script src=\"https://code.JQuery.com/JQuery-3.4.1.min.js\"></script>
            <script src=\"Javascript_and_Jquery/general.js\"></script>
            <script src=\"Javascript_and_Jquery/login.js\"></script>
            ";
    }

