<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/class/workshop.php';

    $database = new Database();
    $db = $database->getConnection();
    $items = new Workshop($db);
    $stmt = $items->getWorkshops();
    $itemCount = $stmt->rowCount();

    echo json_encode($itemCount);
    if($itemCount > 0){
        
        $workshopArr = array();
        $workshopArr["body"] = array();
        $workshopArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "owner" => $owner,
                "created" => $created
            );
            array_push($workshopArr["body"], $e);
        }
        echo json_encode($workshopArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>