<?php  
    require("PHP files" . DIRECTORY_SEPARATOR . "header.php");
    require("PHP files" . DIRECTORY_SEPARATOR . "footer.php");

    genHeaders();
    gen_Navbar("signup");
    genForm();
    footer();
    genIncludes_End();
    echo "</html>";

    function genHeaders() {
        echo "
        <!DOCTYPE html>
        <link rel=\"stylesheet\" href=\"style_sheets/my_styles.css\">
        <link rel=\"stylesheet\" href=\"style_sheets/signup.css\">
        <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\">
        <html>
        <body>
        ";
    }

    function genForm() {
        echo "
        <form id=\"dataform\">
        <div class=\"sections\">Details</div><br>
        <!-----<label class=\"labels\" for=\"id_no\">Identification Number:</label><br>
        <input class=\"fields\" type=\"text\" id=\"id_no\" name=\"id_no\" value=\"9904275018069\"><br><br>--->
        <label class=\"labels\" for=\"name\">Name:</label><br>
        <input class=\"fields\" type=\"text\" id=\"name\" name=\"name\" value=\"Liam\"><br><br>
        <label class=\"labels\" for=\"surname\">Surname:</label><br>
        <input class=\"fields\" type=\"text\" id=\"surname\" name=\"surname\" value=\"Burgess\"><br><br><br>
        <div class=\"sections\">Login information</div><br>
        <label class=\"labels\" for=\"email\">Email:</label><br>
        <input class=\"fields\" type=\"text\" id=\"email\" name=\"email\" value=\"LiamBurgess@gmail.com\"><br><br>
        <label class=\"labels\" for=\"password\">Password:</label><br>
        <input class=\"fields\" type=\"password\" id=\"password\" name=\"password\" value=\"Pass29@@\"><br>
        <label class=\"labels cb\">show password</label>
        <input class=\"checkboxes\" type=\"checkbox\" id=\"pass1\"><br><br> 
        <label class=\"labels\" for=\"con-password\">Confirm password:</label><br>
        <input class=\"fields\" type=\"password\" id=\"con-password\" name=\"con-password\" value=\"Pass29@@\"><br>
        <label class=\"labels cb\">show password</label>
        <input class=\"checkboxes\" type=\"checkbox\" id=\"pass2\"> 
        <br>
        <br><br><br>
        <input class=\"subButton\" id=\"button-signup\" type=\"button\" value=\"Sign-Up!\"><br><br>
        </form>
        </body>
        ";
    }

    function genIncludes_End() {
        echo "
        <script src=\"https://code.JQuery.com/JQuery-3.4.1.min.js\"></script>
        <script src=\"Javascript_and_Jquery/general.js\"></script>
        <script src=\"Javascript_and_Jquery/signup.js\"></script>
        ";
    }


?>