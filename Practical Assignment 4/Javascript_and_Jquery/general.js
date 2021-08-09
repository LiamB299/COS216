//methods are async due to the synchronous option being deprecated
//the overlay for loading is removed after all data has been loading by 
//being a sort of "final" call back 

function log(data) {
    console.log(data);
}


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
            log(req.responseText);
            callback(JSON.parse(req.responseText), arg, arg2);
        }
        else if( this.status == 403 || this.status == 403)
            //throw exception
            return "";
    } 

}


//====================
//logging in

function setLogged(status) {
    //proof of concept
    //this will be done server side correctly in P4...
    //php cookies might be a better option
    if(status) {
        GenericPost("PHP files/config.php", {
            "login" : "true"
        }, setCookies);
    }
    else {
        GenericPost("PHP files/config.php", {
            "login" : "false"
        }, refresh);
    }
}

function setCookies(username) {
    if(username==null) {
        console.log("failure");
        return;
    }
    Clear_cookies();
    document.cookie = "username = "+username["user"]+"; path=/;";
    refresh();
}

function getCookieValue(field) {
    var fields = decodeURIComponent(document.cookie).split(";");
    //log(fields);
    for(var i=0; i<fields.length; i++) {
        fieldpair = fields[i].split("=");
        //log(fieldpair);
        if(fieldpair[0]==field)
            return fieldpair[1];
    }
    return "";
}

function Clear_cookies() {
    document.cookie = "username="+""+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    //var list = document.cookie.split(";");
    //for(var i=0; i<0; i++) {
    //    var cookie = list[i];
    //    var pos = cookie.indexOf("=");
    //    if(pos > -1) {
    //        var remove = cookie.substr(0, pos);
    //    }
    //    else
    //        var remove = cookie;
    //    document.cookie = remove + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    //}
}

function refresh() {
    window.location.reload();
    //log(document.cookie);
}

$("#logout").click(function() {
    alert("logout");
    setLogged(false);
    Clear_cookies();
    refresh();
    //log(document.cookie);
});