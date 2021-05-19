<?php

    //if(session_status()==PHP_SESSION_NONE)
    //    session_start();

    require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "config.php");

    function gen_Navbar($page="index") {
        $nav = "<div style=\"clear: right;\">
                <nav id=\"navbar\">";
        if($page!="index")  {

        }
        if($page!="trending") {
            $nav .= "
            <a href=\"trending.php\">Trending</a>
            ";
        }
        if($page!="featured") {
            $nav .= "
            <a href=\"featured.php\">Featured</a>
            ";    
        }
        if($page!="new-releases") {
            $nav .= "
            <a href=\"new_releases.php\">New Releases</a>
            ";    
        }   
        if($page!="toprated") {
            $nav .= "
            <a href=\"top_rated.php\">Top Rated</a>
            ";    
        }
        if($page!="calendar") {
            $nav .= "
            <a href=\"calendar.php\">Calendar</a>
            ";    
        }
        
        /*************************************/
        if(isset($_SESSION["logged_in"])) {
            if($_SESSION["logged_in"]==true && $_SESSION["username"]!="")
            $nav .= "
            <div id=\"admin\">
                    <nav style=\"float: right;\">
                        <a id=\"username\" href=\"\">Welcome ".$_SESSION["username"]."</a>
                        <a id=\"logout\" href=\"\">Logout</a>
                    </nav>
                </div>
            ";
        
        else {
            $nav .= "
            <div id=\"admin\">
                    <nav style=\"float: right;\">
            ";
            if($page!="signup") {
                $nav .= "
                <a href=\"signup.php\">Sign-Up</a>
                ";    
            }
            if($page!="login") {
                $nav .= "
                <a href=\"login.php\">Login</a>
                ";    
            } 
            $nav .= "
            </nav>
                </div>
            ";  
        } 
        }
        

        $nav .= "</nav></div>";
        

        echo $nav;
    }
?>