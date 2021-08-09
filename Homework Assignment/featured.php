<?php

    require("PHP files" . DIRECTORY_SEPARATOR . "header.php");
    require("PHP files" . DIRECTORY_SEPARATOR . "footer.php");

    buildPage();

    function buildPage() {
        buildtop();
        gen_Navbar("featured");
        buildrest();
        footer();
        echo "<script src=\"https://code.JQuery.com/JQuery-3.4.1.min.js\"></script>
    <script src=\"Javascript_and_Jquery/featured.js\"></script>
    <script src=\"Javascript_and_Jquery/general.js\"></script>
    <script src=\"Javascript_and_Jquery/views.js\"></script></html>";
    }

    function buildtop() {
        echo "
        <!DOCTYPE html>
        <html>
            <link rel=\"stylesheet\" href=\"style_sheets/my_styles.css\">
            <link rel=\"stylesheet\" href=\"style_sheets/featuring_styles.css\">
            <script src=\"https://kit.fontawesome.com/a7d156b39d.js\" crossorigin=\"anonymous\"></script>
            <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\">
            <script src=\"https://code.iconify.design/1/1.0.7/iconify.min.js\"></script>
            
        
            <title>
                Featured Games
            </title>
            <head>
                <div> 
        ";
    }

    function buildrest() {
        echo "
        </div>
        <div class=\"title-feat\">
            Featured Games
        </div>
    </head>
    <body>
        <div class=\"loader\" id=\"calendar-loader\">
            <img src=\"images/Animations/loading_grey.svg\" style=\"height: 100%; width: 100%;\">
        </div>
        <table class=\"tafel\">
            <tr>
                <td> <a href=\"#leftFeat\"> <i class=\"fas fa-angle-double-left fa-4x\"></i><a> </td>
                <td>
                    <div>
                        <table border=\"1\" class=\"innertable\">
                            <tr class=\"cell\">
                                <th class= \"title\" colspan=\"3\" style=\"text-align: center;\">Call Of Duty Cold War</th>
                            </tr>
                            <tr>
                                <td id=\"desc\" class=\"cell\" rowspan=\"3\" style=\"width:700px; font-size: 18px;\">The 17th Call of Duty reinvents the famous shooter series for the first time on 
                                    next gen systems. Containing Ray-traced graphics and advanced physix techniques specially mastered for next generation
                                    systems. This is the definitive Call of Duty experience including zombies and the latest season of War Zone.
                                </td>
                                <td class=\"cell\" rowspan=\"13\" class=\"spine_dec\" ><span class=\"spine title\">Call Of Duty Cold War</span></td>
                                <td class=\"cell\" rowspan=\"2\" style=\"padding-left: 2%;\">
                                    <i id=\"xbox\" class=\"fab fa-xbox fa-3x\" style=\"float: left; padding-right: 3%\"></i>
                                    <i id=\"ps\" class=\"fab fa-playstation fa-3x\" style=\"float: left; padding-right: 3%;\"></i>
                                    <i id=\"pc\" class=\"fas fa-desktop fa-3x\" style=\"float: left; padding-right: 3%;\"></i>
                                    <i id=\"switch\" class=\"iconify\" data-icon=\"mdi-nintendo-switch\" data-inline=\"false\" style=\"float: left; clear: right; padding-right: 3%;\"></i>

                                </td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td class=\"cell boxart\" rowspan=\"11\">
                                    <img id=\"feat-boxart\" src=\"images/BoxArt/Black_Ops_Cold_War.jpeg\" alt=\"box art\">
                                </td>
                            </tr>
                            <tr>
                                <td class=\"cell\" rowspan=\"6\">
                                    <iframe id=\"youtube-video\" width=\"650\" height=\"315\" src=\"https://www.youtube.com/embed/aTS9n_m7TW0\" 
                                    title=\"YouTube video player\" frameborder=\"0\" 
                                    allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" class=\"vid_style\"></iframe>
                                </td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td class=\"cell\" id=\"rel\" style=\"font-size: 19px;\"><b>13 November 2020</td>
                            </tr>
                            <tr>
                                <td class=\"cell\" id=\"genre\" rowspan=\"2\"><b>Action, Shooter, SinglePlayer, MultiPlayer, Battle Royale, Survival</td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td class=\"cell\" ><span style=\"font-size: 19px;\"><b>Developed by:</span> <span id=\"devel\">Treyarch, Raven Software</span></td>
                            </tr>
                            </table>
                    </div>
                </td>
                <td>
                   <a href=\"#RightFeat\"> <i class=\"fas fa-angle-double-right fa-4x\"></i><a>
                </td>
            </tr>
        </table>
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
    
        ";
    }

?>