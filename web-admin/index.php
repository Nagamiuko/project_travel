<?php 
    session_start();
    require "api/db/db.php";
    $user_id = $_SESSION['_id'];
    $sql = "SELECT * FROM user_travel WHERE _id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $avatar_set = $user['image_avatar'];

    $url_host = "http://".$_SERVER['HTTP_HOST'];

 if(!isset($user['admin_check']) || $user['admin_check'] == 'User') {
    echo "<script>window.location.href='/';</script>";
} else{ require "web.php" ; require "head.php" ;} ?>