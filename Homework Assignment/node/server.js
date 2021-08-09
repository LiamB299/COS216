const express = require("express");
const expressApp = express();
const http = require("http");
const server = http.createServer(expressApp);
const {Server} = require("socket.io");
const io = new Server(server);
const api = require("./post");

//setup server
server.listen(process.argv[2], () => {
    console.log("listening on "+process.argv[2]);
});

var instance_data = function() {
    this.userKey="0000000000";
    this.last_timestamp=0;
    this.curr_timestamp=0;
    this.videoURL="";
    this.videoStamp=0;
    this.friends = [];
};

//socket listener
io.on("connection", async(socket) => {
    console.log("connected to client");
    socket.emit("ID", socket.id);
    //console.log(socket.id);

    var user = new instance_data();
    const intervalID = setInterval(sync, 1000, user);

    socket.on('disconnect', () => {
        console.log('user '+socket.id+' disconnected');
        //users.splice(users.indexOf(localUser),1);
        clearInterval(intervalID);
        //removed automatically serverside on disconnect
    });

    io.local.emit("test", "test message");

    socket.on("test", (msg) => {
       console.log(msg);
    });

    socket.on("msg", async(payload) => {
        console.log("Payload: "+payload["type"]);
        if(payload["type"]=="ID")
            ID(socket);
        else if(payload["type"]=="KeySet") {
            user.userKey = payload["data"];
            console.log("User Key set "+user.userKey);

            //logic for setting video
            user.videoURL = payload["videoURL"];
            api.getVideoInfo(user.userKey, payload["videoURL"], setVideo, socket);
            api.GetFriendsList(setFriends, user.userKey, user, socket);
        }
        else if(payload["type"]=="LIST") {
            const ids = await io.allSockets();
            console.log(ids);
        }
        else if(payload["type"]=="KILL") {
            if(io.sockets.sockets.has(payload["data"]))
                io.sockets.sockets.get(payload["data"]).disconnect(true);
            else
                socket.emit("error", "ID not found");
        }
        else if(payload["type"]=="QUIT") {
            console.log("Server going offline...");
            io.emit("QUIT", "Server going offline...")
            io.disconnectSockets(true);
        }
    })

    socket.on("syncVideo", async(msg) => {
        if(user.videoStamp!=msg["videostamp"]) {
            user.videoStamp = msg["videostamp"];
            user.curr_timestamp = Date.now();
            user.videoURL = msg["videoURL"];
        }
    });

    socket.on("sendComment", async(payload) => {
        api.PostComment(confirm, user.userKey, user.videoURL, payload["timestamp"], payload["videostamp"],
            payload["comment"], "Post comment");
        socket.emit("NewComment", payload);
    });
});

function ID(socket) {
    console.log(socket.id);
}

function sync(user) {
    //console.log("syncing...");
    if(user.curr_timestamp==user.last_timestamp) {
        console.log("Data already up to date, no sync");
    }
    else {
        user.last_timestamp = user.curr_timestamp;
        console.log("syncing new data...");
        api.SyncInfo(confirm, user.userKey, user.videoURL, user.videoStamp, Date.now());
    }

}

function confirm(promise, status) {
    //console.log(promise+" "+status["status"]);
    if(status["status"]=="error")
        console.log(status["explanation"]);
}

function setVideo(data, socket) {
    //console.log(data);
    if(data["status"]=="success") {
        socket.emit("videoSet", data["data"][0]["videostamp"]);
    }
    else
        socket.emit("videoSet", "0");
}

function setFriends(user, data, socket) {
    console.log(data);
    user.friends = data["data"];
    console.log(user.friends);
    for(let i =0; i<user.friends.length; i++) {
        api.GetFriendsComments(sendComments, user.userKey, user.videoURL, user.friends[i]["API_Key"], user.friends[i], socket);
    }
    api.GetFriendsComments(sendComments, user.userKey, user.videoURL, user.userKey, {name:"You", surname:""}, socket);
    socket.emit("FriendsSet", data);
}

function sendComments(data, names, socket) {
    let combine = [];
    //console.log(data);
    if(data["status"]=="error") {
        console.log(data["explanation"]);
        return;
    }
    data = data["data"];
    for(let i=0; i<data.length; i++) {
        combine.push({
            name : names["name"],
            surname : names["surname"],
            timestamp : data[i]["timestamp"],
            videostamp : data[i]["videostamp"],
            comment : data[i]["comment"]
        });
    }
    socket.emit("CommentSet", combine);
    //console.log(combine);
}