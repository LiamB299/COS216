//methods are async due to the synchronous option being deprecated
//the overlay for loading is removed after all data has been loading by 
//being a sort of "final" call back 

var games = [];
var focus;
var user;

$(document).ready(function() {
    //ToggleLoading(true);
    user = false;
    $("#Year").trigger("click");
});

function log(info) {
    console.log(info);
}
//================================================

$("#user-rank-butt").on("click", function () {
    body = {
        "type" : "info",
        "key" : sessionStorage.getItem("key"),
        "user_ratings" : "true"
    };
    user = true;
    GenericPost("api.php", body, UserRankings);
});

function UserRankings(data) {
    if(data["status"]=="error") {
        alert(data["explanation"]);
        user = true;
        $("#Year").trigger("click");
        return;
    }
    focus = 0;
    games = data["data"];
    gen_user_rating();
}

function gen_user_rating() {
    $("#period").text("User ratings");
    $("#sub-modal").prop("disabled", true);
    data = games;
    var index1 = focus;
    var index2 = focus+1;
    var index3 = focus+2;
    if(index1==games.length-1) {
        index2=0;
        index3=1;
    }
    else if(index2==games.length-1)
        index3=0;

    setBox(1, data[index1]["score"], data[index1]["artwork"],
        data[index1]["gametitle"], data[index1]["metacritic"], "");

    setBox(2, data[index2]["score"], data[index2]["artwork"],
        data[index2]["gametitle"], data[index2]["metacritic"], "");

    setBox(3, data[index3]["score"], data[index3]["artwork"],
        data[index3]["gametitle"], data[index3]["metacritic"], "");

    ToggleLoading(true);
}

function setBox(entry, userRank, artwork, title, dev, plats) {
    $("#score-"+entry).text(userRank);
    $("#box-"+entry).attr("src", artwork);
    $("#title-"+entry).text(title);
    $("#dev-"+entry).text(dev);
    $("#plat-"+entry).text(plats);
    return;
}

//================================================

//================================================
// Listeners
$(".fa-angle-double-left").click(function() {
    previous();
});

$(".fa-angle-double-right").click(function() {
    next();
});

$("#Month").click(function() {
    user=false;
    var period = 1;
    $("#period").html("Month");
    //Generic_Get_Request(genList, URL_GetRawgTopGames(period));
    GenericPost("api.php", genBody(period), genList);
    $("#period").text("Month");
});

$("#Year").click(function() {
    user=false;
    var period = 2;
    $("#period").html("Year");
    //Generic_Get_Request(genList, URL_GetRawgTopGames(period));
    GenericPost("api.php", genBody(period), genList);
    $("#period").text("Past Year");
});

$("#Ten-years").click(function() {
    user=false;
    var period = 3;
    $("#period").html("Ten-Years");
    //Generic_Get_Request(genList, URL_GetRawgTopGames(period));
    GenericPost("api.php", genBody(period), genList);
    $("#period").text("Last 10 Years");
});

$("#all-time").click(function() {
    user=false;
    var period = 0;
    $("#period").html("All time");
    //Generic_Get_Request(genList, URL_GetRawgTopGames(period));
    GenericPost("api.php", genBody(period), genList);
    $("#period").text("All Time");
});

function previous() {
    ToggleLoading(false);
    if(focus==0)
        focus = games.length-1;
    else
        focus--;
    if(user)
        gen_user_rating();
    else
        genEntries();
}

function next() {
    ToggleLoading(false);
    if(focus==games.length-1)
        focus=0;
    else
        focus++;
    if(user)
        gen_user_rating();
    else
        genEntries();
}

//================================================
//init
function genList(data) {
    data = data["data"];
    //console.log(data);
    ToggleLoading(false);
    games = [];
    games.push(data[0]);
    for(let i=1; i<data.length; i++) {
        if(data[i]["title"].substr(0,5)==data[i-1]["title"].substr(0,5))
            games[i-1]=data[i];
        else
            games.push(data[i]);
    }
    first();
}

function first() {
    focus=0;
    genEntries();
}

function genEntries() {
    $("#sub-modal").prop("disabled", false);
    var index1 = focus;
    var index2 = focus+1;
    var index3 = focus+2;
    if(index1==games.length-1) {
        index2=0;
        index3=1;
    } 
    else if(index2==games.length-1)
        index3=0;


    setScore(games[index1]["metacritic"],1);
    setScore(games[index2]["metacritic"],2);
    setScore(games[index3]["metacritic"],3);

    setTitle(games[index1]["title"],1);
    setTitle(games[index2]["title"],2);
    setTitle(games[index3]["title"],3);

    setPlat(games[index1]["platforms"], 1);
    setPlat(games[index2]["platforms"], 2);
    setPlat(games[index3]["platforms"], 3);

    SetArtDev(games[index1],1);
    SetArtDev(games[index2],2);
    SetArtDev(games[index3],3);

}

//====================================================================
// Field updates
function setScore(data,box) {
    var sObj = "#score-"+box;
    $(sObj).html(data);
    //console.log(sObj);
}

function setArt(data,box) {
    var sObj = "#box-"+box;
    $(sObj).attr("src", data);
    ToggleLoading(true);
}

function setTitle(data,box) {
    var sObj = "#title-"+box;
    $(sObj).text(data);
}

function setDev(data,box) {
    var sObj = "#dev-"+box;
    $(sObj).html(data);
}

function setPlat(data,box) {
    var sObj = "#plat-"+box;
    var plats="";
    for(var i=0; i<data.length-1; i++) {
        plats += data[i];
        plats+=", "
    }
    plats+= data[data.length-1];
    $(sObj).html(plats);
}

function GetArtDev_1(title, box) {
    Generic_Get_Request(GetArtDev_2, URL_GB_ID(title), true, box);
}

function GetArtDev_2(data, box) {
    Generic_Get_Request(SetArtDev, URL_GB_Game(data.results[0].id), true, box);
}

function SetArtDev(data, box) {
    setArt(data["artwork"], box);
    setDev(data["developers"][0], box);
}

//================================================
//Loading screen
function ToggleLoading(show=false) {
    if(show) {
        $(".loader").fadeOut(500, function () {  
            $(".loader").css("visibility", "hidden");
            $(".tafel").css("visibility", "visible")
        });   
    }
    else if(!show){
        $('html, body').animate({ scrollTop: 50 }, 'fast');
        $(".tafel").css("visibility", "hidden")
        $(".loader").fadeIn(100, function() {
            $(".loader").css("visibility", "visible");
        })
    }
}

//==============================================================

function genBody(period) {
    let hold = "";
    //month
    if(period==1) {
        var date = new Date();
        var now = date.toISOString();
        var i=0;
        while(now[i]!="T") {
            hold+=now[i];
            i++;
        }
        now=hold;
        date.setDate(-1);
        var last = date.toISOString();
        hold="";
        i=0;
        while(last[i]!="T") {
            hold+=last[i];
            i++;
        }
    }
    //year
    else if(period==2) {
        var date = new Date();
        var now = date.toISOString();
        var i=0;
        while(now[i]!="T") {
            hold+=now[i];
            i++;
        }
        now=hold;
        date.setFullYear(date.getFullYear()-1);
        var last = date.toISOString();
        hold="";
        i=0;
        while(last[i]!="T") {
            hold+=last[i];
            i++;
        }
    }
    //10 years
    else if(period==3) {
        var date = new Date();
        var now = date.toISOString();
        var i=0;
        while(now[i]!="T") {
            hold+=now[i];
            i++;
        }
        now=hold;
        date.setFullYear(date.getFullYear()-10);
        var last = date.toISOString();
        //log(last);
        hold="";
        i=0;
        while(last[i]!="T") {
            hold+=last[i];
            i++;
        }
    }
        last=hold;
        delete date;

        if(last!="") {
            return  {
                "key": "0000000000",
                "type": "info",
                "date": last + "," + now,
                "limit": "6",
                "order": "-metacritic",
                "return": ["title", "developers", "artwork", "metacritic", "platforms"]
            };
        }
        else {
            return {
                "key": "0000000000",
                "type": "info",
                "limit": "6",
                "order": "-metacritic",
                "return": ["title", "developers", "artwork", "metacritic", "platforms"]
            };
        }
}

// URL Builders
// Get best of all time by default
function URL_GetRawgTopGames(period) {
    //month
    if(period==1) {
        var date = new Date();
        var now = date.toISOString();
        var hold="";
        var i=0;
        while(now[i]!="T") {
            hold+=now[i];
            i++;
        }
        now=hold;
        date.setMonth(-1);
        var last = date.toISOString();
            hold="";
            i=0;
        while(last[i]!="T") {
            hold+=last[i];
            i++;
        }
        last=hold;
        delete date;
        return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&ordering=-metacritic&dates="+last+","+now;
    }
    //year
    else if(period==2) {
        var date = new Date();
        var now = date.toISOString();
        var hold="";
        var i=0;
        while(now[i]!="T") {
            hold+=now[i];
            i++;
        }
        now=hold;
        date.setFullYear(date.getFullYear()-1);
        var last = date.toISOString();
            hold="";
            i=0;
        while(last[i]!="T") {
            hold+=last[i];
            i++;
        }
        last=hold;
        delete date;
        return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&ordering=-metacritic&dates="+last+","+now;
    }
    //10 years
    else if(period==3) {
        var date = new Date();
        var now = date.toISOString();
        var hold="";
        var i=0;
        while(now[i]!="T") {
            hold+=now[i];
            i++;
        }
        now=hold;
        date.setFullYear(date.getFullYear()-10);
        var last = date.toISOString();
        //log(last);
        hold="";
        i=0;
        while(last[i]!="T") {
            hold+=last[i];
            i++;
        }
        last=hold;
        delete date;
        return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&ordering=-metacritic&dates="+last+","+now;
    }
    // All time
    else {
        return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&ordering=-metacritic";
    }
}

function URL_GB_ID(title) {
    return "https://www.giantbomb.com/api/search/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json&resources=game&field_list=id,name&limit=1&query="+title;
}

function URL_GB_Game(id) {
    return "https://www.giantbomb.com/api/game/"+id+"/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json&field_list=image,developers";
}

//================================================================
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
        else if( this.status == 403 || this.status == 404)
            //throw exception
            return "";
    }  
}


