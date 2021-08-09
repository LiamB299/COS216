//methods are async due to the synchronous option being deprecated
//the overlay for loading is removed after all data has been loading by 
//being a sort of "final" call back 

var games = [];
var genres = [];
const sync = false;
var focus =0;
$("#bigblock").css("visibility", "hidden");


function log(info) {
    console.log(info);
}

//==============================================
// Kill loading screen and add listeners
$(document).ready(function() {
    setTimeout(() => {
        Generic_Get_Request(populate_games_array_RAWG, URL_GetRawgNewReleases());
    }, 1000);
});

function ToggleLoading(show=false) {
    if(show) {
        $(".loader").fadeOut(500, function () {  
            $(".loader").css("visibility", "hidden");
            $("#bigblock").css("visibility", "visible")
        });   
    }
    else if(!show){
        $('html, body').animate({ scrollTop: 50 }, 'fast');
        $("#bigblock").css("visibility", "hidden")
        $(".loader").fadeIn(100, function() {
            $(".loader").css("visibility", "visible");
        })
    }
}
//========Listeners====================
$(".fa-angle-double-left").click(function() {
    previous();
});

$(".fa-angle-double-right").click(function() {
    next();
});

function previous() {
    ToggleLoading(false);
    if(focus==0)
        focus = games.length-1;
    else
        focus--;
    setGame();
}

function next() {
    ToggleLoading(false);
    if(focus==games.length-1)
        focus=0;
    else
        focus++;
    setGame();
}

//===============================================
// AJAX Functionality
function URL_GetRawgNewReleases() {
    var date = new Date();
    var now = date.toISOString();
    var hold="";
    var i=0;
    while(now[i]!="T") {
        hold+=now[i];
        i++;
    }
    now=hold;
    date.setMonth(-2);
    var last = date.toISOString();
    hold="";
    i=0;
    while(last[i]!="T") {
        hold+=last[i];
        i++;
    }
    last=hold;
    delete date;
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&dates="+last+","+now;
}

function URL_FreetoGame_GetGames() {
    return "https://www.freetogame.com/api/games?sort-by=release-date";
}

function URL_FreetoGame_GetByID(id) {
    return "https://www.freetogame.com/api/game?id="+id;
}

function URL_GetRAWG_Game(id) {
    return "https://api.rawg.io/api/games/"+id+"?key=7465f1c4b11d465898232c5155c4d607";
}

//484970

function URL_GiantBomb_art(title) {
    return "https://www.giantbomb.com/api/search/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json&resources=game&field_list=image&limit=1&query="+title;
}

//HTTP Request
function Generic_Get_Request(callback, url, async=true) {
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
            callback(JSON.parse(this.responseText));
        }
        else if( this.status == 403 || this.status == 404)
            alert("Error  403/404")
            return "";
    }  
}

//=========================================================
//callbacks
//Population efforts
function populate_games_array_RAWG(data) {
    for(var i=0; i<data.results.length; i++) {
        games.push(data.results[i].id);
        genres[i] = "";
        for(var j=0; j<data.results[i].genres.length-1; j++) {
            genres[i]+=data.results[i].genres[j].name;
            genres[i]+=", ";
        }
        genres[i]+=data.results[i].genres[j].name;
    }
    first();
}

function first() {
    focus=0;
    setGame();
}

function setGame() {
    Generic_Get_Request(fill_page_RAWG, URL_GetRAWG_Game(games[focus]));
}

//Art
function getArt(title) {
    Generic_Get_Request(setArt,URL_GiantBomb_art(title));
}

function setArt(data) {
    $("#boxart").attr("src", data.results[0].image.original_url);
    ToggleLoading(true);
}

function fill_page_RAWG(data) {
    log(data);
    $("#gametitle").html(data.name);
    $("#hovtitle").html(data.name);
    $("#score").html(data.metacritic);
    $("#Desc").html(data.description);
    $("#weblink").attr("href",data.website);
    $("#Genres").html(genres[focus]);
    setPegi(data.esrb_rating)
    setPlatforms(data);
    getArt(data.name);
}

function setPegi(rating) {
    $("#pegi").show();
    if(rating==null)
        return $("#pegi").hide();
    if(rating.name=="Everyone") 
        $("#pegi").attr("src","images/Icons/pegi3.png");
    else if(rating.slug=="everyone-10-plus") 
        $("#pegi").attr("src","images/Icons/pegi7.png");
    else if(rating.name=="Teen") 
        $("#pegi").attr("src","images/Icons/pegi12.png");
    else if(rating.name=="Mature") 
        $("#pegi").attr("src","images/Icons/pegi16.png");
    else
        $("#pegi").attr("src","images/Icons/pegi18.png");
}

function setPlatforms(data) {
    var pc=false;
    $(".fa-xbox").hide();
    $(".fa-playstation").hide();
    $(".fa-desktop").hide();
    $(".iconify").hide();
    for(var i=0; i<data.platforms.length-1; i++) {
        console.log(data.platforms[i].platform.name);
        if(data.platforms[i].platform.name=="PC" || data.platforms[i].platform.name=="Linux" || data.platforms[i].platform.name=="macOS" || "PC (Windows)") {
            $(".fa-desktop").show();
            pc=true;
            setSystReqs(data.platforms[i].platform.requirements);
        }
        if(data.platforms[i].platform.name=="Xbox" || data.platforms[i].platform.name=="Xbox Series S/X" || data.platforms[i].platform.name=="Xbox One")
            $(".fa-xbox").show();
        if(data.platforms[i].platform.name=="PlayStation 4" || data.platforms[i].platform.name=="PlayStation 5" || data.platforms[i].platform.name=="Playstation")
            $(".fa-playstation").show();
        if(data.platforms[i].platform.name=="Nintendo Switch" || data.platforms[i].platform.name=="Nintendo Wii")
            $(".iconify").show();
    }
    if(!pc)
        setSystReqs(null);
}

function setSystReqs(data) {
    $("#syst-req").show();
    if(data==null)
        $("#max-req, #min-req").text("None");
    else {
        //rawg's api is broken and does not give system reqs correctly
        //may show as blank although API and website do possess and advertise it as working...
        $("#min-req").text(data.minimum_requirements);
        $("#max-req").text(data.maximum_requirements);
    }
}

