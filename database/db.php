<?php
require "env-config.php";
try {
    $conn = new PDO("mysql:host=" . DATABASE_HOSTNAME . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //  echo "<script>alert('Connection successfully');</script>";
} catch(PDOException $e) { 
    // echo "<script>alert('Connection failed:". $e->getMessage()."');</script>";
}?>


