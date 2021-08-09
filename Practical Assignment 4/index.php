<?php

    printPage();

function printPage() {
    echo "
    <!DOCTYPE html>
<html>
    <link rel=\"stylesheet\" href=\"style_sheets/my_styles.css\">
    <link rel=\"stylesheet\" href=\"style_sheets/launch_styles.css\">
    <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\">

    <title>Launch Page</title>
    <body>
        <p id=\"head\">Welcome to Game Culture! <br> Please select an assignment</p>

        <div class=\"grid-container\">
            <div class=\"grid-item\">
                <span class=\"ass-title\">Assignment 1</span>
                <nav>
                    <a href=\"COS216/Assignment_1/trending.html\">Trending</a>
                    <a href=\"COS216/Assignment_1/featured.html\">Featured</a>
                    <a href=\"COS216/Assignment_1/new_releases.html\">New Releases</a>
                    <a href=\"COS216/Assignment_1/not_found.html\">Calendar</a>
                </nav>
            </div>
            <div class=\"grid-item\" id=\"logo\" style=\"max-height: inherit; max-width: inherit; margin: auto;\">
                <img src=\"images/logo.png\" alt=\"A terrible drawing made late one night\">
            </div>
            <div class=\"grid-item\">
                <span class=\"ass-title\">Assignment 2</span>
                <nav>
                    <a href=\"COS216/Assignment_2/trending.html\">Trending</a>
                    <a href=\"COS216/Assignment_2/featured.html\">Featured</a>
                    <a href=\"COS216/Assignment_2/new_releases.html\">New Releases</a>
                    <a href=\"COS216/Assignment_2/calendar.html\">Calendar</a>
                </nav>  
            </div>
            <div class=\"grid-item\">
                <span class=\"ass-title\">Assignment 3</span>
                <nav>
                    <a href=\"trending.php\">Trending</a>
                    <a href=\"featured.php\">Featured</a>
                    <a href=\"new_releases.php\">New Releases</a>
                    <a href=\"calendar.php\">Calendar</a>
                    <a href=\"signup.php\">Sign Up</a>
                    <a href=\"login.php\">Login</a>                    
                </nav>  
            </div>
            <div class=\"grid-item\">
                <span class=\"ass-title\">Assignment 4</span>
                <nav>
                    <a href=\"COS216/Assignment_3/not_found.php\">Trending</a>
                    <a href=\"COS216/Assignment_3/not_found.php\">Featured</a>
                    <a href=\"COS216/Assignment_3/not_found.php\">New Releases</a>
                    <a href=\"COS216/Assignment_3/not_found.php\">Calendar</a>
                </nav> 
            </div>
        </div>


    </body>
</html>
    ";
}