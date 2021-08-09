<?php

require("PHP files/database.php");

$data = [
    "1234",
    "title",
    100,
    "art",
    89
];

//var_dump(Database::instance()->insert_record("user_ratings", $data, "ssisi"));
$data = [
    95,"title","1234"
];
//var_dump(Database::instance()->getValuesCustom("Update user_ratings set rating =".$data[0]." where gametitle = \"".$data[1]."\" && `key` = \"".$data[2]."\""));
$data = "984de907ee";
var_dump(Database::instance()->getValuesCustom("select * from friends where (user1 = \"".$data."\" || user2 = \"".$data."\") && accepted = 1"));