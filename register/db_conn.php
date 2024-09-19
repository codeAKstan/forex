<?php 

$sName = "localhost";
$uName = "codeak";
$pass = "5334";
$db_name = "user_registration";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}


// CREATE DATABASE user_registration;

// USE user_registration;

// CREATE TABLE users (
//     id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(100) NOT NULL,
//     username VARCHAR(100) NOT NULL UNIQUE,
//     password VARCHAR(255) NOT NULL,
//     email VARCHAR(150) NOT NULL UNIQUE,
//     country VARCHAR(100) NOT NULL,
//     phone_number VARCHAR(20) NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// );
