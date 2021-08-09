$( "div#2" ).css( "width", "300px" ).add( "p" ).css( "background-color", "blue" );

function log(info) {
    console.log(info);
} 

$("#test-but").on("click",function () {

    let old = {
        "key" : "0000000000",
        "type" : "info",
        //"score" : "83,87",
        //"date" : "2001-01-01,2006-01-01",
        //"tags" : "exploration",
        "limit" : "5",
        "title" : "fallout 3",
        //"genre" : "role-playing-games-rpg",
        //"platforms" : "playstation-2,playstation-1",
        //"order" : "-metacritic",
        "return" : ["title", "release", "genres", "platforms", "metacritic", "tags", "site", "age-rating"]
    };

    let jason = { //calendar
        "key" : "0000000000",
        "type" : "info",
        "date" : "2021-05-01,2021-06-01",
        "limit" : "5",
        "return" : ["title", "release","site"]
    };

    let top_rated = {
        "key" : "0000000000",
        "type" : "info",
        "date" : "2001-01-01,2010-01-01",
        "limit" : "10",
        "order" : "-metacritic",
        "return" : ["title", "developers", "artwork", "metacritic", "platforms"]
    };

    let featured = {
        "key" : "0000000000",
        "type" : "info",
        "limit" : "1",
        "title" : "fallout 3",
        "return" : ["title", "release", "genres", "platforms", "description", "video", "developers", "artwork"]
    };

    let new_release = {
        "key" : "0000000000",
        "date" : "2003-01-01,2007-01-01",
        "type" : "info",
        "limit" : "5",
        "return" : ["title", "release", "genres", "platforms", "description",
            "age-rating", "site", "developers", "artwork", "metacritic"]
    };

    let trending = {
        "key" : "0000000000",
        "type" : "info",
        "limit" : "15",
        //"score" : "81,90",
        "platforms" : "playstation-2,playstation-1",
        //"genre" : "role-playing-games-rpg",
        "return" : ["title", "release", "genres", "platforms",
            "age-rating", "developers", "artwork", "metacritic"]
    };

    let general_search = {
        "key" : "0000000000",
        "type" : "info",
        "limit" : "12",
        "title" : "Mass effect 2",
        "return" : ["title", "release", "genres", "platforms",
            "age-rating", "developers", "artwork", "metacritic"]
    };
    
    //log($.param(jason));
    GenericPost("api.php", jason, log);

    //findSmallest();
    
});

function test(data) {
    $("#reply").text(JSON.stringify(data));
    log(data);
}



