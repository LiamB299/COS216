<?php

    function cURL_start() {
        return curl_init();
    }

    function cURL_GET_options($handle, $url) {
        //echo $url;
        $error = null;
        if(curl_setopt($handle, CURLOPT_RETURNTRANSFER, true)===false) {
            echo "curl transfer error";
            $error = curl_error($handle);
            return $error;
        }
        
        if(curl_setopt($handle, CURLOPT_URL, $url)===false) {
            echo "curl url error ";
            $error = curl_error($handle);
            return $error;
        }

        $cert = "..".DIRECTORY_SEPARATOR."SSL Certificate".DIRECTORY_SEPARATOR."curl-ca-bundle.crt";
        if(curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, $cert)===false || curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, $cert)===false) {
            echo "certificate failure";
            $error = curl_error($handle);
            return $error;
        }

        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json"
            ));
        return $error;
    }

    function cURL_execute($handle) {
        $data = curl_exec($handle);
        //var_dump($data);
        if($data===false)
            return false;
        cURL_closeHandle($handle);
        return $data;
    }

    function cURL_closeHandle($handle) {
        curl_close($handle);
    }

    function cURL_do($url) {
        $handle = cURL_start();
        $data["error"] = cURL_GET_options($handle, $url);
        if($data["error"]!=null) {
            cURL_closeHandle($handle);
            return $error;
        }
        $data["data"] = cURL_execute($handle);

        if($data["data"]==false) {
            $data["error"]= curl_getinfo($handle);
            $data["code"] = curl_errno($handle);
            cURL_closeHandle($handle);
        }
        return $data;

    }