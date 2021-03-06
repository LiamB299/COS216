<?php

    require("PHP files" . DIRECTORY_SEPARATOR . "header.php");
    require("PHP files" . DIRECTORY_SEPARATOR . "footer.php");

    buildPage();

    function buildPage() {
        buildtop();
        gen_Navbar("calendar");
        buildrest();
        footer();
        echo "</html>";
    }

    function buildtop() {
        echo "
        <!DOCTYPE html>
        <link rel=\"stylesheet\" href=\"style_sheets/calendar_styles.css\">
        <link rel=\"stylesheet\" href=\"style_sheets/my_styles.css\">
        <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\"> 
        <html>
            <title>
                Calendar
            </title>
            <body>
        ";
    }

    function buildrest() {
        echo "
        <div class=\"loader\" id=\"calendar-loader\">
            <img src=\"images/Animations/loading_grey.svg\" style=\"height: 100%; width: 100%;\">
        </div>
        <div id=\"grid-base\" class=\"grid-container\">
            <div class=\"grid-item\" id=\"title\">
                <div class=\"grid-item-two grid-container\">
                    <div class=\"grid-item\" id=\"day-of-month\">
                        1
                    </div>
                    <div class=\"grid-item\" id=\"month\">
                        2
                    </div>
                    <div class=\"grid-item\" id=\"year\">
                        3
                    </div>
                </div>
            </div>
            <div class=\"grid-item buttons\" id=\"prev-month\">
                Previous Month
            </div>
            <div class=\"grid-item buttons\" id=\"today\">
                Today!
            </div>
            <div class=\"grid-item buttons\" id=\"next-month\">
                Next Month
            </div>
            <div class=\"grid-item days\" id=\"sunday\">
                Sunday
            </div>
            <div class=\"grid-item days\" id=\"monday\">
                Monday
            </div>
            <div class=\"grid-item days\" id=\"tuesday\">
                Tuesday
            </div>
            <div class=\"grid-item days\" id=\"wednesday\">
                Wednesday
            </div>
            <div class=\"grid-item days\" id=\"thursday\">
                Thursday
            </div>
            <div class=\"grid-item days\" id=\"friday\">
                Friday
            </div>
            <div class=\"grid-item days\" id=\"saturday\">
                Saturday
            </div>
            <div class=\"grid-item entry\" id=\"entry-0\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-1\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-2\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-3\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-4\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-5\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-6\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-7\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-8\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-9\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-10\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-11\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-12\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-13\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-14\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-15\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-16\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-17\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-18\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-19\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-20\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-21\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-22\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-23\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-24\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-25\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-26\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-27\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-28\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-29\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-30\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-31\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-32\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-33\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-34\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-35\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-36\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-37\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-38\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-39\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-40\">

            </div>
            <div class=\"grid-item entry\" id=\"entry-41\">

            </div>

            <div class=\"grid-item\">
                <input type=\"submit\" id=\"submit\" value=\"Print to JSON\">
            </div>

        </div>
        <div id=\"jasonify\">
            text
        </div>
        
    </body>
    <script src=\"https://code.JQuery.com/JQuery-3.4.1.min.js\"></script>
    <script src=\"Javascript_and_Jquery/calendar.js\"></script>
    <script src=\"Javascript_and_Jquery/general.js\"></script>
        ";
    }

?>