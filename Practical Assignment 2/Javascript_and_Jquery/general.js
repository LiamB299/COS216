//methods are async due to the synchronous option being deprecated
//the overlay for loading is removed after all data has been loading by 
//being a sort of "final" call back 


//HTTP request to RAWG.io for game data
export function getGames() {
    //XMLHTTP object
    var req = new XMLHttpRequest();
    //API request
    req.open("GET", "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607", true);
    //Sends request
    req.send();
    //pass in callback function and call that on ready or return JSON on completion if Async
    return JSON.parse(req.responseText);
}

export function GenericRequest(callback, url) {
    //XMLHTTP object
    var req = new XMLHttpRequest();
    //API request, true for async operation
    req.open("GET", url, true);
    //Sends request
    req.send();
    //check status
    req.onreadystatechange = function() {
        //success
        if(this.readyState == 4 && this.status == 200)
            callback(this);
        else if( this.status == 403 || this.status == 403)
            //throw exception
            return "";
    }       
}
