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
   //     );
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
            if(KeyExists($_POST["key"])==false)
                response(
                ["status" => "error",
                "explanation" => "API Key invalid",
                "timestamp" => time()]
            );
            else
                get_data();
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
            $info = cURL_do(URL_GAME_giantbomb($info["results"][0]["id"]));
            if($info["error"]!=null || $info["data"]==false) {
            response([
                "status" => "error",
                "explanation" => $info["error"],
                "timestamp" => time()]
                );
                return null;
            }
            else
                return json_decode($info["data"], true);
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
                $limit = 1;
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
        return $GLOBALS["db"]->validate_Key($key);
    }

    /*******************************/



?>