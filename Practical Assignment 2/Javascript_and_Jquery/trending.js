//methods are async due to the synchronous option being deprecated
//the overlay for loading is removed after all data has been loading by 
//being a sort of "final" call back var current_fill = 1;

$(document).ready(function() {
    Generic_Get_Request(fill, URL_Genres_RAWG("action"));
});

function log(info) {
    console.log(info);
}

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

$(".genre.button").click(function () { 
    Generic_Get_Request(fill, URL_Genres_RAWG(this.id));
});

$(".plat.button").click(function () { 
    Generic_Get_Request(fill, URL_Platform_RAWG(this.id));
});

$(".scores.button").click(function () { 
    Generic_Get_Request(fill, URL_Score_RAWG(this.id));
});

//$("#inName").click(function () { 
//    this.value="";
//});

$("#sub").click(function () { 
    if($("#inName").val()=="") {
        alert("Empty search!");
        return;
    }
    Generic_Get_Request(fill, URL_Search_RAWG($("#inName").val()));
});

//======================================================================
//url builders
function URL_Search_RAWG(search) {
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&page_size=52&search="+search;
}

function URL_Genres_RAWG(genre) {
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&page_size=52&genres="+genre;
}

function URL_Platform_RAWG(platform) {
    //log("https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&platforms="+platform);
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&page_size=52&platforms="+platform;
}

function URL_Score_RAWG(score) {
    var high = parseInt(score) +9;
    //log(high);
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&page_size=24&metacritic="+score+","+high;
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

//=======================================
function fill(data) {
    clear_old();
    ToggleLoading(false);

    current_fill = data.results.length;

    //create number of cards to number of games
    //var numGames = ceil(data.results.length3/3);
    //log(data);
    for(var k=1; k<data.results.length; k++) {
        create_card(k);
    }
    for(var i=0; i<data.results.length; i++) {
        fill_card(data.results[i],i);
    }
}

function clear_old() {
    $(".added").remove();
}

function create_card(i) {
    //log("cardss");
    $(".grid-container").append("<div class=\"grid-item added\" id=\"card-"+i+"\"><div class=\"card\"><div class=\"title\">Rocket League</div>"+
    "<div class=\"score\">92</div><img src=\"images/BoxArt/rocketleague.jpg\" alt=\"cars go vroom\" class=\"artwork\">"+
    "<div class=\"info\"><div class=\"dev\">Psynoix</div><div class=\"release\">16 July 2015</div>"+
    "</div><div class=\"tags\"><div class=\"genre racer multiplayer\">Arcade, Racing</div>"+
    "<div class=\"platform ps4 ps5 xbone xsx switch pc\">PS4, PS5, Xbox One, Xbox SX, PC, Switch</div>"+
    "</div></div></div>");
}

function fill_card(data, i) {
    //log(data);
    Generic_Get_Request(URL_GB_Game, URL_GB_ID(data.name), true, i);
    SetTitle(data.name, i);
    SetScore(data.metacritic, i);
    SetDate(data.released, i);
    SetPlatforms(data.platforms,i);
    SetGenres(data.genres,i);
}

function fill_artdev(data, i) {
    SetArt(data.results.image.original_url, i);
    SetDev(data.results.developers[0].name, i);

    if(i==22)
        ToggleLoading(true);
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
    $(".grid-item#card-"+i+" > .card > .info > .dev").html(data);
}

function SetDate(data, i) {
    $(".grid-item#card-"+i+" > .card > .info > .release").html(data);
}

function SetGenres(data, j) {
    var sline="";
    for(var i=0; i<data.length-1; i++) {
        sline+=data[i].name;
        sline+=",";
    }
    sline+=data[i].name;
    $(".grid-item#card-"+j+" > .card > .tags > .genre").html(sline);
}

function SetPlatforms(data, i) {
    //log(i);
    //log(data);
    var sline="";
    for(var j=0; j<data.length-1 && j<6; j++) {
        sline+=data[j].platform.name;
        sline+=",";
    }
    sline+=data[j].platform.name;
    //log(sline);
    $(".grid-item#card-"+i+" > .card > .tags > .platform").html(sline);
}