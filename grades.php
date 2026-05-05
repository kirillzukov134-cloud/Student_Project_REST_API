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

switch($method) {
    case 'GET':
        if ($type === 'grades') {
            if (!empty($id)) {
                
                getGradeById($pdo, $id);
            } else {
                $student_id = $_GET['student_id'] ?? null;
                if ($student_id) {
                    GradesStudent($pdo, $student_id);
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Не указан ID студента']);
                }
            }
        }
        break;
}
?>