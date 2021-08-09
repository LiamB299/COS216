//methods are async due to the synchronous option being deprecated
//the overlay for loading is removed after all data has been loading by 
//being a sort of "final" call back var current_fill = 1;

$(document).ready(function() {
    if(sessionStorage.getItem("username")==null)
        $("#filter-but").hide();
    else
        $("#filter-but").show();

    if(sessionStorage.getItem("genre")==null) {
        $("#genre-all").trigger("click");
    }
    else {
        $("#"+GenreMap(sessionStorage.getItem("genre"))).trigger("click");
    }

    if(sessionStorage.getItem("platform")==null) {
        $("#plat-all").trigger("click");
    }
    else
        $("#"+PlatMap(sessionStorage.getItem("platform"))).trigger("click");

    if(sessionStorage.getItem("score")==null) {
        $("#score-all").trigger("click");
    }
    else
        $("#"+ScoreMap(sessionStorage.getItem("score"))).trigger("click");

    $("#display-but").trigger("click");

});

function log(info) {
    console.log(info);
}

//================================================

$("#display-but").on("click", function () {
    //gen request to my API to fill and return data accordingly
    //console.log(sessionStorage.getItem("tempscore"));
    var score = ScoreMap(sessionStorage.getItem("tempscore"));
    //console.log(score);
    if(score!="score-all") {
        console.log(score);
        score = parseInt(score);
        let upper = score + 9;
        score = score + "," + upper;
    }

    let body = {
        "key" : sessionStorage.getItem("key"),
        "type" : "info",
        "limit" : "9",
        "score" : score,
        "platforms" : api_plat_map(PlatMap(sessionStorage.getItem("tempplatform"))),
        "genre" : GenreMap(sessionStorage.getItem("tempgenre")),
        "return" : ["title", "release", "genres", "platforms",
            "developers", "artwork", "metacritic"]
    };

    if(body["genre"]=="genre-all")
        delete body["genre"];
    if(body["platforms"]=="plat-all" || body["platforms"]==null)
        delete body["platforms"];
    if(body["score"]=="score-all")
        delete body["score"];

    //console.log(body);
    GenericPost("api.php", body, fill);
});

$("#filter-but").on("click", function () {
    if(sessionStorage.getItem("key")==null)
        return;
    //update request to save preferences by mapping
    let body = {
        "type" : "update",
        "key" : sessionStorage.getItem("key"),
        "set" : "filters",
        "values" : [sessionStorage.getItem("tempgenre"),
            sessionStorage.getItem("tempplatform"),
            sessionStorage.getItem("tempscore")]
    };

    GenericPost("api.php", body, log);
    sessionStorage.setItem("genre", sessionStorage.getItem("tempgenre"));
    sessionStorage.setItem("platform", sessionStorage.getItem("tempplatform"));
    sessionStorage.setItem("score", sessionStorage.getItem("tempscore"));


});

function GenreMap(key, value) {
    let genres = ["racing", "action", "role-playing-games-rpg", "adventure",
    "shooter", "indie", "platformer", "strategy", "genre-all"];

    if(key<0) {
        return genres.indexOf(value);
    }
    else return genres[key];
}

function PlatMap(key, value) {
    let genres = ["16", "18", "187",
        "14", "1", "186", "7", "4", "plat-all"];

    if(key<0) {
        return genres.indexOf(value);
    }
    else return genres[key];
}

function api_plat_map(value) {
    value = parseInt(value);
    switch (value) {
        case 18: {
            return "playstation-4";
            break;
        }
        case 16: {
            return "playstation-3";
            break;
        }
        case 187 : {
            return "playstation-5";
            break;
        }
        case 14: {
            return "xbox-360";
            break;
        }
        case 1: {
            return "xbox-one";
            break;
        }
        case 186: {
            return "xbox-sx";
            break;
        }
        case 7: {
            return "nintendo-switch";
            break;
        }
        case 4: {
            return "pc";
            break;
        }
        default: return null;
    }
}

function ScoreMap(key, value) {
    let genres = ["90", "80", "70",
        "60", "score-all"];

    if(key<0) {
        return genres.indexOf(value);
    }
    else return genres[key];
}

//================================================

function ToggleLoading(showContent=false) {
    if(showContent) {
        $(".loader").fadeOut(500, function () {  
            $(".loader").css("visibility", "hidden");
            $(".grid-container, label, input").css("visibility", "visible")
        });   
    }
    else if(!showContent){
        $('html, body').animate({ scrollTop: 50 }, 'fast');
        $(".grid-container, label, input").css("visibility", "hidden")
        $(".loader").fadeIn(100, function() {
            $(".loader").css("visibility", "visible");
        })
    }
}

$(".genre.button").on("click",function () {
    sessionStorage.setItem("tempgenre", GenreMap(-1,this.id));
    $(".genre.button").css("color", "#00cccc");
    $("#"+this.id).css("color", "indianred")
    //Generic_Get_Request(fill, URL_Genres_RAWG(this.id));
});

$(".plat.button").on("click",function () {
    sessionStorage.setItem("tempplatform", PlatMap(-1,this.id));
    $(".plat.button").css("color", "#00cccc");
    $("#"+this.id).css("color", "indianred")
    //Generic_Get_Request(fill, URL_Platform_RAWG(this.id));
});

$(".scores.button").on("click",function () {
    sessionStorage.setItem("tempscore", ScoreMap(-1,this.id));
    $(".scores.button").css("color", "#00cccc");
    $("#"+this.id).css("color", "indianred")
    //Generic_Get_Request(fill, URL_Score_RAWG(this.id));
});

$(".button").on("hover", function () {
    $(".button").css("color", "seashell", "cursor", "pointer");
});

//$("#inName").click(function () { 
//    this.value="";
//});

$("#sub").click(function () { 
    if($("#inName").val()=="") {
        alert("Empty search!");
        return;
    }
    let body = {
        "key" : "0000000000",
        "type" : "info",
        "limit" : "9",
        "title" : $("#inName").val(),
        "return" : ["title", "release", "genres", "platforms",
            "age-rating", "developers", "artwork", "metacritic"]
    };
    GenericPost("api.php", body, fill);
    //Generic_Get_Request(fill, URL_Search_RAWG($("#inName").val()));
});

//=======================================
function fill(data) {
    data = data["data"];
    log(data);
    clear_old();
    ToggleLoading(false);

    current_fill = data.length;

    //create number of cards to number of games
    //var numGames = ceil(data.results.length3/3);
    //log(data);
    for(var k=1; k<current_fill; k++) {
        create_card(k);
    }
    for(var i=0; i<current_fill; i++) {
        fill_card(data[i],i);
    }
}

function clear_old() {
    $(".added").remove();
}

function create_card(i) {
    //log("cardss");
    $("footer").before("<div class=\"grid-item added\" id=\"card-"+i+"\"><div class=\"card\"><div class=\"title\">Rocket League</div>"+
    "<div class=\"score\">92</div><img id=\"\" src=\"images/BoxArt/rocketleague.jpg\" alt=\"cars go vroom\" class=\"artwork\">"+
    "<div class=\"info\"><div class=\"dev\">Psynoix</div><div class=\"release\">16 July 2015</div>"+
    "</div><div class=\"tags\"><div class=\"genre racer multiplayer\">Arcade, Racing</div>"+
    "<div class=\"platform ps4 ps5 xbone xsx switch pc\">PS4, PS5, Xbox One, Xbox SX, PC, Switch</div>"+
    "</div></div></div>");

    $("#card-"+i).on("click", modalTrend);
}

function fill_card(data, i) {
    //log(data);
    //Generic_Get_Request(URL_GB_Game, URL_GB_ID(data.name), true, i);
    fill_artdev(data, i);
    SetTitle(data["title"], i);
    SetScore(data["metacritic"], i);
    SetDate(data["release date"], i);
    SetPlatforms(data["platforms"],i);
    SetGenres(data["genres"],i);
}

function fill_artdev(data, i) {
    SetArt(data["artwork"], i);
    SetDev(data["developers"], i);

    if(i==6) {
        ToggleLoading(true);
    }
}

function SetTitle(data, i) {
    if(data.length>20) {
        $(".grid-item#card-"+i+" > .card > .title").css("font-size", "100%");
    }
    $(".grid-item#card-"+i+" > .card > .title").html(data);
}

function SetScore(data, i) {
    $(".grid-item#card-"+i+" > .card > .score").html(data);
}

function SetArt(data, i) {
    $(".grid-item#card-"+i+" > .card > img").attr("src", data);
}

function SetDev(data, i) {
    $(".grid-item#card-"+i+" > .card > .info > .dev").html(data[0]);
}

function SetDate(data, i) {
    $(".grid-item#card-"+i+" > .card > .info > .release").html(data);
}

function SetGenres(data, j) {
    var sline="";
    for(var i=0; i<data.length-1; i++) {
        sline+=data[i];
        sline+=",";
    }
    sline+=data[i];
    $(".grid-item#card-"+j+" > .card > .tags > .genre").html(sline);
}

function SetPlatforms(data, i) {
    //log(i);
    //log(data);
    var sline="";
    for(var j=0; j<data.length-1 && j<6; j++) {
        sline+=data[j];
        sline+=",";
    }
    sline+=data[j];
    //log(sline);
    $(".grid-item#card-"+i+" > .card > .tags > .platform").html(sline);
}

//======================================================================
//url builders
function URL_Search_RAWG(search) {
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&page_size=13&search="+search;
}

function URL_Genres_RAWG(genre) {
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&page_size=13&genres="+genre;
}

function URL_Platform_RAWG(platform) {
    //log("https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&platforms="+platform);
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&page_size=13&platforms="+platform;
}

function URL_Score_RAWG(score) {
    var high = parseInt(score) +9;
    //log(high);
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&page_size=13&metacritic="+score+","+high;
}

function URL_GB_ID(title) {
    return "https://www.giantbomb.com/api/search/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json&resources=game&field_list=id,name&limit=1&query="+title;
}

function URL_GB_Game(data, i) {
    //log(data);
    Generic_Get_Request(fill_artdev, "https://www.giantbomb.com/api/game/"+data.results[0].id+"/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json&field_list=image,developers",true, i);
}

//HTTP Request
function Generic_Get_Request(callback, url, async=true, arg=null) {
    //log(url);
    //XMLHTTP object
    var req = new XMLHttpRequest();
    //API request, true for async operation
    req.open("GET", url, async);
    //Sends request
    req.send();
    //check status
    req.onreadystatechange = function() {
        //success
        if(this.readyState == 4 && this.status == 200) {
            //callback processes request
            callback(JSON.parse(this.responseText), arg);
        }
        else if( this.status == 403 || this.status == 404) {
            alert("Error 404");
            return "";
        }
        else if( this.status == 420)
            log("Too many requests");
    }
}