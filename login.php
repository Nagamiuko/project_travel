<?php
// เชื่อมต่อกับฐานข้อมูล หรือเรียกใช้ API ต่าง ๆ เพื่อตรวจสอบข้อมูลการเข้าสู่ระบบ
require "database/db.php";
if (isset($_POST['login'])) {
    $uname = $_POST['username'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user_travel WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $uname);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        session_start();
        $_SESSION['_id'] = $user['_id'];
        $_SESSION['username'] = $user['name'];
        echo "<script>alert('Login Successful!');</script>";
        echo "<script>window.location.href='/'</script>";
    } else {
        echo "<script>alert('Something went wrong! Please try again.');</script>";
        echo "<script>window.location.href='index.php'</script>";
    }
}

?>
