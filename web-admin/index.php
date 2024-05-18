<?php 
 session_start();
 if(!isset($_SESSION['admin_check']) || $_SESSION['admin_check'] == 'User') {
    echo "<script>window.location.href='/';</script>";
} else{ require "web.php" ; require "head.php" ;} ?>