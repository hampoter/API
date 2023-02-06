<?php 

include_once("config.php");
include_once("err_handler.php");
include_once("db_connect.php");
include_once("functions.php");
include_once("find_token.php");

if(!isset($_GET['type'])){
    echo ajax_echo(
        "Ошибка",
        "Не указан GET параметр type",
        "ERROR",
        null
    );
    exit;
}

//Регистрация нового пользователя 
if(preg_match_all("/^register_new_user$/ui", $_GET['type'])){
    if(!isset($_GET['email'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр email!",
            "ERROR",
            null
        );
        exit;
    }
     if(!isset($_GET['login'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр login",
            "ERROR",
            null
        );
        exit;
     }
    if(!isset($_GET['password'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр password",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['first_name'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр first_name",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['second_name'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр second_name",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['middle_name'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр middle_name",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['date_of_birth'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр date_of_birth",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['gender'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр gender",
            "ERROR",
            null
        );
        exit;
    }
    $query = "INSERT INTO `users` (`email` , `login` , `password` , `first_name` , `second_name` , `middle_name` , `date_of_birth` , `gender`) VALUES ('".$_GET['email']."' , '".$_GET['password']."' , '".$_GET['login']."' , '".$_GET['first_name']."' , '".$_GET['second_name']."' , '".$_GET['middle_name']."' , '".$_GET['date_of_birth']."' , '".$_GET['gender']."')";
    $res_query = mysqli_query($connection,$query);

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

    echo ajax_echo(
        "Успех", 
        "Создан новый пользователь",
        false,
        "SUCCESS"
    );
    exit();
}

//Добавление номера телефона пользователя
else if(preg_match_all("/^add_phone_number$/ui", $_GET['type'])){
    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметрuser_id",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['phone'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр phone",
            "ERROR",
            null
        );
        exit;
    }
    $query = "INSERT INTO `users_phones` (`user_id`, `phone`) VALUES (".$_GET['user_id'].", ".$_GET['phone'].")";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка",
            "Ошибка в запросе",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех",
        "Номер телефона был добавлен",
        false,
        "SUCCESS"
    );
    exit;
}

//Добавление нового товара
else if(preg_match_all("/^add_product$/ui", $_GET['type'])){
    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр name",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['price'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр price",
            "ERROR",
            null
        );
        exit;
    }
     if(!isset($_GET['desc'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр desc",
            "ERROR",
            null
        );
        exit;
    }
     if(!isset($_GET['weight'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр weight",
            "ERROR",
            null
        );
        exit;
    }
    $query = "INSERT INTO `product` (`name`, `price`, `desc`, `weight`) VALUES ('".$_GET['name']."', ".$_GET['price']." , '".$_GET['desc']."' , ".$_GET['weight'].")";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка",
            "Ошибка в запросе",
            true,
            null
        );
        exit($query);
    }
    
    echo ajax_echo(
        "Успех",
        "Новый товар был добавлен в базу данных",
        false,
        "SUCCESS"
    );
    exit;
}

//Вход пользователя в систему
if(preg_match_all("/^user_sign_in$/ui", $_GET['type'])){
    if(!isset($_GET['login'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр login",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['password'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр password",
            "ERROR",
            null
        );
        exit;
    }
    $query = "SELECT COUNT(id) > 0 AS `RESULT` FROM `users` WHERE `login`='".$_GET['login']."' AND `password`='".$_GET['password']."' ";
    $res_query = mysqli_query($connection,$query);

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
    if($res["RESULT"] == "0"){
        echo ajax_echo(
            "Ошибка", 
            "Такой пользователь не существует",
            true,
            "ERROR",
            null
        );
        exit();
    }

    echo ajax_echo(
        "Успех", 
        "Пользователь авторизирован",
        false,
        "SUCCESS"
    );
    exit();
}

//Вывод всех существующих товаров
if(preg_match_all("/^list_all_products$/ui", $_GET['type'])){
    $type = "";
    if(isset($_GET["name"])){
        $type = "AND `type` = ".$_GET["name"];
    }

    $query = "SELECT `id`,`name`,`desc`,`price`,`weight` FROM `product` WHERE `deleted`=false ".$type;
    $res_query = mysqli_query($connection,$query);

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

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех", 
        "Был выведен список всех существующих товаров",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}

//Вывести товары в корзине
else if(preg_match_all("/^list_orders$/ui", $_GET['type'])){
    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр user_id",
            "ERROR",
            null
        );
        exit;
    }
    $query = "SELECT `name`, `desc`, `price`, `weight` from `product` WHERE `id` IN (SELECT `product_id` FROM `orders` WHERE `user_id`=".$_GET['userid']." AND `deleted`=false)";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка",
            "Ошибка в запросе",
            true,
            null
        );
        exit;
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    
    echo ajax_echo(
        "Успех",
        "Товары были выведены",
        false,
        "SUCCESS",
        $arr_res
    );
    exit;
}

//Вывести отзывы к товару
else if(preg_match_all("/^product_comments$/ui", $_GET['type'])){
    if(!isset($_GET['product_id'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр product_id",
            "ERROR",
            null
        );
        exit;
    }
    $query = "SELECT `date_of_append` , `comment` FROM `comments` WHERE `deleted`=false AND `product_id`=".$_GET['product_id'];
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка",
            "Ошибка в запросе",
            true,
            null
        );
        exit;
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    
    echo ajax_echo(
        "Успех",
        "Список отзывов был выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit;
}

//Вывести избранные товары
else if(preg_match_all("/^list_user_favorites$/ui", $_GET['type'])){
    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр user_id",
            "ERROR",
            null
        );
        exit;
    }
    $query = "SELECT `product_id`, `date_of_adding_fav_item` FROM `favorites`, (SELECT `name` FROM `product` WHERE `favorites_id`=`product_id`) AS 'product' FROM `favorites` WHERE `deleted`=false AND `user_id`=".$_GET['userid'];
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка",
            "Ошибка в запросе",
            true,
            null
        );
        exit;
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    
    echo ajax_echo(
        "Успех",
        "Выведен список избранных товаров",
        false,
        "SUCCESS",
        $arr_res
    );
    exit;
}

//Удаление пользователя из системы
if(preg_match_all("/^delete_user$/ui", $_GET['type'])){
    if(!isset($_GET['user_id'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр user_id",
            "ERROR",
            null
        );
        exit;
    }
    $query = "UPDATE `users` SET `deleted`=true WHERE `id`=".$_GET['user_id'];
    $res_query = mysqli_query($connection,$query);

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

    echo ajax_echo(
        "Успех", 
        "Пользователь был удален",
        false,
        "SUCCESS"
    );
    exit();
}

//Изменение данных продукта
else if(preg_match_all("/^update_product$/ui", $_GET['type'])){
    if(!isset($_GET['product_id'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр product_id",
            "ERROR",
            null
        );
        exit;
    }

    $desc = 'null';
    if(isset($_GET['desc'])){
        $desc = "'".$_GET['desc']."'";
    }
    $price = '';
    if(isset($_GET['price'])){
        $price = "`price`=".$_GET['price'].",";
    }
    $product_weight = 'null';
    if(isset($_GET['weight'])){
        $product_weight = $_GET['weight'];
    }

    $query = "UPDATE `product` SET `desc`=".$desc.",".$price."`weight`=".$product_weight." WHERE `id`=".$_GET['product_id'];
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка",
            "Ошибка в запросе",
            true,
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех",
        "Данные продукта были изменены",
        false,
        "SUCCESS"
    );
    exit;
}

//Изменение отзыва о продукте
else if(preg_match_all("/^update_comments$/ui", $_GET['type'])){
    if(!isset($_GET['product_id'])){
        echo ajax_echo(
            "Ошибка",
            "Не указан GET параметр product_id",
            "ERROR",
            null
        );
        exit;
    }

    $comment = '';
    if(isset($_GET['comment'])){
        $comment = "`comment`".$_GET['comment']."'";
    }
    $date_of_append = 'null';
    if(isset($_GET['date_of_append'])){
        $date_of_append = "''".$_GET['date_of_append'].",";
    }

    $query = "UPDATE `comments` SET `date_of_append`=".$date_of_append.",`comment`=".$comment." WHERE `id`=".$_GET['product_id'];
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка",
            "Ошибка в запросе",
            true,
            "ERROR",
            null
        );
        exit;
    }
    
    echo ajax_echo(
        "Успех",
        "Отзыв о товаре был изменён",
        false,
        "SUCCESS"
    );
    exit;
}
