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

    // ตรวจสอบว่ามีการระบุรหัสผ่านใหม่หรือไม่
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        // อัพเดตรหัสผ่านใหม่ในฐานข้อมูล
        $sql = "UPDATE user_travel SET name = :name, username = :username , password = :password, address = :address , sex = :sex , tel = :tel WHERE _id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name, 'username' => $username, 'password' => $password , 'address' => $address ,'sex' => $sex , 'tel' => $tel ,'id' => $user_id]);
    } else {
        // ใช้รหัสผ่านเดิม
        $sql = "SELECT password FROM user_travel WHERE _id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $user_id]);
        $old_password = $stmt->fetchColumn();

        // อัพเดตข้อมูลในฐานข้อมูลโดยใช้รหัสผ่านเดิม
        $sql = "UPDATE user_travel SET name = :name, username = :username , password = :password, address = :address , sex = :sex , tel = :tel WHERE _id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name, 'username' => $username, 'password' => $old_password , 'address' => $address ,'sex' => $sex , 'tel' => $tel ,'id' => $user_id]);
    }

    // ส่งกลับไปยังหน้าโปรไฟล์หลังจากการแก้ไข
    header('Location: index.php');
    exit;
}
