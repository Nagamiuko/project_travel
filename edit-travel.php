<?php 
include_once "database/db.php";
$dataTravel = [] ;
$id = $_GET['id'];
$url = "http://localhost:8888/api/travel-api.php?id=".$id."";
$response = file_get_contents($url);

    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data !== null) {
            $dataTravel = $data ;
        } else {
            print_r("Failed to decode JSON response.");
        }
    } else {
        echo "Failed to fetch API data.";
    }
// $_id = $dataTravel['_id'];
// $image = $dataTravel['image_travel'];

$jsonDataCategory = file_get_contents('category.json');
$category = json_decode($jsonDataCategory, true);

$alertSuccessfully = '<script>alert("อัปโหลดไฟล์ เรียบร้อยแล้ว !")</script>';
$alertError = '<script>alert("มีข้อผิดพลาดในการอัปโหลดไฟล์ !")</script>';


// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $nameTravel = $_POST['name'];
//     $typeTravel = $_POST['typeTravel'];
//     $location = $_POST['location'];
//     $details = $_POST['details'];
//     $image_pathOly = $image;
    
//     // print_r($image_pathOly);
//     // ตรวจสอบว่ามีไฟล์ภาพถูกอัปโหลดหรือไม่
//     if(!empty($_FILES['images']['name'])) {
//         $file_name = $_FILES['images']['name'];
//         $file_tmp = $_FILES['images']['tmp_name'];
    
//         // อัปโหลดไฟล์ภาพ
//         $upload_dir = 'uploads/';
//         move_uploaded_file($file_tmp, $upload_dir . $file_name);
    
//         $image_path = $upload_dir . $file_name;
//     } else {
//         // ใช้รูปภาพเดิม
//         $image_path = $image_pathOly;
//     }
    
//     // อัปเดตข้อมูลในฐานข้อมูล
//     $sql = "UPDATE `travel_location` SET 
//             `travel_name`='$nameTravel', 
//             `details_travel`='$details', 
//             `location_travel`='$location', 
//             `category`='$typeTravel', 
//             `image_travel`='$image_path' 
//             WHERE `_id`='$_id'";
    
//     if ($conn->query($sql) === TRUE) {
//         echo $alertSuccessfully;
//         echo "<script>window.location.reload(true);</script>";
//         exit();
//     } else {
//         echo $alertSuccessfully; 
//         echo "<script>window.location.href='edit-travel.php?id=".$_id."';</script>";
//         exit();
//     }
    
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="assets/js/popup-login.js"> </script>
    <link href="assets/css/login.css" rel="stylesheet">
    <title>Edit Travel</title>
</head>
<body>
    <header>
        <?php include "head.php"; ?>
    </header>
    <div id="editTravelPopup" class="edittravelup menu-pop-edittravelup">
    <div class="edit-travel-frame">
        <button onclick="linkPath('myproduct.php')" class="btn-close"></button>
        <h1>Edit Travels</h1>
        <form id="updateForm" enctype="multipart/form-data"  method="POST" >
            <label for="name">Name Travel:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $dataTravel['travel_name']?>" required><br>
            <label for="typeTravel">Category Travel:</label><br>
            <select style="width:100%" id="typeTravel" name="typeTravel" class="select-op" required>
                <option value="">เลือกประเภทท้องเที่ยว</option>
                <?php foreach ($category as $data) { ?>
                    <option value="<?php echo $data['_id']; ?>" <?php if ($dataTravel['category'] == $data['_id']) echo 'selected'; ?>>
                        <?php echo $data['_name']; ?>
                    </option>
                <?php } ?>
            </select><br>
            <label for="LocationTravel">Location Travel:</label><br>
            <p style="color: #f71c1c;">ตัวอย่าง ::</p> 
            <p>
                <?php 
                if ($dataTravel['location_travel'] !== '') {
                    echo '<p>'.$dataTravel['location_travel'].'</p>';
                } else {
                    echo '<p>ไม่มีแผนที่ แสดง !</p>';
                }
                ?>
            </p>
            <textarea type="text" id="location" name="location" style="width: 100%; height:230px; padding:10px;"><?php echo $dataTravel['location_travel'] ?></textarea><br>
            <label for="images">Image Travels:</label><br>
            <input type="file" id="images" name="images" accept="image/*"><br>
            <img id="previewImage" src="<?php echo $dataTravel['image_travel']?>" alt="" width="100%" height="450">
            <label for="details">Details Travels:</label><br>
            <textarea required type="text" id="details" name="details" style="width: 100%; height:230px; padding:10px;"><?php echo $dataTravel['details_travel']?></textarea><br>
            <button class="btn-successful" type="buttom" onclick="updateTrave()" >Save</button>
        </form>
     </div>
 </div>
</body>

<script>
function updateTravel() {
    var form = document.getElementById('updateForm');
    var formData = new FormData(form);
    fetch('http://localhost:8888/api/travel-api.php?id=<?php echo $_GET['id'];?>', {
        method: 'POST',
        body: formData
    }).then(response => response.json()).then(data => {
        console.log("DAta",data); // เพิ่มการจัดการข้อมูลที่คุณต้องการทำต่อไปที่นี่
        alert('Travel location updated successfully');
    }).catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        alert('Failed to update travel location');
    });
}
</script>