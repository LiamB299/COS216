$(document).ready(function(){
    //log("On load: "+document.cookie);
    if(getCookieValue(" username")!="") {
        $("#login-form").css("display", "none");
        $("#response-logged").css("display", "block")
        //alert(getCookieValue("username"));
    }
    else {
        $("#login-form").css("display", "block");
        $("#response-logged").css("display", "none");
    }
});

$(".subButton#login-button").click(function() { 
    $("#login-form").css("display", "none");
    $("#response-logged").css("display", "block");
    setLogged(true);
});

$("#showpass").click(function (e) { 
    e.preventDefault();
});