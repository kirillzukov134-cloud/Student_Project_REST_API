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

switch($type){
    case 'students':
        switch($method){
            case 'GET':
            if(!empty($id)){
                ShowMoreDetails($pdo, $id);
            }else {
                SelectAllStudents($pdo);
            }
            break;
        }
        switch($method){
            case 'POST':
                AdditionStudent($pdo, $_POST);
            break;
        }
        switch($method){
            case 'DELETE':
            if(!empty($id)){
                DeleteStudent($pdo, $id);    
            }
        }
break;
    case 'grades':
        switch($method){
            case 'GET':
            if(!empty($id)){
                getGradeById($pdo, $id);
            }
            elseif(!empty($_GET['student_id'])){
                GradesStudent($pdo, $_GET['student_id']);
            }
        break;
        }
        switch($method){
            case 'POST':
            AdditionGrade($pdo, $_POST);
            break;
        }
        switch($method){
            case 'DELETE':
            if(!empty($id)){
                DeleteGrade($pdo, $id);                
            }
            break;
        }
}
// switch($method){
//     case 'GET':
//     if($type === 'students'){
//         if(!empty($id)){
//         ShowMoreDetails($pdo, $id);
//     }else {
//         SelectAllStudents($pdo);
//     }
// }elseif {
//     http_response_code(404);
//     echo json_encode([
//         'status' => 'error',
//         'message' => 'Endpoint not found'
//     ]);
// }
// break;
//     case 'POST':
//     if($type === 'students'){
//         AdditionStudent($pdo, $_POST);
//     }
// break;
//     case 'DELETE':
//         if($type === 'students'){
//             if(!empty($id)){
//             DeleteStudent($pdo, $id);
//             }
//         }
// }


// switch($method) {
//     case 'GET':
//         if ($type === 'grades') {
//             if (!empty($id)) {
//                 getGradeById($pdo, $id);
//             } else {
//                 if (!empty($student_id)) {
//                     $student_id = $_GET['student_id'];
//                     GradesStudent($pdo, $student_id);
//                 } else {
//                     http_response_code(404);
//                     echo json_encode([
//                         'status' => false,
//                         'message' => 'Ошибка при выполнении запроса'
//                         ]);
//                 }
//             }
//         }
//     break;
// }