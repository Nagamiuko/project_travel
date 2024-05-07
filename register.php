<?php
require "database/db.php" ;
// เชื่อมต่อฐานข้อมูล หรือใช้ฟังก์ชันสำหรับการบันทึกข้อมูลที่ต้องการ
// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าข้อมูลจากฟอร์ม
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = md5($_POST['password']);
    $address = $_POST['address'];
    $sex = $_POST['sex']; // รวมข้อมูลจาก checkbox เป็น string
    $tel = $_POST['tel'];
    $adminCheck = isset($_POST['admin_check']) ? $_POST['admin_check'] : 'User'; // ตรวจสอบว่าถูกเลือกหรือไม่
    
    $sql = "INSERT INTO `user_travel`( `username`, `name`, `password`, `address`, `sex`, `tel`, `admin_check`) VALUES ('".$username."','".$name."','".$password."','".$address."','".$sex."','".$tel."','".$adminCheck."')" ;
    $message = "" ;
    if($conn->query($sql) === TRUE){
      echo "<script>window.location.href='index.php'</script>";
      $message = "";
        exit();
    } else {
        echo "<script>window.location.href='index.php'</script>";
        exit();
    }
    $conn->close(); 
}
?>