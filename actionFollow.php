<?php
include_once "database/db.php";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $travelid = $_POST['travelid'];
    $userid = $_POST['userid'];

    // Check if the user is already following this travel
    $check_sql = "SELECT COUNT(*) as count FROM `user_follow` WHERE user_id = :userid AND t_id = :travelid";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':userid', $userid);
    $check_stmt->bindParam(':travelid', $travelid);
    $check_stmt->execute();
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

    // If the user is not already following, then insert into the database
    if ($result['count'] == 0) {
        $sql = "INSERT INTO `user_follow` (user_id, t_id) VALUES (:userid, :travelid)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':travelid', $travelid);
        $stmt->execute();
        
        // Redirect to the detail-travel page only if the user followed successfully
    } else {
        // If the user is already following, display a message
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        // echo "<script>window.location.href='detail-travel?id=" . $travelid . "';</script>";
    }
} else {
    echo "<script>alert('Upload failed.');</script>";
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
        if ($result['count'] == 0) {
            echo "Swal.fire({
                title: '',
                text: 'ติดตามแล้ว',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href='detail-travel?id=" . $travelid . "';
                }
            });";
        }else{
            echo "Swal.fire({
                title: '',
                text: 'คุณได้ติดตามการเดินทางครั้งนี้แล้ว',
                icon: 'failed',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href='detail-travel?id=" . $travelid . "';
                }
            });";
        }
        ?>
     </script>