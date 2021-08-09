const axios = require("axios");
const qs = require("qs");

function parameterize(data) {
    return qs.stringify(data);
}

//const url = 'http://localhost/Homework_Assignment/api.php';
const url = "https://u18015001:L19m2992tuks@wheatley.cs.up.ac.za/u18015001/api.php";
//url removed for clickup

function decrypt_url(key) {

}

module.exports = {
    getVideoInfo: function(Key, VideoID, callback, arg1)
    {
    axios.post(url, parameterize({
        key: Key,
        type: "track",
        which: "get",
        videoID: VideoID
    }))
        .then((response) => {
            callback(response.data, arg1);
        }, (error) => {
            console.log(error);
        });
    },

    SyncInfo: function(callback, Key, videoURL, videostamp, timestamp) {
        axios.post(url, parameterize({
            key: Key,
            type: "track",
            which : "insert",
            videoID : videoURL,
            video_stamp : videostamp,
            time_stamp : timestamp
        }))
            .then((response) => {
                console.log(response.data);
                callback("Synchronize: ", response.data);
            }, (error) => {
                console.log(error);
            });
    },

    GetFriendsList: function(callback, Key, user, socket) {
        axios.post(url, parameterize({
            key: Key,
            type: "friends",
            use : "get",
            get : "friends"
        }))
            .then((response) => {
                callback(user, response.data, socket);
            }, (error) => {
                console.log(error);
            });
    },

    GetFriendsComments: function(callback, Key, videoID, friendKey, names, socket) {
        axios.post(url, parameterize({
            key: Key,
            type: "friends",
            use : "comments",
            get : "get",
            videoID : videoID,
            user2 : friendKey
        }))
            .then((response) => {
                callback(response.data, names, socket);
            }, (error) => {
                console.log(error);
            });
    },

    PostComment: function(callback, Key, videoID, timestamp, videostamp, comment, promise) {
        axios.post(url, parameterize({
            key: Key,
            type: "friends",
            use : "comments",
            get : "send",
            videoID : videoID,
            timestamp : timestamp,
            videostamp : videostamp,
            comment : comment,
            user2 : ""
        }))
            .then((response) => {
                callback(promise, response.data);
            }, (error) => {
                console.log(error);
            });
    }
}