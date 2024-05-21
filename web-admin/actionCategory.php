<?php

include_once "api/db/db.php";
session_start();
$user_id = $_SESSION['_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nameCategory = $_POST['name'];
    $sql = "INSERT INTO `travel_category`(`category_name`) 
    VALUES (:name)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $nameCategory);
    $stmt->execute();

    echo "<script>window.location.href='/web-admin/';</script>";
}