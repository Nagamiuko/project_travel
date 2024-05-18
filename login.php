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
    if ($user['admin_check']== 'User') {
        session_start();
        $_SESSION['_id'] = $user['_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['admin_check'] = $user['admin_check'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['avatar'] = $user['image_avatar'];
        // echo "<script>alert('Login Successful!');</script>";
    }else if($user['admin_check'] == 'Admin'){
        session_start();
        $_SESSION['_id'] = $user['_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['admin_check'] = $user['admin_check'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['avatar'] = $user['image_avatar'];

        // echo "<script>alert('Login Successful!');</script>";
        // echo "<script>window.location.href='/web-admin/'</script>";
    } else {
        echo "<script>alert('Something went wrong! Please try again.');</script>";
        echo "<script>window.location.href='/'</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
</body>
</html>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php
        if($_SESSION['admin_check'] == 'Admin') {
            // session_start();
            echo "Swal.fire({
                title: 'เข้าสู่ระบบสำเร็จ',
                text: 'สวัสดีคุณ Admin : {$_SESSION['username']}',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/web-admin/';
                }
            });";
            // Clear the session message after use
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }else{
            // session_start();
            echo "Swal.fire({
                title: 'เข้าสู่ระบบสำเร็จ',
                text: 'สวัสดีคุณ : {$_SESSION['username']}',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/';
                }
            });";
            // Clear the session message after use
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
     </script>