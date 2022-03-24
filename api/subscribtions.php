<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/class/user.php';

    $database = new Database();
    $db = $database->getConnection();
    $items = new User($db);

    $data = json_decode(file_get_contents("php://input"));
    $items->id = $data->id;

    $stmt = $items->getSubscriptions();
    $itemCount = $stmt->rowCount();

    echo json_encode($itemCount);
    if($itemCount > 0){
        
        $userArr = array();
        $userArr["body"] = array();
        $userArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "workshop" => $workshop,
                "subscribed" => $subscribed,
            );
            array_push($userArr["body"], $e);
        }
        echo json_encode($userArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>