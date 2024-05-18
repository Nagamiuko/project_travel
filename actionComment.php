<?php
include_once "database/db.php";
session_start();
$userId = $_SESSION['_id'];
$id = $_GET['id'];
$dataTravel = [] ;
$url = URL_API.'travel-api?t_id='.$id;
$response = file_get_contents($url);
if ($response !== false) {
    $data = json_decode($response, true);
    if ($data !== null) {
        $dataTravel = $data ;
    } else {
        echo "Failed to decode JSON response.";
    }
} else {
    echo "Failed to fetch API data.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $comment = $_POST['comment_travel'];
    if(!empty($comment)){
        $sql = "INSERT INTO `comment_travel` (comment_text, t_id, u_id) 
               VALUES (:comment, $id , $userId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':comment', $comment);
        $stmt->execute();
        echo "<script>window.location.href='detail-travel?id=".$id."';</script>";
        // echo "<script>window.location.reload(true);</script>";
    }else{
        echo "<script>alert('Comment Not Success!');</script>";
    }

}