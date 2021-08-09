//===============================================
function setCookies(username) {
    if(username==null) {
        console.log("failure");
        return;
    }
    //Clear_cookies();
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