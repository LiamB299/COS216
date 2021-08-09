//$(window).ready(fillPage);

$("#friends-reform").on("click", reform);
$(".close#friends-close").on("click", function () {
    $(".friends-modal").css("display", "none");
});

$("a#friends").on("click", function () {
    $(".friends-modal").css("display", "block");
    fillPage();
});

window.onclick = function(event) {
    if (event.target == $(".friends-modal")) {
        $(".friends-modal").css("display", "none");
    }
}

function reform() {
    if(this.textContent=="Grid") {
        $("#friend-big").addClass("friend-big-cont-grid");
        $("#friend-big").removeClass("friend-big-cont-row");
        $(".grid-container-friends-row").addClass("grid-container-friends-grid");
        $(".grid-container-friends-row").removeClass("grid-container-friends-row");
        $(".friends-title").css("grid-column", "1 /span 1");
            //style.gridColumn="1 / span 1";
        this.innerHTML = "Block";
    }
    else {
        $("#friend-big").addClass("friend-big-cont-row");
        $("#friend-big").removeClass("friend-big-cont-grid");
        $(".grid-container-friends-grid").addClass("grid-container-friends-row");
        $(".grid-container-friends-grid").removeClass("grid-container-friends-grid");
        $(".friends-title").css("grid-column", "1 /span 2");
        //style.gridColumn="1 / span 2";
        this.innerHTML = "Grid";
    }
}

function fillPage() {
    $(".add-friend").remove();
    $(".cancel-friend").remove();
    $(".un-friend").remove();
    $(".conf-friend").remove();
    $(".friend-name").remove();

    if(sessionStorage.getItem("key")==null || sessionStorage.getItem("key")=="0000000000") {
        console.log(sessionStorage.getItem("key"));
        $(".friends-modal").css("display", "none");
        return;
    }
    key = sessionStorage.getItem("key");
    body = {
        "key" : key,
        "type" : "friends",
        "use" : "get",
        "user2" : "0",
        "get" : "friends"
    }
    GenericPost("api.php", body, fillfriends);

    body = {
        "key" : key,
        "type" : "friends",
        "use" : "get",
        "user2" : "0",
        "get" : "pending"
    }
    GenericPost("api.php", body, fillpending);

    body = {
        "key" : key,
        "type" : "friends",
        "use" : "get",
        "user2" : "0",
        "get" : "not"
    }
    GenericPost("api.php", body, fillNotfriends);

    body = {
        "key" : key,
        "type" : "friends",
        "use" : "get",
        "user2" : "0",
        "get" : "confirm"
    }
    GenericPost("api.php", body, fillConffriends);
}

function fillConffriends(data) {
    if(data["status"]=="error") {
        log(data["explanation"])
        return;
    }

    data = data["data"];
    for(let i=0; i<data.length; i++) {
        user = data[i];
        $("#conf-option").after("<div class=\"grid-item-friends friend-name\">\n" +
            "                "+user["name"]+" "+user["surname"]+"\n" +
            "            </div>\n" +
            "            <div class=\"grid-item-friends conf-friend\" id=\""+user["API_Key"]+"\">\n" +
            "                Confirm\n" +
            "            </div>");
    }
    $(".grid-item-friends.conf-friend").on("click", submitFriend);
}

function fillfriends(data) {
    if(data["status"]=="error") {
        log(data["explanation"])
        return;
    }
    data = data["data"];
    for(let i=0; i<data.length; i++) {
        user = data[i];
        $("#unfriend-option").after("<div class=\"grid-item-friends friend-name\">\n" +
            "                "+user["name"]+" "+user["surname"]+"\n" +
            "            </div>\n" +
            "            <div class=\"grid-item-friends un-friend\" id=\""+user["API_Key"]+"\">\n" +
            "                Unfriend\n" +
            "            </div>");
    }
    $(".grid-item-friends.un-friend").on("click", submitFriend);
}

function fillpending(data) {
    if(data["status"]=="error") {
        log(data["explanation"])
        return;
    }
    data = data["data"];
    for(let i=0; i<data.length; i++) {
        user = data[i];
        $("#pending-option").after("<div class=\"grid-item-friends friend-name\">\n" +
            "                "+user["name"]+" "+user["surname"]+"\n" +
            "            </div>\n" +
            "            <div class=\"grid-item-friends cancel-friend\" id=\""+user["API_Key"]+"\">\n" +
            "                Cancel Request\n" +
            "            </div>");
    }
    $(".grid-item-friends.cancel-friend").on("click", submitFriend);
}

function fillNotfriends(data) {
    if(data["status"]=="error") {
        log(data["explanation"])
        return;
    }
    data = data["data"];
    for(let i=0; i<data.length; i++) {
        user = data[i];
        $("#add-option").after("<div class=\"grid-item-friends friend-name\">\n" +
            "                "+user["name"]+" "+user["surname"]+"\n" +
            "            </div>\n" +
            "            <div class=\"grid-item-friends add-friend\" id=\""+user["API_Key"]+"\">\n" +
            "                Send Friend Request\n" +
            "            </div>");
    }
    $(".grid-item-friends.add-friend").on("click", submitFriend);
}

function submitFriend() {
    //alert("Unfriend");
    if(this.classList.contains("un-friend")) {
        body = {
            "key" : sessionStorage.getItem("key"),
            "type" : "friends",
            "use" : "submit",
            "user2" : this.id,
            "get" : "unfriend"
        }
        GenericPost("api.php", body, refresh);
    }
    else if(this.classList.contains("cancel-friend")) {
        body = {
            "key" : sessionStorage.getItem("key"),
            "type" : "friends",
            "use" : "submit",
            "user2" : this.id,
            "get" : "cancel"
        }
        GenericPost("api.php", body, refresh);
    }
    else if(this.classList.contains("add-friend")) {
        body = {
            "key" : sessionStorage.getItem("key"),
            "type" : "friends",
            "use" : "submit",
            "user2" : this.id,
            "get" : "add"
        }
        GenericPost("api.php", body, refresh);
    }
    else if(this.classList.contains("conf-friend")) {
        body = {
            "key" : sessionStorage.getItem("key"),
            "type" : "friends",
            "use" : "submit",
            "user2" : this.id,
            "get" : "confirm"
        }
        GenericPost("api.php", body, refresh);
    }
    else
        alert("Button type unfound")
    return;
}

function refresh() {
    window.refresh();
}

