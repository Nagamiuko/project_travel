<?php
include_once "api/db/db.php";
session_start();
$user_id = $_SESSION['_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['images'])) {

    $nameTravel = $_POST['name'];
    $typeTravel = $_POST['typeTravel'];
    $locationTravel = $_POST['location'];
    $detailsTravel = $_POST['details'];
    $previnces = $_POST['previnces'];
    $regions = $_POST['regions'];
    
    // รับข้อมูลไฟล์ภาพ
    $images = $_FILES['images'];

    // อัปโหลดไฟล์ภาพไปยัง folder ที่กำหนด

    $upload_dir = 'uploads/';
    $imageData = [];

    foreach ($images['tmp_name'] as $key => $tmp_name) {

        $file_name = $images['name'][$key];
        $target_path = $upload_dir . $file_name;

        move_uploaded_file($tmp_name, $target_path);
        $imageData[] = [
            'file_name' => $file_name,
            'file_path' => $target_path
        ];
    }
    $jsonData = json_encode($imageData,true);
    $sql = "INSERT INTO `travel_location` (travel_name, category,previnces,regions, location_travel , details_travel,image_travel,u_id) 
            VALUES (:name, :category, :previnces, :regions, :location, :details, :images, $user_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $nameTravel);
    $stmt->bindParam(':category', $typeTravel);
    $stmt->bindParam(':location', $locationTravel);
    $stmt->bindParam(':previnces', $previnces);
    $stmt->bindParam(':regions', $regions);
    $stmt->bindParam(':details', $detailsTravel);
    $stmt->bindParam(':images', $jsonData);
    $stmt->execute();

    echo "<script>window.location.href='/web-admin/';</script>";
} else {
    echo "<script>alert('Upload failed.');</script>";
}
?>

