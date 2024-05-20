<?php
include_once "api/db/db.php";
$_id = $_GET['t_id'];

if($_SERVER["REQUEST_METHOD"] == "POST" ){
    $status = 1;
    $sql = "UPDATE `travel_location` SET `status_allow` = ?  WHERE `_id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $_id]);
    if ($stmt->rowCount() > 0) {
     echo "<script>alert('อัปโหลดไฟล์ เรียบร้อยแล้ว !');</script>";
     echo "<script>window.location.href='/web-admin/';</script>";
     // echo json_encode(["message" => "Travel location updated successfully"]);
 } else {
     http_response_code(500); // Internal Server Error
 }
 }