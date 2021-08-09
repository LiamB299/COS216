<?php

    require("PHP files" . DIRECTORY_SEPARATOR . "header.php");
    require("PHP files" . DIRECTORY_SEPARATOR . "footer.php");

    buildPage();

    function buildPage() {
        buildtop();
        gen_Navbar("trending");
        buildrest();
        //footer();
        echo "<script src=\"https://code.JQuery.com/JQuery-3.4.1.min.js\"></script>
    <script src=\"Javascript_and_Jquery/general.js\"></script>
    <script src=\"Javascript_and_Jquery/trending.js\"></script>
    <script src=\"Javascript_and_Jquery/modal.js\"></script>
    <script src=\"Javascript_and_Jquery/views.js\"></script>
    </html>";
    }

    function buildtop() {
        echo "
        <!DOCTYPE html>
        <html>
            <link rel=\"stylesheet\" href=\"style_sheets/my_styles.css\">
            <link rel=\"stylesheet\" href=\"style_sheets/trending_styles.css\">
            <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\">
            <script src=\"https://code.iconify.design/1/1.0.7/iconify.min.js\"></script>
            <title>
                Trending
            </title>
            <head>
                
            </head>
            <body>
                <div>
        ";
    }

    function buildrest() {
        echo "
        </div>
            </nav>
        </div>
        <div id=\"Info bar\" style=\"clear: right;\">
            <div id=\"webname\" style=\"float: left; width: 25%;\">
                .
            </div>
            <div style=\"float: left; width: 50%;\" id=\"trend-title\">
                Trending 
            </div>
            <div style=\"width: 25%;\">.</div>
        </div>
        <div class=\"loader\" id=\"calendar-loader\">
            <img src=\"images/Animations/loading_grey.svg\" style=\"height: 100%; width: 100%;\">
        </div>
        <div>
            <label for=\"inName\">Search for a game: </label>
            <input type=\"text\" id=\"inName\" value=\"Mass Effect 2\">
            <input type=\"submit\" value=\"Search\" id=\"sub\">
        </div>
                       
        <div id=\"main-frame\" class=\"grid-container\" style=\"padding-top: 2%; clear: left;\">
            <div class=\"grid-item\" id=\"card-0\">
                <div class=\"card\">
                    <div class=\"title\">Rocket League</div>
                    <div class=\"score\">92</div>
                    <img src=\"images/BoxArt/rocketleague.jpg\" id=\"\" alt=\"cars go vroom\" class=\"artwork\">
                    <div class=\"info\">
                        <div class=\"dev\">Psynoix</div>
                        <div class=\"release\">16 July 2015</div>
                    </div>
                    
                    <div class=\"tags\">
                        <div class=\"genre racer multiplayer\">Arcade, Racing</div>
                        <div class=\"platform ps4 ps5 xbone xsx switch pc\">PS4, PS5, Xbox One, Xbox SX, PC, Switch</div>
                    </div>
                </div>
            </div>
            
<!---------------------------------------------------------------------->
            <div class=\"filt-cell\">
                <div id=\"genre-select\">
                    <span id=\"genre-title\" class=\"filter-title\">Filter by Genre</span>
                    <ul style=\"list-style-type:none;\">
                        <li>
                            <div class=\"genre button\" id=\"action\">Action</div>
                        </li>
                        <li>
                            <div class=\"genre button\" id=\"role-playing-games-rpg\">RPG</div>
                        </li>
                        <li>
                            <div class=\"genre button\" id=\"adventure\">Adventure</div>
                        </li>
                        <li>
                            <div class=\"genre button\" id=\"shooter\">Shooter</div>
                        </li>
                        <li>
                            <div class=\"genre button\" id=\"racing\">Racing</div>
                        </li>
                        <li>
                            <div class=\"genre button\" id=\"indie\">Indie</div>
                        </li>
                        <li>
                            <div class=\"genre button\" id=\"platformer\">Platformer</div>
                        </li>
                        <li>
                            <div class=\"genre button\" id=\"strategy\">Strategy</div>
                        </li>
                        <li>
                            <div class=\"genre button\" id=\"genre-all\">All</div>
                        </li>
                    </ul>
                </div>
                <div id=\"plat-select\">
                    <span id=\"plat-title\" class=\"filter-title\">Filter by Platform</span>
                    <ul id=\"\" style=\"list-style-type:none;\">
                        <li>
                            <div class=\"plat button\" id=\"16\">PS3</div>
                        </li>
                        <li>
                            <div class=\"plat button\" id=\"18\">PS4</div>
                        </li>
                        <li>
                            <div class=\"plat button\" id=\"187\">PS5</div>
                        </li>
                        <li>
                            <div class=\"plat button\" id=\"14\">Xbox 360</div>
                        </li>
                        <li>
                            <div class=\"plat button\" id=\"1\">Xbox One</div>
                        </li>
                        <li>
                            <div class=\"plat button\" id=\"186\">Xbox SX</div>
                        </li>
                        <li>
                            <div class=\"plat button\" id=\"7\">Switch</div>
                        </li>
                        <li>
                            <div class=\"plat button\" id=\"4\">PC</div>
                        </li>
                        <li>
                            <div class=\"plat button\" id=\"plat-all\">All</div>
                        </li>
                    </ul>
                </div>
                <div id=\"score-select\">
                    <span id=\"score-title\" class=\"filter-title\">Filter by Score</span>
                    <ul style=\"list-style-type:none;\">
                        <li>
                            <div class=\"scores button\" id=\"90\">90+</div>
                        </li>
                        <li>
                            <div class=\"scores button\" id=\"80\">80->89</div>
                        </li>
                        <li>
                            <div class=\"scores button\" id=\"70\">70->79</div>
                        </li>
                        <li>
                            <div class=\"scores button\" id=\"60\">60->69</div>
                        </li>
                        <li>
                            <div class=\"scores button\" id=\"score-all\">All</div>
                        </li>
                    </ul>
                    <button id=\"display-but\">Display by filters</button>
                    <button id=\"filter-but\">Save Filter Preferences</button>
                </div>
            </div>

<!---------------------------------------------------------------------->

<div id=\"modal\" class=\"modal\">
            <div class=\"modal-content\">
                <span class=\"close\" id=\"close-modal\">&times;</span>
                <div>
                    <span id=\"modal-game-title\">
                        Rate this game!
                    </span><br>
                    <span id=\"modal-title\">Game title</span>
                    <div>
                    <img id=\"modal-img\" src=\"images/logo.png\">
                    </div>
                    <div class=\"slidecontainer\">
                    <br>
                        <span id=\"slider-out\">75</span>
                        <input type=\"range\" min=\"1\" maxlength=\"100\" value=\"75\" class=\"slider\" id=\"sliderange\">
                    </div>
                    <span id=\"modal-meta\">Metacritic rating: </span><span id=\"modal-m-rating\">1</span><br>
                    <button id=\"sub-modal\">Submit rating</button>
                </div>
            </div>
        </div>
<div class=\"friends-modal\">
            <div class=\"friends-modal-content\">
                <span class=\"close\" id=\"friends-close\">&times;</span>
                <div id=\"friends-reform\">Grid</div>
                <div id=\"friend-big\" class=\"friend-big-cont-row\">
                    <div class=\"grid-container-friends-row\">
                        <div class=\"friends-title\">
                            Friends
                        </div>
                        <div class=\"grid-item-friends\">
                            Username
                        </div>
                        <div class=\"grid-item-friends\" id=\"unfriend-option\">
                            Remove friend
                        </div>
                    </div>
                    <div class=\"grid-container-friends-row\">
                        <div class=\"friends-title\">
                            Pending
                        </div>
                        <div class=\"grid-item-friends\">
                            Username
                        </div>
                        <div class=\"grid-item-friends\" id=\"pending-option\">
                            Cancel friend request
                        </div>
                    </div>
                    <div class=\"grid-container-friends-row\">
                        <div class=\"friends-title\">
                            Not friends
                        </div>
                        <div class=\"grid-item-friends\">
                            Username
                        </div>
                        <div class=\"grid-item-friends\" id=\"add-option\">
                            Add Friend
                        </div>
                    </div>
                    <div class=\"grid-container-friends-row\">
                        <div class=\"friends-title\">
                            Confirm Friends
                        </div>
                        <div class=\"grid-item-friends\">
                            Username
                        </div>
                        <div class=\"grid-item-friends\" id=\"conf-option\">
                            Confirm
                        </div>
                    </div>
                </div>
            </div>
        </div>
                   
    </body>  
    
    <footer style='padding-top: 40px' id=\"foot\">Gameculture<div>
            <i id=\"day\" class=\"far fa-sun fa-3x\"></i>
            <i id=\"two-arrow\" class=\"fas fa-arrows-alt-h fa-3x\"></i>
            <i id=\"night\" class=\"fas fa-moon fa-3x\"></i>
            </div>
            </footer>
    
        ";
    }
