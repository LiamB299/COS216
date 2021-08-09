//methods are async due to the synchronous option being deprecated
//the overlay for loading is removed after all data has been loading by 
//being a sort of "final" call back 

$(document).ready(function() {
    OnGameChange();
});

var Months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", 
    "October", "November", "Decemeber"];

//featured game list, this can be populated from rawg straight but I wanted a curated list of some of my favorites :) 
var games = ["Breath of the wild", "Mass Effect Legendary Edition", "fallen order", "Dark Souls 3", "Minecraft", "Resident evil 2", "Batman Arkham Knight", "Mario Odyssey"];
var index=0;

//function for scrolling to previous game 
function previous() {
    index--;
    if(index<0)
        index = games.length-1;
    OnGameChange(games[index]);
}

//function for scrolling to next game
function next() {
    index++;
    if(index==games.length)
        index = 0;
    OnGameChange(games[index]);
}

function ToggleLoading(show=false) {
    if(show) {
        $(".loader").fadeOut(500, function () {  
            $(".loader").css("visibility", "hidden");
        });
        $(".tafel").css("visibility", "visible")
    }
    else if(!show){
        $(".loader").fadeIn(10, function() {
            $(".loader").css("visibility", "visible");
        })
        $(".tafel").css("visibility", "hidden")
    }
}

//========Listeners====================
$(".fa-angle-double-left").dblclick(function() {
    previous();
});

$(".fa-angle-double-right").dblclick(function() {
    next();
});


// AJAX requests
function OnGameChange(title="Breath of the wild") {
    ToggleLoading(false);
    let body = {
        "key" : "0000000000",
        "type" : "info",
        "limit" : "1",
        "title" : title,
        "return" : ["title", "release", "genres", "platforms", "description", "video", "developers", "artwork"]
    };
    GenericPost("api.php", body, fillFeat);
    //Generic_Get_Request(ChangeVideo,YoutubeURLReq(title), async);
    //IGDB_Post_Request(null, "Mass effect 2");
    //Generic_Get_Request(GetGiantBombID, GiantBomb_ID_URL(title), async);
}

function fillFeat(data) {
    data = data["data"][0];
    ChangeVideo(data["video"]);
    SetTitles(data["title"]);
    SetDesc(data["description"]);
    SetReleaseDate(data["release date"]);
    SetGenres(data["genres"]);
    SetDeveloper(data["developers"]);
    SetPlatforms(data["platforms"]);
    change_Art(data["artwork"]);
    ToggleLoading(true);
}

//=========================================================
//callbacks for info
function ChangeVideo(req) {
    console.log(req);
    //document.getElementById("youtube-video").src = "https://www.youtube.com/embed/"+req;
    document.getElementById("youtube-video").src = req;
}

function SetTitles(title) {
    $(".title").html(title);
}

function SetDesc(desc) {
    document.getElementById("desc").innerHTML = desc;
}

function SetReleaseDate(rd) {
    document.getElementById("rel").innerHTML = rd;
}

function SetGenres(gen) {
    document.getElementById("genre").innerHTML = gen;
}

function SetDeveloper(dev) {
    document.getElementById("devel").innerHTML = dev;
}

function SetPlatforms(plats) {
    //console.log(plats);
    $("#ps").hide();
    $("#pc").hide();
    $("#xbox").hide();
    $("#switch").hide();
    //format based on platforms received
    for(var i=0; i<plats.length; i++) {
        if(plats[i]=="Xbox 360" || plats[i]=="Xbox One")
            $("#xbox").show();
        else if(plats[i]=="PlayStation 4" || plats[i]=="Playstation 3")
            $("#ps").show();
        else if(plats[i]=="PC")
            $("#pc").show();
        else if(plats[i]=="Nintendo Switch" || plats[i]=="Wii U")
            $("#switch").show();

    }
}

function change_Art(link) {
    var box = document.getElementById("feat-boxart");
    box.src = link;
}

//=====================================

//==================================================================
function GetGiantBombID(file) {
    var gameURL = GiantBomb_Game_info_URL(file.results[0].id);
    Generic_Get_Request(ProcessJSONGiantBomb, gameURL)
}

// JSON Processing
function ProcessJSONGiantBomb(file) {
    //console.log(file);
    change_Art(file.results.image.original_url);
    SetTitles(file.results.name);
    SetDesc(file.results.deck);
    if(file.results.original_release_date!=null)
        SetReleaseDate(file.results.original_release_date);
    else {
        var sline = file.results.expected_release_day+" "+
            Months[file.results.expected_release_month-1]+ " "+
            file.results.expected_release_year+ " ";
        SetReleaseDate(sline);
    }
    var plats = [];
    for(var i=0; i<file.results.platforms.length; i++) {
        plats.push(file.results.platforms[i].name)
    }
    SetPlatforms(plats);
    var devs = [];
    for(var i=0; i<file.results.developers.length; i++) {
        devs.push(file.results.developers[i].name)
    }
    SetDeveloper(devs);
    var genre = [];
    for(var i=0; i<file.results.genres.length; i++) {
        genre.push(file.results.genres[i].name)
    }
    SetGenres(genre);
    ToggleLoading(true);
}


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
            //throw exception
            return "";
    }
}

// igdb uses post requests :(
/*
function IGDB_Post_Request(callback, name) {
    //XMLHTTP object
    var req = new XMLHttpRequest();
    //API request, true for async operation
    req.open("POST", "https://api.igdb.com/v4/games", true);
    //Generate HTML Form
    //Header
    req.setRequestHeader("Client-ID", "cc7xpg2ona0lsdhhvm529k1kv205l3");
    req.setRequestHeader("Authorization","Bearer ostcfcrhyjq74722qw4se1qe1rz8ng");
    //req.setRequestHeader("Access-Control-Allow-Origin", "https://api.igdb.com/v4/games");
    //Body
    body = "search \" Mass effect 2 \"; fields cover;";
    //"search \""+name+"\"; fields cover;";
    //Sends request
    req.send(body);
    //check status
    req.onreadystatechange = function() {
        //success
        if(this.readyState == 4 && this.status == 200) {
            //callback processes request
            alert("processed");
            //callback(JSON.parse(this.responseText));
        }
        else if( this.status == 403 || this.status == 404)
            //throw exception
            alert("error");
            //alert(JSON.parse(this.responseText));
    }
}
*/


// URL Builders
//=====================video=========================
function YoutubeURLReq(title) {
    return "https://www.googleapis.com/youtube/v3/search?part=snippet&key=AIzaSyAlmD-5UFXkjT40VnKa7l112MYZ9txaugM&type=video&videoDefinition=high&maxResults=1&q="+title+" trailer";
}

function GiantBomb_ID_URL(title) {
    return "https://www.giantbomb.com/api/search/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json&resources=game&field_list=id&limit=1&query="+title;
}

function GiantBomb_Game_info_URL(id) {
    return "https://www.giantbomb.com/api/game/"+id+"/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json";
}
