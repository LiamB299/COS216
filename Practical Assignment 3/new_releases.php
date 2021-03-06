<?php

    require("PHP files" . DIRECTORY_SEPARATOR . "header.php");
    require("PHP files" . DIRECTORY_SEPARATOR . "footer.php");


    buildPage();

    function buildPage() {
        buildtop();
        gen_Navbar("new-releases");
        buildrest();
        footer();
        echo "</html>";
    }

    function buildtop() {
        echo "
        <!DOCTYPE html>
        <html>
            <link rel=\"stylesheet\" href=\"style_sheets/my_styles.css\">
            <link rel=\"stylesheet\" href=\"style_sheets/new_release_styles.css\">
            <script src=\"https://kit.fontawesome.com/a7d156b39d.js\" crossorigin=\"anonymous\"></script>
            <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\">
            <script src=\"https://code.iconify.design/1/1.0.7/iconify.min.js\"></script>
        
            <title>
                New Releases
            </title>
            <head>
        ";
    }

    function buildrest() {
        echo "
        <div id=\"newrel-title\">
        
        </div>
    </head>

    <body>
        <div class=\"loader\" id=\"calendar-loader\">
            <img src=\"images/Animations/loading_grey.svg\" style=\"height: 100%; width: 100%;\">
        </div>
        <div id=\"bigblock\" style=\"overflow: auto; margin: auto;\">
            <div id=\"icon-left\" style=\"width: 5%; float: left; margin-left: 10%; margin-top: 50%; padding-right: 15px;\">
                <div class=\"newrel-title\">
                    New Releases
                </div>
                <a href=\"#NRleft\"><i class=\"fas fa-angle-double-left fa-4x\"></i></a>
            </div>
            <div id=\"mid-content\" style=\"width: 70%; background-color:white; float: left;\"> 
                <div class=\"tooltip\" id=\"Artwork\" style=\"width: 100%; background-color: cornsilk; clear: both; \">
                    <span id=\"tip-info\" class=\"tooltiptext\"><span id=\"hovtitle\">Mass Effect Legendary Edition</span><br> <span id=\"score\">Rating: 89%</span></span>
                    <img id=\"boxart\" src=\"images/BoxArt/masseffect.jpg\" style=\"width: 100%; height: 100%;\">
                </div>
                
                <div id=\"info-box\" style=\"width: 100%; float: left; clear: right; margin: 0%; padding: auto; height: 100%;\">
                    <div id=\"gametitle\">
                        Mass Effect Legendary Edition
                    </div>
                    <div id=\"DescDesc\" style=\"float: left; clear: right; background-color: crimson;\">
                        <div id=\"Desc\" style=\"width: 90%;  float: left; height: 100%;\">
                            One person is all that stands between humanity and the greatest threat it has ever faced. Relive the legend of Commander Shepard in the highly acclaimed 
                            Mass Effect trilogy with the Mass Effect??? Legendary Edition. Includes single-player base content and over 40 DLC from Mass Effect, Mass Effect 2, and Mass Effect 3
        
                        </div>
                        <div id=\"Age\" style=\"width: 10%; background-color: darkblue; float: left; height: auto;\">
                            <img id=\"pegi\" src=\"images/Icons/pegi18.png\" style=\"width: 100%; height: 100%;\">
                        </div>
                    </div>
                    <div id=\"dev-website\">
                        <a id=\"weblink\" href=\"https://www.bioware.com/games/\">Game Website</a>
                    </div>
                    <div style=\"float: left; clear: right; width: 100%;\">
                        <div id=\"Platforms\" style=\"width: 50%; background-color: white; float: left; padding-top: 1%;\">
                            <i class=\"fab fa-xbox fa-3x\" style=\"float: left; padding-right: 3%; padding-left: 27%;\"></i>
                            <i class=\"fab fa-playstation fa-3x\" style=\"float: left; padding-right: 3%;\"></i>
                            <i class=\"fas fa-desktop fa-3x\" style=\"float: left; padding-right: 3%;\"></i>
                            <i class=\"iconify\" data-icon=\"mdi-nintendo-switch\" data-inline=\"false\" style=\"float: left; clear: right; padding-right: 3%;\"></i>
                        </div>    
                        <div id=\"Genres\" style=\"width: 50%; background-color:white; float: left; clear: right; font-size: 20px; padding-top: 20px;\">
                                Action, RPG, Singleplayer
                        </div>
                    </div>

                    
                    <div id=\"syst-req\" style=\"width: 100%; background-color: darkseagreen; float: left; ;\">
                        <div id=\"syst-title\">System Requirements</div>
                        <div id=\"min-req\" style=\"float: left; width: 50%;\">
                            <ul style=\"text-align: left; list-style: none;\">
                                <li>
                                    <span class=\"req\">OS:</span>
                                    64-bit Windows 10
                                </li>
                                <li>
                                    <span class=\"req\">Processor:</span>
                                    Intel Core i5 3570 or AMD FX-8350
                                </li>
                                <li>
                                    <span class=\"req\">Memory:</span>
                                    8 GB RAM
                                </li>
                                <li>
                                    <span class=\"req\">Graphics:</span>
                                    GPU: NVIDIA GTX 760, AMD Radeon 7970 / R9280X GPU RAM: 2 GB Video Memory
                                </li>
                                <li>
                                    <span class=\"req\">DirectX:</span>
                                    Version 11
                                </li>
                                <li>
                                    <span class=\"req\">Storage:</span>
                                    120 GB available space
                                </li>
                            </ul>
                        </div>
                        <div id=\"max-req\" style=\"float: left;  width: 50%;\">
                            <ul style=\"text-align: left; list-style: none;\">
                                <li>
                                    <span class=\"req\">OS:</span>
                                    64-bit Windows 10
                                </li>
                                <li>
                                    <span class=\"req\">Processor:</span>
                                    Intel Core i7-7700 or AMD Ryzen 7 3700X
                                </li>
                                <li>
                                    <span class=\"req\">Memory:</span>
                                    16 GB RAM
                                </li>
                                <li>
                                    <span class=\"req\">Graphics:</span>
                                    GPU: NVIDIA GTX 1070 / RTX 200, Radeon Vega 56, GPU RAM: 4 GB Video Memory
                                </li>
                                <li>
                                    <span class=\"req\">DirectX:</span>
                                    Version 11
                                </li>
                                <li>
                                    <span class=\"req\">Storage:</span>
                                    120 GB available space
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div id=\"icon-right\" style=\"width: 5%; float: left; margin-top: 50%; padding-left: 10px;\">
                <div class=\"newrel-title\">
                    New Releases
                </div>
                <a href=\"#NRright\"><i class=\"fas fa-angle-double-right fa-4x\"></i></a>
            </div>
        </div>
    </body>
    <script src=\"https://code.JQuery.com/JQuery-3.4.1.min.js\"></script>
    <script src=\"Javascript_and_Jquery/new_releases.js\"></script>
    <script src=\"Javascript_and_Jquery/general.js\"></script>
        ";
    }

?>