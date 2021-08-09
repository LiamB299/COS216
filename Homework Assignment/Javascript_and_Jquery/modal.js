$(document).ready(function () {
    if(sessionStorage.getItem("username")==null) {
        $("#sub-modal").text("Login to post rating");
        $("#sub-modal").prop("disabled", true);
    }
    else {
        $("#sub-modal").text("Submit Rating");
        $("#sub-modal").prop("disabled", false);
    }
});

$(".grid-item").on("click", modalTrend);

function modalTrend() {
    let elem = this.children[0].children;
    $("#modal-title").text(elem[0].textContent);
    $("#modal-img").attr("src", elem[2].src);
    $("#modal-m-rating").text(elem[1].textContent);
    $("#modal").css("display", "block");
}

$("#box-1, #box-2, #box-3").on("click", function () {
    setModalTopRated(this.id[4]);
    $("#modal").css("display", "block");
});

function setModalTopRated(elem) {
    $("#modal-title").text($("#title-"+elem).text());
    $("#modal-img").attr("src", $("#box-"+elem).attr("src"));
    $("#modal-m-rating").text($("#score-"+elem).text());
}

$(".close#close-modal").on("click", function () {
   $("#modal").css("display", "none");
});

window.onclick = function (event) {
    if(event.target == modal)
        $("#modal").css("display", "none");
};

$("#sliderange").on("input", function () {
    $("#slider-out").text(this.value);
});

$("#sub-modal").on("click", function () {
    submit_rating();
});

function submit_rating() {
    body = {
        "key" : sessionStorage.getItem("key"),
        "type" : "rating",
        "game_title" : $("#modal-title").text(),
        "user_rating" : $("#sliderange").val(),
        "artwork" : $("#modal-img").attr("src"),
        "metacritic" : parseInt($("#modal-m-rating").text())
    };
    console.log(body);
    GenericPost("api.php", body, error_check);
}
