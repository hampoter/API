<?php

if(!isset($_GET)){
    echo ajax_echo(
        "Ошибка!", 
        "Вы не указали GET параметры", 
        true, 
        "ERROR", 
        null 
    );
    exit();
}

if(!isset($_GET['token'])){
    echo ajax_echo(
        "Ошибка!", 
        "Вы не указали GET параметр token",
        true, 
        "ERROR", 
        null 
    );
    exit();
}

define('TOKEN', $_GET['token']);

if(!preg_match_all("/^[A-z0-9_]{32}$/iu", TOKEN)){
    echo ajax_echo(
        "Ошибка!", 
        "Ваш токен не соответствует шаблону", 
        true, 
        "ERROR", 
        null 
    );
    exit();
}

$query = "SELECT COUNT(`id`) > 0 AS 'RESULT' FROM `tokens` WHERE `token` = '" . TOKEN . "' AND `ban` = FALSE";
$res_query = mysqli_query($connection, $query);

if(!$res_query){
    echo ajax_echo(
        "Ошибка!", 
        "Ошибка в запросе.", 
        true, 
        "ERROR", 
        null 
    );
    exit();
}

$res = mysqli_fetch_assoc($res_query);

if(!$res){
    echo ajax_echo(
        "Ошибка!", 
        "Ошибка в запросе.", 
        true, 
        "ERROR", 
        null 
    );
    exit();
}

if($res['RESULT'] == '0'){
    echo ajax_echo(
        "Ошибка!", 
        "Ваш токен не является действительным!", 
        true, 
        "ERROR", 
        null 
    );
    exit();
}
