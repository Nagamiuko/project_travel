<?php
 include_once "database/db.php";
 $userLogin = $_SESSION['username'] ;
 $user_id = $_SESSION['_id'];
$jsonDataRegion = file_get_contents('region.json');
$region = json_decode($jsonDataRegion, true);
$jsonData = file_get_contents('prevince.json');
$datas = json_decode($jsonData, true);
$jsonDataCategory = file_get_contents('category.json');
$category = json_decode($jsonDataCategory, true);
$message = '' ;
$alertSuccessfully = '<script>alert("อัปโหลดไฟล์ เรียบร้อยแล้ว !");</script>' ;
$alertError = '<script>alert("มีข้อผิดพลาดในการอัปโหลดไฟล์ !");</script>' ;

$travel_user = [] ;
$url = "http://localhost:8888/api/travel-api.php?u_id=".$user_id."";
if($_SERVER["REQUEST_METHOD"] == "GET"){
$response = file_get_contents($url);
if ($response !== false) {
    $data = json_decode($response, true);
    if ($data !== null) {
        $travel_user = $data ;
    } else {
        echo "Failed to decode JSON response.";
    }
} else {
     echo "Failed to fetch API data.";
}
}
// $sql = "SELECT * FROM `travel_location` WHERE u_id = :id";
// $stmt = $conn->prepare($sql);
// $stmt->execute(['id' => $user_id]);
// $travel_user = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Search and Grid Page</title>
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <!-- Search -->
 <?php if($userLogin !==  null){ ?>
    <div class="search-container">
        <div class="box-search">
            <input type="text" id="searchInput" class="search-box" placeholder="Search..." onchange="search()">
            <button onclick="search()" class="search-button">Search</button>
            <button class="search-btn-mb"><i class="bi bi-search"></i></button>
        </div>
        <div class="box-search">
            <select name="regions" id="regions" class="select-op" onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                <option value="">เลือกภูมิภาค</option>
                <?php foreach ($region as $data) { ?>
                    <option value="<?php echo $data['_id']?>" key="<?php echo $data['_id']?>"><?php echo $data['name']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="box-search">
                <select name="previnces" id="previnces" class="select-op"  onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                    <option value="">เลือกจังหวัด</option>
                    <?php foreach ($datas as $data) { ?>
                        <option value="<?php echo $data['_id']?>" key="<?php echo $data['_id']?>"><?php echo $data['_name_th']?></option>
                        <p></p>
                        <?php }?>
                    </select>
                </div>
              <div class="box-search">
                    <div class="nav">
                        <div class="btn-add" onclick="openAddPopup()"><i class="bi bi-plus-square-fill"></i> Add Travels </div>
                    </div>
              </div>
            </div>
    <div id="addPopup" class="login-popup addPopup">
    <div class="edit-profile">
        <button onclick="closeAddPopup()" class="btn-close"></button>
        <h1>Add Travels</h1>
            <form action="actionAddItem.php" method="post" enctype="multipart/form-data">
                <label for="name">Name Travel:</label><br>
                <input type="text" id="name" name="name" value="" required><br>

                <label for="typeTravel">Category Travel:</label><br>
                <select style="width:100%" id="typeTravel" name="typeTravel" class="select-op" required>
                    <option value="">เลือกประเภทท้องเที่ยว</option>
                    <?php foreach($category as $data) { ?>
                        <option value="<?php echo $data['_id']?>">
                            <?php echo $data['_name']?>
                        </option>
                    <?php } ?>
                </select><br>

                <p style="color: #f71c1c;">ตัวอย่าง ::</p> 
                <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3822.858086793001!2d100.9946950759577!3d16.63388998413048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTbCsDM4JzAyLjAiTiAxMDDCsDU5JzUwLjIiRQ!5e0!3m2!1sth!2sth!4v1714534588988!5m2!1sth!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe><br>

                <label for="LocationTravel">Location Travel:</label><br>
                <textarea type="text" id="location" name="location" style="width: 100%; height:230px; padding:10px;"> <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3822.858086793001!2d100.9946950759577!3d16.63388998413048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTbCsDM4JzAyLjAiTiAxMDDCsDU5JzUwLjIiRQ!5e0!3m2!1sth!2sth!4v1714534588988!5m2!1sth!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></textarea><br>

                <label for="image">Image Travels: <p style="color: #f71c1c;">ตัวอย่างไฟล์ที่รองรับ :: png , jpg , jpeg , gif , heic </p> </label><br>
                <div id="image-preview"></div></br>
                <input type="file" name="images[]" id="images" multiple accept="image/* , image/heic" onchange="previewImages(event)"><br>

                <label for="details">Details Travels:</label><br>
                <textarea required type="text" id="details" name="details" style="width: 100%; height:230px"></textarea><br>

                <button class="btn-successful" type="submit">Save</button>
            </form>
    </div>
  </div>
     <?php } else { ?> 
    <div class="search-container">
       <div class="box-search">
            <input type="text" id="searchInput" class="search-box" placeholder="Search..." onchange="search()">
            <button onclick="search()" class="search-button">Search</button>
            <button onclick="search()" class="search-btn-mb"><i class="bi bi-search"></i></button>
        </div>
    </div>
   <?php } ?>
    <!-- Grid -->
    <div class="grid-container" id="grid-container">
            <?php foreach ($travel_user as $data) { ?>
            <div class="grid-item" id="grid-item">
                <?php echo $data['travel_name'] ?>
                <?php echo $data['_id'] ?>
                <?php 
                $images = json_decode($data['image_travel'], true);
                if ($images) {
                    $firstImage = $images[0]; 
                    ?>
                     <div class="img">
                        <img src="<?php echo $firstImage['file_path'] ?>" alt="">
                    </div>
                 <?php }?>
                <div class="box-editor">
                    <div class="edit-pen" title="Edit Item" onclick="linkPath('edit-travel.php?id=<?php echo $data['_id']?>'); ">
                        <i class="bi bi-pencil-fill"></i>
                    </div>
                    <div class="delete-pen" title="Delete Item">
                        <i class="bi bi-trash3"></i>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
</body>
<script src="assets/js/popup-login.js"></script>
<script src="assets/js/link.js"></script>   
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
        function search() {
            var input, filter, grid, gridItems, item, i, txtValue, regions, previnces;
            input = document.getElementById("searchInput");
            regions = document.getElementById("regions");
            previnces = document.getElementById("previnces");
            filter = input.value.toUpperCase();
            var regionFilter = regions.value.toUpperCase();
            var previnceFilter = previnces.value.toUpperCase();
            grid = document.getElementById("grid-container");
            gridItems = grid.getElementsByClassName("grid-item");
            
            for (i = 0; i < gridItems.length; i++) {
                item = gridItems[i];
                txtValue = item.textContent || item.innerText;
                var isMatch = false;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    isMatch = true;
                }
                if (regionFilter && previnceFilter) {
                    if (txtValue.toUpperCase().indexOf(regionFilter) > -1 && txtValue.toUpperCase().indexOf(previnceFilter) > -1) {
                        isMatch = true;
                    } else {
                        isMatch = false;
                    }
                }
                if (isMatch) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
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