//methods are async due to the synchronous option being deprecated
//the overlay for loading is removed after all data has been loading by 
//being a sort of "final" call back 

var Months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", 
    "October", "November", "Decemeber"];

var Days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

// store the entry day aligned with the calendar for reference for the month
var entries = new Array(31);
var date = new Date();
var loading = true;

function log(info) {
    console.log(info);
}

function ToggleLoading(show=false) {
    if(show) {
        $(".loader").fadeOut(500, function () {  
            $(".loader").css("visibility", "hidden");
            $(".grid-container").css("visibility", "visible")
        });   
    }
    else if(!show){
        $('html, body').animate({ scrollTop: 50 }, 'fast');
        $(".grid-container").css("visibility", "hidden")
        $(".loader").fadeIn(100, function() {
            $(".loader").css("visibility", "visible");
        })
    }
}

function setTitle() {
    $("#day-of-month").html(date.getDate());
    $("#month").html(Months[date.getMonth()]);
    $("#year").html(date.getFullYear());
}

function gen_calendar(index) {
    ToggleLoading(false);
    $("#jasonify").text("").hide();
    //var index = Months.indexOf(month);
    $(".entry").show().css("opacity", "1").html("");
    $(".entry").css("background-color", "turquoise");

    //get first day
    date.setMonth(index);
    var manip = new Date();

    //handled automatically for 13? Yes
    //get last day of month
    manip.setMonth(date.getMonth()+1);
    manip.setDate(0);
    var lastDay = manip.getDate();

    //align first day
    manip.setMonth(date.getMonth());
    manip.setDate(1);
    var firstDay = manip.getDay();

    // generate entries
    var i;
    var entry;
    for(i=0; i<firstDay; i++) {
        entry = "#entry-"+i;
        $(entry).css("opacity", "60%");
    }
    for(j=1; j<=lastDay; i++, j++) {
        entry = "#entry-"+i;
        entries[j-1] = i;
        $(entry).append("<div class=\"dates\">"+j+"</div><div><ul class=\"game-list\" id=\"entry-list-"+j+"\"></ul></div>");
    }
    for(j=31-lastDay-1;j<31;j++)
        entry[j-1]=0;

    //hide extra row if not used
    if(i<35) {
        for(j=35; j<42; j++) {
            entry = "#entry-"+j;
            $(entry).hide();
        }
    }
    //make rest of row opaque
    for(;i<42 || i<35; i++) {
        entry = "#entry-"+i;
        $(entry).css("opacity", "60%");
    }
    //log(entries);
    setTitle();
    GenericPost("api.php", genBody(), populate_entries);
    //GenericPost("api.php", genBody(), populate_entries);
    //Generic_Get_Request(populate_entries, URL_gamesByDate_RAWG());
}

function reset_calendar() {
    delete date;
    date = new Date();
    gen_calendar(date.getMonth());
}

//=========================================
// Kill loading screen and add listeners
$(document).ready(function() {
    setTimeout(() => {
        //ToggleLoading();
        $("#today").trigger("click");
    }, 1000);

});

$("#today").click(function() {
    reset_calendar();
    $("#entry-"+entries[date.getDate()-1]).css("background-color", "cornflowerblue");
});

$("#prev-month").click(function() {
    gen_calendar(date.getMonth()-1);
    $("#day-of-month").html("1");
});

$("#next-month").click(function() {
    gen_calendar(date.getMonth()+1);
    $("#day-of-month").html("1");
});

$(".entry").click(function() {
    var ent = $(this).find(".dates").text();
    if(ent>=1 && ent<=31)
        date.setDate(ent);
    setTitle();
});

$("#submit").click(function () { 
    var child = $("li").find("a");
    //log(child[0].text); 
    //log(child[0].id);
    var jason_array = [];//{title : "", date : ""};
    //var jason_array = new jason[child.length];
    var fulldate;

    for(var i=0; i<child.length; i++) {
        //jason_array[i].title = (child[i].text);
        fulldate = child[i].id +"-"+date.getMonth()+"-"+date.getFullYear();
        //jason_array[i].date = fulldate;
        jason_array.push({title : child[i].text, date : fulldate});
    }

    var jason = JSON.stringify(jason_array);
    //log(jason);
    
    
    $("#jasonify").show();
    $("#jasonify").text("{\"Month_Releases\":"+jason+"}");
    
});
//===========================================

function genBody() {
    //month
    var temp= new Date();
    temp.setFullYear(date.getFullYear(), date.getMonth()+1, 0);
    var now = temp.toISOString();
    var hold="";
    var i=0;
    while(now[i]!="T") {
        hold+=now[i];
        i++;
    }
    now=hold;
    temp.setFullYear(date.getFullYear(), date.getMonth(), 1);
    var last = temp.toISOString();
    hold="";
    i=0;
    while(last[i]!="T") {
        hold+=last[i];
        i++;
    }
    last=hold;

    return { //calendar
        "key" : "0000000000",
        "type" : "info",
        "date" : last+","+now,
        "limit" : "13",
        "return" : ["title", "release","site"]
    };

}

function URL_gamesByDate_RAWG() {
    //month
    var temp= new Date();
    temp.setFullYear(date.getFullYear(), date.getMonth()+1, 0);
    var now = temp.toISOString();
    var hold="";
    var i=0;
    while(now[i]!="T") {
        hold+=now[i];
        i++;
    }
    now=hold;
    temp.setFullYear(date.getFullYear(), date.getMonth(), 1);
    var last = temp.toISOString();
        hold="";
        i=0;
    while(last[i]!="T") {
        hold+=last[i];
        i++;
    }
    last=hold;
    
    return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607&dates="+last+","+now+"&page_size=40";
}

function URL_GetRAWG_Game(id) {
    return "https://api.rawg.io/api/games/"+id+"?key=7465f1c4b11d465898232c5155c4d607";
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

//===============================================================
function populate_entries(data) {
    data = data["data"];
    //log(data);
    var day;
    hold = [];
    hold.push(data[0]);
    console.log(hold);
    for(var i=1; i<data.length; i++) {
        if(isDuplicate(hold, data[i]["title"])==false)
            hold.push(data[i]);
    }
    data = hold;

    for(let i=0; i<data.length; i++) {
        day = extract_day(data[i]["release date"]);
        fill_entry(data[i], day);
    }
    ToggleLoading(true);
}

function fill_entry(data, day) {
    if(day[0]=="0")
        day = day[1];
    $("#entry-list-"+day).append("<li><a class=\"gamelink\" id= \""+day+"\"href=\""+data["site"]+"\">"+data["title"]+"</a></li>");
}

function extract_day(data) {
    return data.substr(8,2);
}

function isDuplicate(data, name) {
    for(var i=0; i<data.length; i++) {
        if(data[i]["title"].substr(0,5)==name.substr(0,5))
            return true;
    }
    return false;
}