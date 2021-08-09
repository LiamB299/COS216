<?php
    
    require("PHP files" . DIRECTORY_SEPARATOR . "config.php");
    require("PHP files" . DIRECTORY_SEPARATOR . "curl.php");

    //require("COS216" . DIRECTORY_SEPARATOR . "Assignment_3" . DIRECTORY_SEPARATOR . "PHP files" . DIRECTORY_SEPARATOR . "config.php");
    //require("COS216" . DIRECTORY_SEPARATOR . "Assignment_3" . DIRECTORY_SEPARATOR . "PHP files" . DIRECTORY_SEPARATOR . "curl.php");



    header("Content-Type: application/json; charset=UTF-8");
	

    /********************************/
    //function response($data, $code="200") {
    //    header("HTTP/1.1 200 OK");
    //    header("Content-Type: application/json");
    //    echo json_encode (
    //        $data
    //    );
    //}

    /*******************************/	

    if(!(isset($_POST["key"]) && isset($_POST["type"]))) {
        response(
            ["status" => "error",
            "explanation" => "Please check key and type parameters are completed",
            "timestamp" => time()]
        );
    }
    else {
        if(isset($_POST["key"])) {
            //var_dump($GLOBALS["db"]->NumberUsers());
            if(!KeyExists($_POST["key"]) && $_POST["key"]!="0000000000") {
                response(
                    ["status" => "error",
                        "explanation" => "API Key invalid",
                        "timestamp" => time()]
                );
                return;
            }
            else if($_POST["type"]=="track" && $_POST["key"]!="0000000000") {
                if(isset($_POST["which"])) {
                    if($_POST["which"]=="get") {
                        if(validate_track_get()) {
                            get_track();
                            return;
                        }
                        else return;
                    }
					else if($_POST["which"]=="insert") {
                        if(validate_track_ins()) {
                            ins_track();
                            return;
                        }
						//if track already found just update it
                        else if(validate_track_upt()) {
                            upt_track();
                            return;
                        }
						else 
							return;
                    }
                    else if($_POST["which"]=="update") {
                        
                    }
                    else {
                        error_response("which not recognised");
                        return;
                    }
                }
                else {
                    error_response("which not set");
                    return;
                }
            }
            else if($_POST["type"]=="info") {
                if(isset($_POST["user_ratings"])) {
                    UserRatings();
                    return;
                }
                else {
                    get_data();
                    return;
                }
                return;
            }
            else if($_POST["type"]=="login") {
                login();
                return;
            }
            else if($_POST["type"]=="friends") {
                if (validate_friends()) {
                    friends();
                    return;
                }
            }
            else if($_POST["key"]=="0000000000" && ($_POST["type"]!="info" || $_POST["type"]!="login" || $_POST["type"]!="friends")) {
                error_response("Info key is used for a non info, login, friend request");
                return;
            }
            else if($_POST["type"]=="update") {
                if(validate_update()) {
                    update();
                    return;
                }
                else
                    error_response("unfound error");
                    return;
            }
            else if($_POST["type"]=="rating") {
                if (validate_rating()) {
                    rating();
                    return;
                }
            }
        }
    }

    /******************************/

    function validate_track_ins() {
        if(!isset($_POST["videoID"])) {
            error_response("Track Video ID not set");
            return false;
        }
        $data = $GLOBALS["db"]->getValuesCustom("SELECT * FROM tracker where `key` =\"".
            $_POST["key"]."\" && videoID = \"".$_POST["videoID"]."\"");
        if(count($data)==1) {
            //error_response("Track record already found");
            return false;
        }
        if(!isset($_POST["video_stamp"])) {
            error_response("Track Video stamp not set");
            return false;
        }
        if(is_int($_POST["video_stamp"])) {
            error_response("Track Video stamp not a number");
            return false;
        }
        if(!isset($_POST["time_stamp"])) {
            error_response("Track Time stamp not set");
            return false;
        }
        if(is_int($_POST["time_stamp"])) {
            error_response("Track Time stamp not a number");
            return false;
        }
        return true;
    }

    function ins_track() {
        $data = [
            $_POST["videoID"],
            $_POST["key"],
            $_POST["time_stamp"],
            $_POST["video_stamp"]
        ];
        if($GLOBALS["db"]->insert_record("tracker", $data, "sssi")) {
            response([
                "status" => "success",
                "timestamp" => time()
            ]);
        }
        else {
            error_response("Track insert failed");
        }
    }

    function validate_track_upt() {
        if(!isset($_POST["videoID"])) {
            error_response("Track Video ID not set");
            return false;
        }
        $data = $GLOBALS["db"]->getValuesCustom("SELECT * FROM tracker where `key` =\"".
        $_POST["key"]."\" && videoID = \"".$_POST["videoID"]."\"");
        if(count($data)!=1) {
            error_response("VideoID not found");
            return false;
        }
        if(!isset($_POST["video_stamp"])) {
            error_response("Track Video stamp not set");
            return false;
        }
        if(!isset($_POST["time_stamp"])) {
            error_response("Track time_stamp not set");
            return false;
        }
        return true;
    }

    function upt_track() {
        $data = $GLOBALS["db"]->getValuesCustom("UPDATE tracker SET videostamp = \"".$_POST["video_stamp"].
            "\", timestamp = \"".$_POST["time_stamp"]."\" where `key` =\"".$_POST["key"]."\" && videoID = \"".$_POST["videoID"]."\"");
        if($data==true) {
            response([
                "status" => "success",
                "timestamp" => time()
            ]);
            return true;
        }
        else {
            error_response("Track video to update not found");
            return false;
        }
    }

    function validate_track_get() {
        if(isset($_POST["videoID"])) {
            return true;
        }
        else {
            error_response("Track Video ID not set");
            return false;
        }
    }

    function get_track() {
        $data = $GLOBALS["db"]->getValuesCustom("SELECT * FROM tracker where `key` =\"".
            $_POST["key"]."\" && videoID = \"".$_POST["videoID"]."\"");
        if(count($data)==1) {
            response([
                "status" => "success",
                "data" => $data,
                "timestamp" => time()
            ]);
            return true;
        }
        else {
            error_response("Track video get not found");
            return false;
        }
    }

    /******************************/

    function validate_friends() {
        if(!isset($_POST["use"])) {
            error_response("Use for friends type not set");
            return false;
        }
        if(!isset($_POST["get"])) {
            error_response("Get friends type not set");
            return false;
        }
        if($_POST["use"]=="submit") {
            if($_POST["get"]!="confirm" && $_POST["get"]!="add" && $_POST["get"]!="cancel" && $_POST["get"]!="unfriend") {
                error_response("Insert friends get not recognised");
                return false;
            }
            if(!isset($_POST["user2"])) {
                error_response("Second user not set");
                return false;
            }
            return true;
        }
        else if($_POST["use"]=="get"){
            if($_POST["get"]!="pending" && $_POST["get"]!="not" && $_POST["get"]!="friends" && $_POST["get"]!="confirm") {
                error_response("Get friends type not recognized");
                return false;
            }
        }
        else if($_POST["use"]=="comments") {
            if(!isset($_POST["user2"])) {
                error_response("Second user not set");
                return false;
            }
            if($_POST["get"]!="get" && $_POST["get"]!="send") {
                error_response("Get comments type not recognized");
                return false;
            }
            if(!isset($_POST["videoID"])) {
                error_response("videoID not set");
                return false;
            }
            if($_POST["get"]=="send") {
                if(!isset($_POST["timestamp"])) {
                    error_response("comments timestamp not set");
                    return false;
                }
                if(is_int(isset($_POST["timestamp"]))) {
                    error_response("timestamp for comment not int");
                    return false;
                }
                if(!isset($_POST["videostamp"])) {
                    error_response("comments videostamp not set");
                    return false;
                }
                if(is_int(isset($_POST["videostamp"]))) {
                    error_response("videostamp for comment not int");
                    return false;
                }
                if(strlen($_POST["comment"])>200) {
                    error_response("comment too large to store");
                    return false;
                }
            }
            return true;
        }
        return true;
    }

    function friends() {
        if($_POST["use"]=="submit") {
            if($_POST["get"]=="confirm") {
                if($GLOBALS["db"]->getValuesCustom("update friends set accepted=1 where user1 = \"".$_POST["user2"]."\" && user2 = \"".$_POST["key"]."\"")) {
                    response([
                        "status" => "success"
                    ]);
                }
                else {
                    error_response("Update record failure");
                    return;
                }
            }
            else if($_POST["get"]=="unfriend") {
                $sql = "delete from friends where (user1 = \"".$_POST["key"]."\" && user2 = \"".$_POST["user2"]."\") || (user1 = \"".$_POST["user2"]."\" && user2 = \"".$_POST["key"]."\")";
                response($sql);
                if($GLOBALS["db"]->getValuesCustom($sql)) {
                    response([
                        "status" => "success"
                    ]);
                }
                else {
                    error_response("Update record failure");
                    return;
                }
            }
            else if($_POST["get"]=="cancel") {
                if($GLOBALS["db"]->getValuesCustom("delete from friends where user2 = \"".$_POST["user2"]."\" && user1 = \"".$_POST["key"]."\"")) {
                    response([
                        "status" => "success"
                    ]);
                }
                else {
                    error_response("Update record failure");
                    return;
                }
            }
            else if($_POST["get"]=="add") {
                $data = [
                    $_POST["key"],
                    $_POST["user2"],
                    0
                ];
                if($GLOBALS["db"]->insert_record("friends", $data, "ssi")) {
                    response([
                        "status" => "success"
                    ]);
                }
                else {
                    error_response("Update record failure");
                    return;
                }
            }
        }
        else if($_POST["use"]=="get") {
            if($_POST["get"]=="pending") {
                if($data = $GLOBALS["db"]->getValuesCustom("select name, surname, API_Key from users where API_Key in (
	select user2 from friends where user1 = \"".$_POST["key"]."\" && accepted = 0
    ) && API_Key != \"".$_POST["key"]."\"")) {
                    response([
                        "status" => "success",
                        "data" => $data,
                        "timestamp" => time()
                    ]);
                }
                else {
                    error_response("Get pending friends error");
                }
            }
            else if($_POST["get"]=="friends") {
                if($data = $GLOBALS["db"]->getValuesCustom("select name, surname, API_Key from users where API_Key in (
	select user1 from friends where (user2 = \"".$_POST["key"]."\") && accepted = 1
    union
    select user2 from friends where (user1 = \"".$_POST["key"]."\") && accepted = 1
) && API_Key != \"".$_POST["key"]."\"")) {
                    response([
                        "status" => "success",
                        "data" => $data,
                        "timestamp" => time()
                    ]);
                }
                else {
                    error_response("Get friends error");
                }
            }
            else if($_POST["get"]=="not") {
                if($data = $GLOBALS["db"]->getValuesCustom("select `name`, surname, API_Key from users where API_Key not in
(select user2 from friends where user1 = \"".$_POST["key"]."\"
union
select user1 from friends where user2 = \"".$_POST["key"]."\") && API_Key != \"".$_POST["key"]."\" && API_Key != \"0000000000\"")) {
                    response([
                        "status" => "success",
                        "data" => $data,
                        "timestamp" => time()
                    ]);
                }
                else {
                    error_response("Get not friends error");
                }
            }
            else if($_POST["get"]=="confirm") {
                if($data = $GLOBALS["db"]->getValuesCustom("select name, surname, API_Key from users where API_Key in (
	select user1 from friends where user2 = \"".$_POST["key"]."\" && accepted = 0
    ) && API_Key != \"".$_POST["key"]."\"")) {
                    response([
                        "status" => "success",
                        "data" => $data,
                        "timestamp" => time()
                    ]);
                }
                else {
                    error_response("Get confirm friends error");
                }
            }
        }
        else if($_POST["use"]=="comments") {
            if($_POST["get"]=="get") {
                if($data = $GLOBALS["db"]->getValuesCustom("SELECT `key`, `timestamp`, videostamp, `comment` 
                    from comments where videoID = \"".$_POST["videoID"]."\" && `key` = \"".$_POST["user2"]."\"")) {
                    response([
                        "status" => "success",
                        "data" => $data,
                        "timestamp" => time()
                    ]);
                }
                else {
                    error_response("No comments for friend");
                }
            }
            else if($_POST["get"]=="send") {
                $data = [
                    $_POST["key"],
					$_POST["videoID"],
                    $_POST["timestamp"],
                    $_POST["videostamp"],
                    $_POST["comment"],
                ];
                if(!$GLOBALS["db"]->insert_record("comments", $data, "sssis"))
                    error_response("Insert comment failed");
            }
        }
    }

    /******************************/

    function UserRatings() {
        $data = $GLOBALS["db"]->getValuesCustom("select gametitle, rating, artwork, metacritic, avg(rating) as score, count(gametitle) as".
            " votes from user_ratings group by gametitle order by avg(rating) desc");
        return response([
            "status" => "success",
            "data" => $data
        ]);
    }

    /******************************/
    function validate_update() {
        if(isset($_POST["set"])==false) {
            error_response("Set not set");
            return false;
        }
        if(isset($_POST["values"])==false) {
            error_response("Values not set");
            return false;
        }
        if($_POST["set"]=="theme") {
            //var_dump($_POST["values"]);
            if($_POST["values"]!="d" && $_POST["values"]!="n") {
                error_response("value for theme not recognised");
                return false;
            }
            return true;
        }
        else if($_POST["set"]=="filters") {
            if(count($_POST["values"])!=3) {
                error_response("Not enough values received to update filters");
                return false;
            }
            return true;
        }
        else {
            error_response("Set not recognised for update");
            return false;
        }
    }

    function update() {
        if($_POST["set"]=="theme") {
            //echo $_POST["set"];
            if($GLOBALS["db"]->update_record("preferences", "theme", $_POST["values"], "`key`", "\"".$_POST["key"]."\"", "s")) {
                response([
                    "status" => "success"
                ]);
                return;
            }
        }
        else if($_POST["set"]=="filters") {
            if(!$GLOBALS["db"]->update_record("preferences", "genre", $_POST["values"][0], "`key`", "\"".$_POST["key"]."\"", "s")) {
                error_response("insert failed");
                return;
            }
            if(!$GLOBALS["db"]->update_record("preferences", "platform", $_POST["values"][1], "`key`", "\"".$_POST["key"]."\"", "s")) {
                error_response("insert failed");
                return;
            }
            if(!$GLOBALS["db"]->update_record("preferences", "score", $_POST["values"][2], "`key`", "\"".$_POST["key"]."\"", "s")) {
                error_response("insert failed");
                return;
            }
            response([
                "status" => "success"
            ]);
        }
    }



    /******************************/

    function login() {
        $data = $GLOBALS["db"]->getValues("users", "email", $_POST["email"], "s", "name, API_Key");
        $data2 = $GLOBALS["db"]->getValues("preferences", "key", $data[0]["API_Key"], "s", "theme, genre, platform, score");
        //var_dump($data2);
		if(!isset($data2[0]["theme"])) {
			error_response("No pref");
			return;
		}
        response([
            "name" => $data[0]["name"],
            "Key" => $data[0]["API_Key"],
            "theme" => $data2[0]["theme"],
            "genre" => $data2[0]["genre"],
            "platform" => $data2[0]["platform"],
            "score" => $data2[0]["score"],
                "timestamp" => time()
        ]);
    }

    /******************************/

    function validate_rating() {
        if(isset($_POST["metacritic"])==false) {
            error_response("Metacritic not set");
            return false;
        }
        if(isset($_POST["artwork"])==false) {
            error_response("Artwork not set");
            return false;
        }
        if(isset($_POST["user_rating"])==false) {
            error_response("User rating not set");
            return false;
        }
        if(isset($_POST["game_title"])==false) {
            error_response("Game title not set");
            return false;
        }
        if(is_numeric($_POST["metacritic"])==false) {
            error_response("metacritic not a number");
            return false;
        }
        if(is_numeric($_POST["user_rating"])==false) {
            error_response("User rating not a number");
            return false;
        }
        return true;
    }

    function rating() {
        //do an update
        if(count($GLOBALS["db"]->getValuesCustom("Select * from user_ratings where gametitle = \"".$_POST["game_title"]."\" && `key` = \"".$_POST["key"]."\""))) {
            if($GLOBALS["db"]->getValuesCustom("Update user_ratings set rating =".$_POST["user_rating"]." where gametitle = \"".$_POST["game_title"]."\" && `key` = \"".$_POST["key"]."\"")) {
                response([
                    "status" => "success",
                "timestamp" => time()
                ]);
                return;
            }
            else {
                //error_response("Update User rating failed");
                return;
            }
        }
        else {
            $data = [
                $_POST["key"],
                $_POST["game_title"],
                $_POST["user_rating"],
                $_POST["artwork"],
                $_POST["metacritic"],
                "timestamp" => time()
            ];
            if($GLOBALS["db"]->insert_record("user_ratings", $data, "ssisi")) {
                response([
                    "status" => "success"
                ]);
                return;
            }
            else {
                error_response("user ratings insert failed");
                return;
            }
        }
    }

    /******************************/

    function get_data() {
        $url = URL_rawg(URL_parameterize(build_filters_RAWG()));
        $data = cURL_do($url);
        if($data["error"]!=null || $data["data"]==false)
            response(
                ["status" => "error",
                "explanation" => $data["error"],
                "timestamp" => time()]
            );
        else if(json_decode($data["data"], true)["count"]===0) {
            response(
                ["status" => "Empty",
                "explanation" => "No data avilable for given query",
                "timestamp" => time()]
            );
        }
        else
            build_return(json_decode($data["data"], true));
    }

    function get_ArtDev($title) {
        $info = cURL_do(URL_ID_giantbomb($title));
        if($info["error"]!=null || $info["data"]==false) {
            response(
                ["status" => "error",
                "explanation" => $info["error"],
                "timestamp" => time()]
            );
            return null;
        }
        else
            $info = json_decode($info["data"], true);
            try {
                $info = cURL_do(URL_GAME_giantbomb($info["results"][0]["id"]));
            }
            catch(Exception $e) {
                var_dump($info);
            }
            finally {
                if ($info["error"] != null || $info["data"] == false) {
                    response([
                            "status" => "error",
                            "explanation" => $info["error"],
                            "timestamp" => time()]
                    );
                    return null;
                } else
                    return json_decode($info["data"], true);
            }
    }

    /*******************************/

    function build_return($data) {
        $games = array();
        if($data==null) {
            response([
                "status" => "error",
                "explanation" => $data["error"],
                "timestamp" => time()]
                );
                return;
        }
           
        $data = $data["results"];

        if(isset($_POST["title"]))
            if($_POST["title"]=="*")
                $limit = count($data);
            else
                $limit = $_POST["limit"];
        else if(isset($_POST["limit"])) {
            if($_POST["limit"] >20 && $_POST["limit"]<=count($data))
                $limit = 20;
            else if($_POST["limit"]<count($data))
                $limit = $_POST["limit"];
            else
                $limit = count($data);
        }
        else
            $limit = count($data);

        for($i=0; $i<$limit; $i++) {
            $game = $data[$i];
            //var_dump($limit);
            $build = array();

            if(contains("title"))
                $build["title"] = $game["name"];
            if(contains("artwork") || contains("developers") || contains("site") || contains("description")) {
                $hold = get_ArtDev($game["name"]);
                if($hold==null)
                    return;
                else {
                    if(contains("artwork")) 
                        $build["artwork"] = $hold["results"]["image"]["original_url"]; 
                    if(contains("developers"))
                        $build["developers"] = build_items($hold["results"]["developers"], "developers"); 
                    if(contains("site")) 
                        $build["site"] = $hold["results"]["site_detail_url"];
                    if(contains("description")) 
                        $build["description"] = $hold["results"]["deck"];
                }
            }
            if(contains("release"))
                $build["release date"] = $game["released"];
            if(contains("genres") && isset($game["genres"]))
                $build["genres"] = build_items($game["genres"], "genres");
            if(contains("tags"))
                $build["tags"] = build_items($game["tags"], "tags");
            if(contains("platforms"))
                $build["platforms"] = build_items($game["platforms"], "platforms");
            if(contains("metacritic"))
                $build["metacritic"] = $game["metacritic"];
            if(contains("rating"))
                $build["user_rating"] = $game["rating"];
            if(contains("age-rating") && isset($game["esrb_rating"]))
                $build["ESRB_rating"] = $game["esrb_rating"]["name"];
            if(contains("video"))
                $build["video"] = Youtube_Embed($game["name"]);

            array_push($games, $build);
        }

        $ret["status"] = "success";
        $ret["timestamp"] = time();
        $ret["data"] = $games;

        response($ret);
    }

    function contains($find) {
        //var_dump();
		if(isset($_POST["return"])==false)
			return true;
        foreach((array)$_POST["return"] as $ret) {
            if($ret === "*")
                return true;
            else if($ret === $find)
                return true;
        }
        return false;
    }

    function build_items($data, $type) {
        $item=[];
        if($type=="platforms") {
            for($i=0; $i<count($data); $i++) {
                if($data[$i]["platform"]["name"]=="PC" && isset($data[$i]["requirements_en"]))
                    array_push($item, (["PC"  =>  $data[$i]["requirements_en"]]));
                else
                    array_push($item, $data[$i]["platform"]["name"]);
            }
        }
        else if($type=="genres") {
            for($i=0; $i<count($data); $i++) {
                array_push($item, $data[$i]["name"]);
            }
        }
        else if($type=="tags") {
            for($i=0; $i<count($data); $i++) {
                if($data[$i]["language"]=="eng") {
                    array_push($item, $data[$i]["name"]);
                }
            }
        }
        else if($type=="developers") {
            for($i=0; $i<count($data); $i++) {
                array_push($item, $data[$i]["name"]);
            }
        }
        return $item;
    }

    function build_filters_RAWG() {
        $rawg = [];
        if($_POST["type"]=="info") {
            if(isset($_POST["title"])) {
                if($_POST["title"]!="*") {
                    $data = "search=".urlencode($_POST["title"]);
                    array_push($rawg, $data);
                }
            }
            if(isset($_POST["date"])) {
                $data = "dates=".$_POST["date"];
                array_push($rawg,$data);
            }
            if(isset($_POST["genre"])) {
                $data = "genres=".$_POST["genre"];
                array_push($rawg,$data);
            }
            if(isset($_POST["tags"])) {
                $data = "tags=".urlencode($_POST["tags"]);
                array_push($rawg,$data);
            }
            if(isset($_POST["platforms"])) {
                $data = "platforms=".platforms_codes($_POST["platforms"]);
                array_push($rawg,$data);
            }
            if(isset($_POST["score"])) {
                $data = "metacritic=".$_POST["score"];
                array_push($rawg,$data);
            }
            if(isset($_POST["developers"])) {
                $data = "developers=".$_POST["developers"];
                array_push($rawg,$data);
            }
            if(isset($_POST["order"])) {
                $data = "ordering=".$_POST["order"];
                array_push($rawg,$data);
            }

        }
        return $rawg;
    }

    function platforms_codes($platforms) {
        $data = explode(",",$platforms);
        $codes = "";
        foreach($data as $platform) {
            if($platform=="playstation-4") {
                $codes .= "18,";
            }
            else if($platform=="playstation-3") {
                $codes .= "16,";
            }
            else if($platform=="playstation-5") {
                $codes .= "187,";
            }
            else if($platform=="playstation-1") {
                $codes .= "27,";
            }
            else if($platform=="playstation-2") {
                $codes .= "15,";
            }
            else if($platform=="playstation-vita") {
                $codes .= "19,";
            }
            else if($platform=="xbox-one") {
                $codes .= "1,";
            }
            else if($platform=="xbox-sx") {
                $codes .= "186,";
            }
            else if($platform=="xbox-360") {
                $codes .= "14,";
            }
            else if($platform=="pc") {
                $codes .= "4,";
            }
            else if($platform=="xbox") {
                $codes .= "80,";
            }
            else if($platform=="macos") {
                $codes .= "5,";
            }
            else if($platform=="nintendo-switch") {
                $codes .= "7,";
            }
            else if($platform=="wii") {
                $codes .= "11,";
            }
            else if($platform=="wii-u") {
                $codes .= "10,";
            }
        }
        return substr($codes, 0, strlen($codes)-1);
    }

    /******************************/
    function URL_parameterize($filters) {
        //var_dump($filters);
        if(count($filters)==0)
            return "";

        $sline="&";
        for($i=0; $i<count($filters)-1; $i++) {
            $sline .= $filters[$i];
            $sline .= "&";
        }
        $sline .= $filters[count($filters)-1];
        return $sline;
    }

    function Youtube_Embed($title) {
        //var_dump(URL_youtube($title));
        $info = curl_do(URL_youtube($title));
        //var_dump($info);
        if($info["error"]!=null || $info["data"]==false) {
            response(
                ["status" => "error",
                "explanation" => $info["error"],
                "timestamp" => time()]
            );
            return null;
        }
        $info = json_decode($info["data"],true);
        //var_dump($info);
        if(count($info["items"])==0) {
            response(
                ["status" => "error",
                "explanation" => "excess video requests",
                "timestamp" => time()]
            );
            return null;
        }
        else {
            //$info = $info["data"];
            //$info = json_decode($info, true);
            return "https://www.youtube.com/embed/".$info["items"][0]["id"]["videoId"];
        }
    }

    function URL_youtube($title) {
        $title = urlencode($title." trailer");
        //var_dump($url);
        return "https://www.googleapis.com/youtube/v3/search?part=snippet&key=AIzaSyAbzTdkuIQ6csXlb0hLJVheNYFzLtcpQMc&type=video&videoDefinition=high&maxResults=1&q=".$title;
    }

    function URL_rawg($filters) {
        //$filters = urlencode($filters);
        return "https://api.rawg.io/api/games?key=7465f1c4b11d465898232c5155c4d607".$filters;
    }

    function URL_ID_giantbomb($title) {
        return "https://www.giantbomb.com/api/search/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json&resources=game&field_list=id&limit=1&query=\"".urlencode($title)."\"";
    }

    function URL_GAME_giantbomb($id) {
        return "https://www.giantbomb.com/api/game/".$id."/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json&field_list=deck,developers,image,site_detail_url";
    }
    //20504
    //"https://www.giantbomb.com/api/game/20504/?api_key=c41bc81a54bdc2285d0111f115ec51735ddc7a82&format=json&field_list=deck,developers,image"
    /*******************************/

    function KeyExists($key) {
        return $GLOBALS["db"]->is_duplicate_entry("users", "API_Key", $key);
    }

    /*******************************/



?>