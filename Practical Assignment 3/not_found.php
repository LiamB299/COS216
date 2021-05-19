<?php

    require("PHP files" . DIRECTORY_SEPARATOR . "header.php");

    buildPage();

    function buildPage() {
        buildtop();
        gen_Navbar("");
        buildrest();
    }

    function buildtop() {
        echo "
            
        ";
    }

    function buildrest() {
        echo "
        <!DOCTYPE html>
        <html>
            <title>Not found</title>
            <body style=\"text-align: center;\">
                <header style=\"font-size: 150px;\">Error 404!</header>
                <img src=\"images/404_image.jpg\" alt=\"boy with tiger\">
                <p style=\"font-size: 70px;\">Sorry this page is currently under construction</p>
                <button style=\"font-size: 50px; text-decoration: none;\">
                    <a href=\"index.php\">Return to launch page</a>
                </button>
            </body>
        </html>
        ";
    }

    echo "
    <link rel=\"stylesheet\" href=\"style_sheets/my_styles.css\">
        <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\">
        <html><body> 
    ";

?>