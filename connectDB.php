<?php

try{
    $pdo = new PDO('mysql:host=localhost;dbname=Students_Projects', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4");
}catch(PDOException $error){
    die('Error: ' . $error->getMessage());
}

// $pdo = new PDO('mysql:host=sql111.infinityfree.com;dbname=if0_41720656_studentsroject', 'if0_41720656', 'Afp7zcBkxM8');