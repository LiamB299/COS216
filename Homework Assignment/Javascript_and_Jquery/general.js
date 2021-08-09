//methods are async due to the synchronous option being deprecated
//the overlay for loading is removed after all data has been loading by 
//being a sort of "final" call back 

function log(data) {
    console.log(data);
}


$(document).ready(function() {
   if(sessionStorage.getItem("theme")=="d")
       setDay();
   else
       setNight();

   if(sessionStorage.getItem("key")==null && sessionStorage.getItem("username")==null)
       sessionStorage.setItem("key", "0000000000");
});

//==================================
$("#day").on("click" ,function () {
    setDay();
    DayNightsetPref(true);
    sessionStorage.setItem("theme", "d");
});

function setDay() {
    $("nav").css("background-color", "rgba(7,17,23,0.55)");
    $("html").css("background-color", "rgba(23,15,10,0.4)");
}

$("#night").on("click",function () {
    setNight();
    DayNightsetPref(false);
    sessionStorage.setItem("theme", "n");
});

function setNight() {
    $("nav").css("background-color", "#474747");
    $("html").css("background-color", "#333333");
}

function DayNightsetPref(day) {
    if(sessionStorage.getItem("key")==null)
        return;
    else if(day) {
        let body = {
            "key" : sessionStorage.getItem("key"),
            "type" : "update",
            "set" : "theme",
            "values" : "d"
        };
        GenericPost("api.php", body, error_check);
    }
    else {
        console.log(sessionStorage.getItem("key"));
        let body = {
            "key" : sessionStorage.getItem("key"),
            "type" : "update",
            "set" : "theme",
            "values" : "n"
        };
        GenericPost("api.php", body, log);

    }
}

//==================================

function GenericRequest(callback, url) {
    //XMLHTTP object
    var req = new XMLHttpRequest();
    //API request, true for async operation
    req.open("GET", url, true);
    //Sends request
    req.send();
    //check status
    req.onreadystatechange = function() {
        //success
        if(this.readyState == 4 && this.status == 200)
            callback(this);
        else if( this.status == 403 || this.status == 403)
            //throw exception
            return "";
    }       
}

function formParameters(data) {
    log(data);
    var ret = [];
    for(var i in data) {
        //log(i);
        ret.push(encodeURIComponent(i)+"="+encodeURIComponent(data[i]));
    }
    return ret.join("&");
}

//bodydata is a json string
function GenericPost(url, Bodydata, callback=null, arg=null, arg2=null) {
    //Object
    var req = new XMLHttpRequest();
    //Request type
    req.open("POST", url, true);
    //Secure POST
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //Compose body and begin request
    //log(formParameters(Bodydata));
    //req.send(formParameters(Bodydata));
    req.send($.param(Bodydata));
    //check status
    req.onreadystatechange = function() {
        //success
        if(this.readyState == 4 && this.status == 200) {
            //log(req.responseText);
            if(callback==null)
                return;
            //log(req.responseText);
            try {
                callback(JSON.parse(req.responseText), arg, arg2);
            }
            catch (err) {
                console.log(req.responseText);
            }
        }
        else if( this.status == 403 || this.status == 403)
            //throw exception
            return "";
    } 

}


//====================
//logging in

function setLogged(status) {
    if(status) {
        body = {
            "login" : "true",
            "username" : sessionStorage.getItem("username")
        }
        GenericPost("PHP files/config.php", body, error_check);
    }
    else {
        GenericPost("PHP files/config.php", {
            "login" : "false"
        }, error_check);
        sessionStorage.clear();
        sessionStorage.setItem("key", "0000000000");
        $("#admin").trigger('click');
    }
}

function error_check(data) {
    if(data["status"]=="error")
        log(data["explanation"]);
}

function refresh() {
    window.location.reload();
}

$("#logout").click(function() {
    setLogged(false);
    alert("logout");
    refresh();
});

//====================

//====================

//====================