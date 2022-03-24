<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    include_once '../class/user.php';
    $database = new Database();
    $db = $database->getConnection();
    $item = new User($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->id = $data->id;
    $item->workshop = $data->workshop;
    $item->subscribed = date('Y-m-d H:i:s');
    
    if($item->createSubscription()){
        echo 'Subscribtion created successfully.';
    } else{
        echo 'Subscribtion could not be created.';
    }



?>