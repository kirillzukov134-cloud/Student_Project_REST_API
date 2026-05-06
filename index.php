<?php
require './DataBase/connectDB.php';
require './Functions/functions.php';

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
    //Для view.all.students.html (Таблица)
    case 'students-table':
        selectFullStudentsTable($pdo);
    break;
    //СТУДЕНТЫ (основное)
    case 'students':
        switch($method){
            //Вывод несколько | одного студента
            case 'GET':
                if(!empty($id)){
                    ShowMoreDetails($pdo, $id);
                } else {
                    SelectAllStudents($pdo);
                }
                break;
            //Добавление студента
            case 'POST':
                AdditionStudent($pdo, $_POST);
                break;
            //Удаленеие студента
            case 'DELETE':
                if(!empty($id)){
                    DeleteStudent($pdo, $id);    
                }
                break;
            //Редактирование студента
            case 'PATCH':
                $data = json_decode(file_get_contents('php://input'), true);
                EditStudent($pdo, $id, $data);
                break;
        }
    break;

    //ОЦЕНКИ
    case 'grades':
        switch($method){
            //Вывести оценку
            case 'GET':
                if(!empty($_GET['student_id'])){
                    GradesStudent($pdo, $_GET['student_id']);
                }
                break;
            //Добавление оценки
            case 'POST':
                AdditionGrade($pdo, $_POST);
                break;
            //Удаление оценки
            case 'DELETE':
                if(!empty($id)){
                    DeleteGrade($pdo, $id);                
                }
                break;
            //Редактирование оценок
            case 'PATCH':
                $data = json_decode(file_get_contents('php://input'), true);
                EditGrade($pdo, $id, $data);
                break; // Добавлен пропущенный break
        }
    break; // Добавлен пропущенный break

    //ПРЕДМЕТЫ
    case 'subjects':
        switch($method){
            //Вывод несколько | один предмет
            case 'GET':
                if(!empty($id)){
                    getSubjectById($pdo, $id);
                }else {
                    getAllSubjects($pdo);
                }
                break;
            //Добавление предмета
            case 'POST':
                AdditionSubjects($pdo, $_POST);
                break;
            //Редактирование предмета
            case 'PATCH':
                $data = json_decode(file_get_contents('php://input'), true);
                EditSubject($pdo, $id, $data);
                break;
            //Удаление предмета
            case 'DELETE':
                if(!empty($id)){
                    DeleteSubject($pdo, $id);
                }
                break;
        }
    break;
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