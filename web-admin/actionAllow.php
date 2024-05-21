<?php
include_once "api/db/db.php";
error_reporting(0);
$_id = $_GET['t_id'];
$un_id = $_GET['un_id'];

if($_SERVER["REQUEST_METHOD"] == "POST" && $_GET['t_id']){
    $status = 1;
    $sql = "UPDATE `travel_location` SET `status_allow` = ?  WHERE `_id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $_id]);
    if ($stmt->rowCount() > 0) {
     echo "<script>alert('อัปโหลดไฟล์ เรียบร้อยแล้ว !');</script>";
     echo "<script>window.location.href='/web-admin/';</script>";
     // echo json_encode(["message" => "Travel location updated successfully"]);
   }  else {
    http_response_code(500); // Internal Server Error
   }
} 
if($_SERVER["REQUEST_METHOD"] == "POST" && $_GET['un_id']){
    $status = 0;
    $sql = "UPDATE `travel_location` SET `status_allow` = ?  WHERE `_id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $un_id]);
    if ($stmt->rowCount() > 0) {
     echo "<script>alert('อัปโหลดไฟล์ เรียบร้อยแล้ว !');</script>";
     echo "<script>window.location.href='/web-admin/';</script>";
     // echo json_encode(["message" => "Travel location updated successfully"]);
    }
    else {
       http_response_code(500); // Internal Server Error
    }
} else {
    http_response_code(500); // Internal Server Error
}
