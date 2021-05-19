function log(info) {
    console.log(info);
} 

$("input").click(function (e) { 
    e.preventDefault();
    
    jason = {
        "key" : "c6641200a5", 
        "type" : "info", 
        //"score" : "83,87",
        //"date" : "2001-01-01,2006-01-01",
        //"tags" : "exploration",
        "limit" : "3",
        "title" : "fallout 3",
        //"genre" : "role-playing-games-rpg",
        //"platforms" : "playstation-2,playstation-1",
        //"order" : "-metacritic",
        "return" : ["title", "release", "genres", "platforms", "metacritic", "tags", "site", "age-rating"]
    };
    
    //log($.param(jason));
    GenericPost("api.php", jason, test);

    //findSmallest();
    
});

function test(data) {
    $("#reply").text(JSON.stringify(data));
    log(data);
}



