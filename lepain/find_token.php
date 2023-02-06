<?php

include_once("db_connect.php");

if(!isset($_GET)){
    echo ajax_echo(
        "Ошибка", 
        "GET параметр отсутствует",
        true,
        "ERROR",
        null

    );
    exit();
}

if(!isset($_GET['token'])){
    echo ajax_echo(
        "Ошибка", 
        "Отсутствует GET параметр token",
        true,
        "ERROR",
        null

    );
    exit();
}





define("TOKEN", $_GET['token']);

if(preg_match_all("/^[A-z0-9_]{32}/ui", TOKEN)){
    echo ajax_echo(
        "Ошибка", 
        "Токен не соответствует параметрам",
        true,
        "ERROR",
        null

    );
    exit();
}

$query = "SELECT COUNT(`id`) > 0 AS `RESULT` FROM `API_clients` WHERE `token` = \"".TOKEN."\"";
$res_query = mysqli_query($connection, $query);

if(!$res_query){
    echo ajax_echo(
        "Ошибка", 
        "Ошибка в запросе",
        true,
        "ERROR",
        null

    );
    exit();
}

$res = mysqli_fetch_assoc($res_query);

if($res['RESULT'] == '0'){
    echo ajax_echo(
        "Ошибка", 
        "Токен не действителен",
        true,
        "ERROR",
        null

    );
    exit();
}