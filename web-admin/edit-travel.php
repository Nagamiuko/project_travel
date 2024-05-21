<?php 
error_reporting(0);
require "api/db/db.php";
require __DIR__ . "/../env-config.php";
require "head.php";
$dataTravel = [] ;

$id = $_GET['id'];
$url = URL_API.'travel-api?id='.$id;
$jsonDataRegion = file_get_contents('../region.json');
$region = json_decode($jsonDataRegion, true);
$prevince = file_get_contents('../prevince.json');
$previnces = json_decode($prevince, true);

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
$_id = $dataTravel['_id'];
$image = $dataTravel['image_travel'];
$category =[];
$url_category = URL_API."api?url=/category/get-all-category";
$res = file_get_contents($url_category);
if ($res !== false) {
    $data = json_decode($res, true);
    if ($data !== null) {
        $category = $data ;
    } else {
        echo "Failed to decode JSON response.";
    }
} else {
     echo "Failed to fetch API data.";
    }
$alertSuccessfully = '<script>alert("อัปโหลดไฟล์ เรียบร้อยแล้ว !")</script>';
$alertError = '<script>alert("มีข้อผิดพลาดในการอัปโหลดไฟล์ !")</script>';

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    // รับข้อมูล JSON

    // กำหนดค่าตัวแปรจากข้อมูล JSON
    $nameTravel = $_POST['name'];
    $typeTravel = $_POST['typeTravel'];
    $location = $_POST['location'];
    $details = $_POST['details'];
    $previnces = $_POST['previnces'];
    $regions = $_POST['regions'];
    
    // ตรวจสอบว่ามีภาพถูกอัปโหลดหรือไม่
    if (!empty($_FILES['images']['name'][0])) {
        $images = $_FILES['images'];
        if (!empty($images['tmp_name'][0])) {
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
            $jsonData = json_encode($imageData, true);
        }
    }else{
        $jsonData = $image;
    }

    // สร้างคำสั่ง SQL UPDATE
    $sql = "UPDATE `travel_location` SET 
        `travel_name`=?, 
        `details_travel`=?, 
        `location_travel`=?, 
        `category`=?, 
        `previnces`=?, 
        `regions`=?, 
        `image_travel`=? 
        WHERE `_id`=?";

    // เตรียมและ execute คำสั่ง SQL
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nameTravel, $details, $location, $typeTravel,$previnces,$regions,$jsonData, $_id]);
    
    // ตรวจสอบการอัปเดตข้อมูล
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('อัปโหลดไฟล์ เรียบร้อยแล้ว !');</script>";
        echo "<script>window.location.reload(true);</script>";
        // echo json_encode(["message" => "Travel location updated successfully"]);
    } else {
        http_response_code(500); // Internal Server Error
        // echo "<script>window.location.reload(true);</script>";
        // echo json_encode(["message" => "Failed to update travel location"]);
    }
}

?>
<body>
    <div id="editTravelPopup" class="edittravelup menu-pop-edittravelup">
    <div class="edit-travel-frame">
        <button onclick="linkPath('/web-admin/')" class="btn-close"></button>
        <h1>Edit Travels</h1>
        <form  method="POST" enctype="multipart/form-data">
            <label for="name">Name Travel:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $dataTravel['travel_name']?>" required><br>
            <label for="typeTravel">Category Travel:</label><br>
            <select style="width:100%" id="typeTravel" name="typeTravel" class="select-op" required>
                <option value="">เลือกประเภทท้องเที่ยว</option>
                <?php foreach ($category as $data) { ?>
                    <option value="<?php echo $data['category_name']; ?>" <?php if ($dataTravel['category'] == $data['category_name']) echo 'selected'; ?>>
                        <?php echo $data['category_name']; ?>
                    </option>
                <?php } ?>
            </select><br>
            <label for="typeTravel">Regions Travel:</label><br>
                <select style="width:100%" id="regions" name="regions" class="select-op" required>
                    <option value="">เลือกภูมิภาค</option>
                    <?php foreach($region as $data) { ?>
                        <option value="<?php echo $data['name']?>">
                        <option value="<?php echo $data['name']; ?>" <?php if ($dataTravel['regions'] == $data['name']) echo 'selected'; ?>>
                            <?php echo $data['name']?>
                        </option>
                    <?php } ?>
                </select><br>
                <label for="typeTravel">Previnces Travel:</label><br>
                <select style="width:100%" id="previnces" name="previnces" class="select-op" required>
                    <option value="">เลือกจังหวัด</option>
                    <?php foreach($previnces as $data) { ?>
                        <option value="<?php echo $data['_name_th']?>">
                        <option value="<?php echo $data['_name_th']; ?>" <?php if ($dataTravel['previnces'] == $data['_name_th']) echo 'selected'; ?>>
                            <?php echo $data['_name_th']?>
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
            <label for="image">Image Travels: <p style="color: #f71c1c;">ตัวอย่างไฟล์ที่รองรับ :: png , jpg , jpeg , gif , heic </p> </label><br>
            <div id="image-preview">
            <?php 
                $images = json_decode($dataTravel['image_travel'], true);
               if ($images) {
                foreach ($images as $img) { ?>
                    <img src="<?php echo URL_HOST.$img['file_path'] ?>" alt="">
             <?php }} ?>
            </div></br>
            <input type="file" id="images" name="images[]" accept="image/* , image/heic" multiple  onchange="previewImages(event)"><br>
            <label for="details">Details Travels:</label><br>
            <textarea required type="text" id="details" name="details" style="width: 100%; height:230px; padding:10px;"><?php echo $dataTravel['details_travel']?></textarea><br>
            <button class="btn-successful" type="submit">Save</button>
        </form>
     </div>
 </div>
</body>
<script>
  function previewImages(event) {
    var previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = '';

    var files = event.target.files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = function(e) {
            var imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            previewContainer.appendChild(imgElement);
        }

        reader.readAsDataURL(file);
    }
    }
</script>
<style>
        #image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 70px;
        }

        #image-preview img {
            max-width: 150px;
            max-height: 150px;
            width: 150px;
            height:150px;
        }

 </style>