<?php
session_start();
require 'database/db.php';
// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
// if (!isset($_SESSION['_id'])) {
//     header('Location: index.php');
//     exit;
// }

$user_id = $_SESSION['_id'];
echo $user_id;
//ตรวจสอบว่ามีการส่งค่า post มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าที่ถูกส่งมาจากฟอร์มแก้ไขโปรไฟล์
    $username = $_POST['username'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $sex =  $_POST['sex']; // รวมข้อมูลจาก checkbox เป็น string
    $tel = $_POST['tel'];
    $avatar = $_FILES['images'];
    $avatarFileName = null;
    $targetFilePath = null;
    if ($avatar && $avatar['error'] == 0) {
        $targetDir = "uploads/avatar/";
        $avatarFileName = basename($avatar['name']);
        $targetFilePath = $targetDir . $avatarFileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'png', 'jpeg', 'gif' ,'webp'];
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($avatar['tmp_name'], $targetFilePath)) {
                // อัพโหลดไฟล์สำเร็จ
            } else {
                echo "<script>alert('Upload failed.');</script>";
                exit;
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }
    }
    // ตรวจสอบว่ามีการระบุรหัสผ่านใหม่หรือไม่
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
    } else {
        // ใช้รหัสผ่านเดิม
        $sql = "SELECT password FROM user_travel WHERE _id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $user_id]);
        $password = $stmt->fetchColumn();
    }

    // อัพเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE user_travel SET fullname = :name, username = :username, password = :password, address = :address, sex = :sex, tel = :tel";
    if ($avatarFileName) {
        $sql .= ", image_avatar = :image_avatar";
    }
    $sql .= " WHERE _id = :id";
    
    $stmt = $conn->prepare($sql);
    $params = [
        'name' => $name,
        'username' => $username,
        'password' => $password,
        'address' => $address,
        'sex' => $sex,
        'tel' => $tel,
        'id' => $user_id
    ];
    if ($avatarFileName) {
        $params['image_avatar'] = $targetFilePath;
    }
    $stmt->execute($params);

    // echo "<script>alert('Upload failed.');</script>";
    session_reset();
    echo "<script>window.location.href='/';</script>";
    exit;
}
