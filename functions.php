<?php
function SelectAllStudents($pdo){
    $sql = 'SELECT * FROM students';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $data =  $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Student not found"]);
    }
}
// //Функция для полного списка всех студентов в Table.php
// function selectFullStudents($pdo){
//     $sql = "SELECT 
//         students.id,
//         groups.name AS group_name,
//         students.Name_student AS first_name,
//         students.Surname_student AS last_name
//     FROM students
//     JOIN groups ON students.group_id = groups.id";
// $statement = $pdo->query($sql); 
// $results = $statement->fetchAll(PDO::FETCH_ASSOC);
// echo json_encode($results);
// }

function selectIDCard($pdo, $id){
    $sql = "SELECT * FROM students WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute(['id' => $id]);
$data = $statement->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Student not found"]);
    }
}

//Добавление студентов в add.view.student.php
function AdditionStudent($pdo, $data){
    $sql =  
    "INSERT INTO `students`(`Name_student`, `Surname_student`, `phone`, `email`, `group_id`, `birth_date`) 
    VALUES (:Name_student, :Surname_student, :phone, :email, :group_id, :birth_date)";
    $statement = $pdo->prepare($sql);
    $statement->execute($data);
        if($statement){
            http_response_code(200);
                $response = [
                    "status" => true,
                    "message" => "Успешное добавление студента",
                    "id" => $pdo->lastInsertId()
                ];
            echo json_encode($response);
        }else {
            http_response_code(404);
            $response =  [
                'status' => false,
                'message' => 'Произошла ошибка при добавлении' 
            ];
        }
}

// Добавить оценку
function AdditionGrade($pdo, $data) {
    $sql = "INSERT INTO `grades` (`grade`, `student_id`, `subject_id`) 
            VALUES (:grade, :student_id, :subject_id)";
    $statement = $pdo->prepare($sql);
    $statement->execute($data);
        if($statement){
            http_response_code(200);
            $response = [
                'status' => true,
                'message' => 'Успешное добавление оценки',
                'id' => $pdo->lastInsertId()
            ];
            echo json_encode($response);
        }else {
            http_response_code(404);
            $response = [
                'status' => false,
                'message' => 'Ошибка при добавлении оценки'
            ];
        }
}
// Функциия для подробной информации о студенте
function ShowMoreDetails($pdo, $id){
    $sql = "SELECT 
        students.id,
        groups.name AS group_name, 
        students.Name_student AS first_name, 
        students.Surname_student AS last_name, 
        students.phone AS phone, 
        students.email AS email, 
        students.birth_date AS birth_date 
    FROM students
    JOIN groups ON students.group_id = groups.id 
    WHERE students.id = :id";
    
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);
    $data =  $statement->fetchAll(PDO::FETCH_ASSOC);
    
    if ($data) {
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Student not found"]);
    }
}

// //Функция которая добавляет предмет
// function AdditionSubjects($pdo, $data){
//     $data = [
//         "Name_Subjects"=> $_POST["Name_Subjects"],
//     ];
    
//     $sql = "INSERT INTO `subjects`(`Name_subjects`) VALUES (:Name_Subjects)";
//     $statement = $pdo->prepare($sql);
//     return $statement->execute($data);
// }






//Функция для получения всех оценок студента по всем предметам
function GradesStudent($pdo, $student_id) {
    $sql = "SELECT 
                grades.id as grade_id,
                grades.grade AS Оценка,
                subjects.Name_subjects AS Предмет
            FROM grades
            JOIN subjects ON grades.subject_id = subjects.id
            WHERE grades.student_id = :student_id
            ORDER BY subjects.Name_subjects";
    $statement = $pdo->prepare($sql);
    $statement->execute([':student_id' => $student_id]); 
    $grades = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($grades) {
        echo json_encode($grades);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Оценки не найдены']);
    }
}

// Получить оценку по ID
function getGradeById($pdo, $id) {
    $sql = "SELECT * FROM grades WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $id]);
    $grade = $statement->fetch(PDO::FETCH_ASSOC);
    if ($grade) {
        echo json_encode($grade);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Запись не найдена']);
    }
}

//Функция для получения данных одного студента в edit.details.php
function getStudentById($pdo, $id){
    $sql = "SELECT * FROM students WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if($result){
        echo json_encode($result);
    }else {
        http_response_code(404);
        echo json_encode(['Студент не найден']);
    }
}

// //Функция для обновления данных существующего студента
// function EditStudent($pdo, $data){
//     $sql = "UPDATE `students` SET 
//         `Name_student` = :Name_student,
//         `Surname_student` = :Surname_student,
//         `phone` = :phone,
//         `email` = :email,
//         `group_id` = :group_id,
//         `birth_date` = :birth_date
//     WHERE `id` = :id";
    
//     $statement = $pdo->prepare($sql);
//     return $statement->execute($data);
// }

//Удаление студента в view.details.student.php

function DeleteStudent($pdo, $id){
    $sql = "DELETE FROM students WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);
    if($statement->rowCount() > 0){
        http_response_code(200);
        echo json_encode([
            'status' => true,
            'message' => 'Успешное удаление'
        ]);
    }else{
        http_response_code(404);
        echo json_encode([
            'status' => false,
            'message' => 'Ошибка при удалении'
        ]);
    }
}

// function DeleteSubject($pdo, $id){
//     $sql = "DELETE FROM `subjects` WHERE id = :id";
//     $statement = $pdo->prepare($sql);
//     return $statement->execute(['id' => $id]);    
// }

function DeleteGrade($pdo, $id){
    $sql = "DELETE FROM `grades` WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);
if($statement->rowCount() > 0){
        http_response_code(200);
        echo json_encode([
            'status' => true,
            'message' => 'Успешное удаление'
        ]);
    }else{
        http_response_code(404);
        echo json_encode([
            'status' => false,
            'message' => 'Ошибка при удалении'
        ]);
    }  
}


// //Функция которая выводит все предметы
// function getAllSubjects($pdo){
//     $sql = 'SELECT id, Name_subjects FROM subjects';
//     $statement = $pdo->prepare($sql);
//     $statement->execute();
//     return $statement->fetchAll(PDO::FETCH_ASSOC);
// }

// // Получить предмет по ID
// function getSubjectById($pdo, $id) {
//     $sql = "SELECT * FROM subjects WHERE id = :id";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute([':id' => $id]);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }

// // Обновить предмет
// function EditSubject($pdo, $data) {
//     $sql = "UPDATE subjects SET Name_subjects = :Name_Subjects WHERE id = :id";
//     $statement = $pdo->prepare($sql);
//     return $statement->execute([
//         ':Name_Subjects' => $data['Name_Subjects'],
//         ':id' => $data['id']
//     ]);
// }

// // Получить всех студентов с группами
// function getAllStudents($pdo) {
//     $sql = "SELECT 
//                 students.*,
//                 groups.name AS group_name
//             FROM students
//             JOIN groups ON students.group_id = groups.id
//             ORDER BY students.Surname_student";
    
//     $statement = $pdo->prepare($sql);
//     $statement->execute();
//     return $statement->fetchAll(PDO::FETCH_ASSOC);
// }

// // Добавить оценку
// function AddGrade($pdo, $data) {
//     $sql = "INSERT INTO `grades` (`grade`, `student_id`, `subject_id`) 
//             VALUES (:grade, :student_id, :subject_id)";
    
//     $statement = $pdo->prepare($sql);
//     return $statement->execute([
//         ':grade' => $data['grade'],
//         ':student_id' => $data['student_id'],
//         ':subject_id' => $data['subject_id']
//     ]);
// }


// // Обновить оценку
// function EditGrade($pdo, $data) {
//     $sql = "UPDATE `grades` SET 
//                 `grade` = :grade,
//                 `student_id` = :student_id,
//                 `subject_id` = :subject_id
//             WHERE `id` = :id";
    
//     $statement = $pdo->prepare($sql);
//     return $statement->execute([
//         ':grade' => $data['grade'],
//         ':student_id' => $data['student_id'],
//         ':subject_id' => $data['subject_id'],
//         ':id' => $data['id']
//     ]);
// }

// //Функция для расписания занятиц (где, какой учитель и т.д., также использую COUCAT <- для объеденения)
// function ShowSchedule($pdo){
//     $sql = 
//     "SELECT
//     groups.name AS Группа,
//     subjects.Name_subjects AS Предмет,
//     schedule.day_of_week AS День_недели,
//     CONCAT(teachers.Surname_teacher, ' ', teachers.Name_teacher) AS Учитель, 
//     schedule.lesson AS Номер_пары,
//     schedule.Cabinet AS Кабинет
// FROM schedule
// JOIN subjects ON schedule.subject_id = subjects.id
// JOIN groups ON schedule.group_id = groups.id
// LEFT JOIN teachers ON schedule.teacher_id = teachers.id";

// $statement = $pdo->prepare($sql);
// $statement->execute();
// return $statement->fetchAll(PDO::FETCH_ASSOC);
// }