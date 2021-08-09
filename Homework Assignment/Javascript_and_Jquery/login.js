$(document).ready(function(){
    if(sessionStorage.getItem("username")==null) {
        $("#login-form").css("display", "block");
        $("#response-logged").css("display", "none")
    }
    else {
        $("#login-form").css("display", "none");
        $("#response-logged").css("display", "block");
    }
});

$(".subButton#login-button").click(function() { 
    let email = $("#email").val();
    let pass =  $("#password").val();

    let data = {
        "email" : email,
        "password" : pass
    };

    GenericPost("PHP files/validate-login.php", data, validate, data);

});
//==========================================

function validate(response, data) {
    if(response["status"]=="success")
        Process(data);
    else {
        alert(response["explanation"]);
        return;
    }
}

function Process(data) {
    //post to api for info
    body = {
        "key" : sessionStorage.getItem("key"),
        "type" : "login",
        "email" : data["email"]
    }

    GenericPost("api.php", body, finalize);
}

function finalize(data) {
    if(data["status"]=="error") {
        alert(data["explanation"]);
        log(sessionStorage.getItem("key"));
        return;
    }

    $("#login-form").css("display", "none");
    $("#response-logged").css("display", "block");

    //console.log(data);
    //set dom
    sessionStorage.clear();
    sessionStorage.setItem("username", data["name"]);
    sessionStorage.setItem("key", data["Key"]);
    sessionStorage.setItem("theme", data["theme"]);
    sessionStorage.setItem("genre", data["genre"]);
    sessionStorage.setItem("platform", data["platform"]);
    sessionStorage.setItem("score", data["score"]);

    //console.log(sessionStorage.getItem("key"));
    //console.log(sessionStorage.getItem("username"));
    //set php
    setLogged(true);
    setTimeout(function() {
        window.location.replace("node/video.php")
    }, 1000);
}



//==========================================

$("#showpass").click(function () {
    var element = document.getElementById("password");
    if(element.type == "password")
        element.type = "text";
    else
        element.type = "password";
});