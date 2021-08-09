//socket io handles reconnections. No manual intervention is necessary
//Relevant alerts are added to show if the disconnection wasn't expected
const socket = io("http://localhost:8080");
const button = document.getElementById("subBut");
const field1 = document.getElementById("inText1");
const field2 = document.getElementById("inText2");

let comments;
var friends;

$(document).ready(function() {
    if(sessionStorage.getItem("key")=="0000000000")
        window.location.replace("../featured.php");

   sessionStorage.setItem("videoURL", $("video").attr("src"));
   sessionStorage.setItem("videostamp", "0");
   comments = [];
   friends = [];
   friends.push({
       name : "You",
       key : sessionStorage.getItem("key")
   });
   alert(sessionStorage.getItem("key"));
});

setInterval(syncVideo, 1000);

//sync to server
function syncVideo() {
    const Curr_videostamp = video.currentTime;
    const old_videostamp = parseInt(sessionStorage.getItem("videostamp"));
    if(Curr_videostamp!=old_videostamp) {
        sessionStorage.setItem("videostamp", Curr_videostamp);
        socket.emit("syncVideo", {
            key : sessionStorage.getItem("key"),
            videostamp : Curr_videostamp,
            videoURL: $("video").attr("src")
        });
    }
}

socket.on("connect", () => {
    msg = {
        "type" : "KeySet",
        "data" : sessionStorage.getItem("key"),
        "videoURL" : $("video").attr("src")
    }
    socket.emit("msg", msg);
    //setVideo
});

button.onclick = () => {
    //console.log(field.value);
    msg = {
        "type" : field1.value,
        "data" : field2.value
    }
    socket.emit("msg", msg);
};

socket.on("NewComment", (data) => {
    console.log(data);
    console.log(friends);
    alert(contains(friends, "key", data["key"]));
    const ins = $("#comments-title");
    if(contains(friends, "key", data["key"])) {
        ins.after("<div class=\"grid-container-comments\">\n" +
            "        <a class=\"grid-item-posted\">"+convertTimestamp(data["timestamp"])+"</a>\n" +
            "        <a class=\"grid-item-timestamp\">"+convertVideostamp(data["videostamp"])+"</a>\n" +
            "        <div class=\"grid-item-comment-text\"><span class=\"username\">"+
            GetName(friends, data["key"])+": "+"</span>"+data["comment"]+"</div>\n" +
            "    </div>");
    }
});

function contains(data, key, find) {
    for(let i=0; i<data.length; i++) {
        if(data[i][key]==find)
            return true;
    }
    return false;
}

function GetName(data, key) {
    for(let i=0; i<data.length; i++) {
        if(data[i]["key"]==key)
            return data[i]["name"];
    }
}

socket.on("FriendsSet", (msg) => {
    msg = msg["data"];
    for(let i=0; i<msg.length; i++) {
        friends.push({
            name : msg[i]["name"],
            key : msg[i]["API_Key"]
        });
    }
});

socket.on("videoSet", (msg) => {
    alert("progress received");
    const video = document.getElementById("video");
    //console.log(msg);
    sessionStorage.setItem("videostamp", msg);
    video.currentTime = parseInt(msg);
});

socket.on("KILL", (msg) => {
   console.log(msg);
});

socket.on("ID", (msg) => {
    console.log("Connected, ID: "+msg);
});

socket.on("disconnect", (reason) => {
    alert("Disconnected, see log");
    console.log("Disconnect reason: "+reason);
    if(reason === "io server disconnect" || reason === "io client disconnect") {
        //nothing wrong disconnect intended
        //while(socket.socket.connected) {
        //    socket.socket.connect();
        //}
    }
    else if(reason === "ping timeout" || reason === "transport close") {
        //unintentional disconnect, reconnect is automated by socket.io
        //while(socket.socket.connected) {
        //    socket.socket.connect();
        //}
        alert("reconnecting to server...");
        console.log("reconnecting via socket.io");
    }
});

socket.on("error", (msg) => {
    console.log(msg);
});

socket.on("CommentSet", (data) => {
    const ins = $("#comments-title");
    for(let i=0; i<data.length; i++) {
        comments.push(data[i]);
        ins.after("<div class=\"grid-container-comments\">\n" +
            "        <a class=\"grid-item-posted\">"+convertTimestamp(data[i]["timestamp"])+"</a>\n" +
            "        <a class=\"grid-item-timestamp\">"+convertVideostamp(data[i]["videostamp"])+"</a>\n" +
            "        <div class=\"grid-item-comment-text\"><span class=\"username\">"+
            data[i]["name"]+": "+"</span>"+data[i]["comment"]+"</div>\n" +
            "    </div>");
    }
    /*+data[i]["surname"]+", "+
            data[i]["name"]+": "+"*/
    $(".grid-item-timestamp").on("click", function() {
        updateVideo(this);
    });
});

$("#post-button").on("click", function() {
    const video = document.getElementById("video");
    let payload = {
        comment : $("#comments-input").val(),
        key : sessionStorage.getItem("key"),
        videoID : $("video").attr("src"),
        timestamp : Date.now(),
        videostamp : video.currentTime,
    };
    socket.emit("sendComment", payload);
});

function convertTimestamp(ts) {
    const date = new Date(parseInt(ts));
    return date.getDate()+
        "/"+(date.getMonth()+1)+
        "/"+date.getFullYear()+
        "<br>"+
        " "+date.getHours()+
        ":"+date.getMinutes()+
        ":"+date.getSeconds();
}

function convertVideostamp(vs) {
    let sline = Math.floor(vs/60);
    sline += ":";
    sline += (vs-Math.floor(vs/60)*60);
    return sline;
}

function updateVideo(element) {
    let form = element.text;
    let time = form.substr(0,form.indexOf(":"));
    time = parseInt(time)*60;
    let time2 = parseInt(form.substr(form.indexOf(":")+1,form.length-form.indexOf(":")));
    time = time + time2 ;
    const video = document.getElementById("video");
    video.currentTime = time;
}

socket.on("QUIT", (msg) => {
   alert(msg);
});

