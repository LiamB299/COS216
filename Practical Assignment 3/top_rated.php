<?php

    require("PHP files" . DIRECTORY_SEPARATOR . "header.php");
    require("PHP files" . DIRECTORY_SEPARATOR . "footer.php");

    buildPage();

    function buildPage() {
        buildtop();
        gen_Navbar("toprated");
        buildrest();
        footer();
        echo "</html>";
    }

    function buildtop() {
        echo "
        <!DOCTYPE html>
        <html>
            <link rel=\"stylesheet\" href=\"style_sheets/my_styles.css\">
            <link rel=\"stylesheet\" href=\"style_sheets/top_rated_styles.css\">
            <script src=\"https://kit.fontawesome.com/a7d156b39d.js\" crossorigin=\"anonymous\"></script>
            <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\">
        
            <title>
                Top Rated
            </title>
            <head>
        ";
    }

    function buildrest() {
        echo "
        <div id=\"title-top\">Top Rated Games</div>
    </head>

    <body>
        <div id=\"rank-period\" class=\"dropdown\">
            <button class=\"dropbtn\">Time Period</button>
            <div id=\"RatedDropdown\" class=\"dropdown-content\">
                <div class=\"button\" id=\"Month\">Month</div>
                <div class=\"button\" id=\"Year\">Year</div>
                <div class=\"button\" id=\"Ten-years\">10 Years</div>
                <div class=\"button\" id=\"all-time\">All Time</div>
            </div>
        </div>
        <div>
            <div class=\"loader\" id=\"calendar-loader\">
                <img src=\"images/Animations/loading_grey.svg\" style=\"height: 100%; width: 100%;\">
            </div>
            <div>
                <span id=\"filter-by\">
                    Filter by:
                    <span id=\"period\">

                    </span>
                </span>
            </div>
            <table class=\"tafel\">
                <tr> 
                    <td>
                        <a href=\"#left-top\"><i class=\"fas fa-angle-double-left fa-4x\"></i></a>
                    </td>
                    <td>
                        <table id=\"innertable\" border=\"1\" style=\"table-layout: fixed\">
                            <tr class=\"meta_score\">
                                <th rowspan=\"2\" id=\"score-1\">98</th>
                                <th rowspan=\"2\" id=\"score-2\">97</th>
                                <th rowspan=\"2\" id=\"score-3\">97</th>
                            </tr>
                            <tr>
                            </tr>
                            <tr id=\"art\">
                                <td rowspan=\"4\"><img id=\"box-1\" src=\"images/BoxArt/The_Legend_of_Zelda_Breath_of_the_Wild.jpg\" alt=\"Zelda box art\" class=\"score_boxart\"> </td>
                                <td rowspan=\"4\"><img id=\"box-2\" src=\"images/BoxArt/BioShock_cover.jpg\" alt=\"Bioshock box art\" class=\"score_boxart\"></td>
                                <td rowspan=\"4\"><img id=\"box-3\" src=\"images/BoxArt/uncharted 2.jfif\" alt=\"Uncharted box art\" class=\"score_boxart\"></td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                            </tr>
                            <tr class=\"info\">
                                <td rowspan=\"2\" class=\"pad-text\" id=\"title-1\">The Legend of Zelda Breath of the Wild</td>
                                <td rowspan=\"2\" class=\"pad-text\" id=\"title-2\"> Bioshock</td>
                                <td rowspan=\"2\" class=\"pad-text\" id=\"title-3\">Uncharted 2 Among Thieves</td>
                            </tr>
                            <tr></tr>
                            <tr class=\"info\">
                                <td class=\"pad-text\" id=\"dev-1\">Nintendo Japan</td>
                                <td class=\"pad-text\" id=\"dev-2\">Irrational Games</td>
                                <td class=\"pad-text\" id=\"dev-3\">Naughty Dog</td>
                            </tr>
                            <tr class=\"info\">
                                <td rowspan=\"2\" class=\"pad-text\" id=\"plat-1\">Switch</td>
                                <td rowspan=\"2\" class=\"pad-text\" id=\"plat-2\">PC, PS3, Xbox 360</td>
                                <td rowspan=\"2\" class=\"pad-text\" id=\"plat-3\">PS3, PS4</td>
                            </tr>
                            <tr>
                            </tr>
                            </table>

                    </td>
                <td>
                    <a href=\"#right-top\"><i class=\"fas fa-angle-double-right fa-4x\"></i></a>
                </td>
                </tr>
            </table>
        </div>
        <script src=\"https://code.JQuery.com/JQuery-3.4.1.min.js\"></script>
        <script src=\"Javascript_and_Jquery/top_rated.js\"></script>
        <script src=\"Javascript_and_Jquery/general.js\"></script>
    </body>
        ";
    }

?>