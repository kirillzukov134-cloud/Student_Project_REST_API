<?php
require './connectDB.php';
require './functions.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");


$method = $_SERVER['REQUEST_METHOD'];

$q = $_GET['q'];
$params = explode('/', $q);
$type = $params[0];
$id = $params[1];

switch($method){
    case 'GET':
    if($type === 'students'){
        if(!empty($id)){
        ShowMoreDetails($pdo, $id);
    }else {
        SelectAllStudents($pdo);
    }
}else {
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'Endpoint not found'
    ]);
}
break;
    case 'POST':
    if($type === 'students'){
        AdditionStudent($pdo, $_POST);
    }
break;
    case 'DELETE':
        if($type === 'students'){
            if(!empty($id)){
            DeleteStudent($pdo, $id);
            }
        }
}

?>