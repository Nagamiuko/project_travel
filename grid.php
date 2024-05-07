<?php
require "database/db.php";
session_start();
$userLogin = $_SESSION['username'] ;
$jsonDataRegion = file_get_contents('region.json');
$region = json_decode($jsonDataRegion, true);
$jsonData = file_get_contents('prevince.json');
$datas = json_decode($jsonData, true);
$url = 'http://localhost:8888/api/travel-api.php';
$travel_all = [] ;

if($_SERVER["REQUEST_METHOD"] == "GET"){
$response = file_get_contents($url);
if ($response !== false) {
    $data = json_decode($response, true);
    if ($data !== null) {
        $travel_all = $data ;
    } else {
        echo "Failed to decode JSON response.";
    }
} else {
     echo "Failed to fetch API data.";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Search and Grid Page</title>

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
     <?php foreach ($travel_all as $data) { ?>
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
            </div>
      <?php } ?>
    </div>

<script>
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



</body>
</html>
