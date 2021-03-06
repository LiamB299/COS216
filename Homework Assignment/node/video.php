<?php

    require("../PHP files/header.php");
    require("../PHP files/footer.php");

    build_page();

function build_page() {
    echo "
    <!DOCTYPE html>
<html lang=\"en\">";

    gen_Navbar("video");

        echo"
<head>
    <meta charset=\"UTF-8\">
    <title>Socket</title>
    <div id=\"video-title\">
        Videos
    </div>
</head>
<body>
<label for=\"inText1\">Type</label>
<input type=\"text\" id=\"inText1\"><br>
<label for=\"inText2\">Data</label>
<input type=\"text\" id=\"inText2\">
<button id=\"subBut\">Sub</button>
<div id=\"video-box\">
    <video src=\"game_video.mp4\" controls id=\"video\" autoplay muted></video>
</div>
<div id=\"post-comment-block\">
    <div id=\"comment-textbox\">
        <input type=\"text\" id=\"comments-input\">
    </div>
    <div id=\"post-button\">Post Comment</div>
</div><br><br>
<div style=\"margin: auto; font-size: xx-large; color: antiquewhite\">Chat</div>
<div style=\"margin: auto\" id=\"comments\" >
    <div class=\"grid-container-comments\" id=\"comments-title\">
        <a class=\"grid-item-posted\">Time Posted</a>
        <a class=\"grid-item-timestamp\">Video Stamp</a>
        <div style=\"margin: auto\" class=\"grid-item-comment-text\">Comments</div>
    </div>
</div>
</body>";

    footer();

        echo"
<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong\">
<link rel=\"stylesheet\" href=\"video_page.css\">
<link rel=\"stylesheet\" href=\"../style_sheets/my_styles.css\">
<link rel=\"stylesheet\" href=\"toastr/CodeSeven-toastr-50092cc/toastr.scss\">
<script src=\"toastr/CodeSeven-toastr-50092cc/toastr.js\"></script>
<script src=\"node_modules/socket.io/client-dist/socket.io.js\"></script>
<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"
        integrity=\"sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=\" crossorigin=\"anonymous\"></script>
<script src=\"../Javascript_and_Jquery/general.js\"></script>
<script src=\"client.js\"></script>
</html>
    ";
}