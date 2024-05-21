<?php
require "database/db.php";
require "env-config.php";
session_start();
$userLogin = $_SESSION['username'] ;
$jsonDataRegion = file_get_contents('region.json');
$region = json_decode($jsonDataRegion, true);
$jsonData = file_get_contents('prevince.json');
$datas = json_decode($jsonData, true);
$url = URL_API.'api?url=/get-all-item';
$travel_all = [] ;
$travel_all_hit = [] ;
$category = [] ;
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


function sortByDate($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
}
usort($travel_all, 'sortByDate');
?>

<body>
    <!-- Search -->
 <?php if($userLogin !==  null){ ?>
    <div class="search-container">
        <div class="box-search">
            <input type="text" id="searchInput" class="search-box" placeholder="Search..." onchange="search()">
            <button onclick="search()" class="search-button">ค้นหา</button>
            <button class="search-btn-mb"><i class="bi bi-search"></i></button>
        </div>
        <div class="box-search">
         <button onclick="openSearch(!'open')" class="search-button">ค้นหาขั้นสูง</button>
        </div>
    </div>
    <div id="openSearch"class="openSearch">
     <div class="box-avn-search">
         <div class="d-flex flex-col w-[100%] mr-5">
            <div class="box-p">
                <p>เลือกภูมิภาค </p>
                <div class="search-box-p">
                    <select name="regions" id="regions" class="se" onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                        <option value="">ภูมิภาค</option>
                        <?php foreach ($region as $data) { ?>
                            <option value="<?php echo $data['name']?>" key="<?php echo $data['_id']?>"><?php echo $data['name']?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="box-p">
                <p>เลือกจังหวัด </p>
            <div class="search-box-p">
                <select name="previnces" id="previnces" class="se"  onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                    <option value="">จังหวัด</option>
                    <?php foreach ($datas as $data) { ?>
                        <option value="<?php echo $data['_name_th']?>" key="<?php echo $data['_id']?>"><?php echo $data['_name_th']?></option>
                        <p></p>
                    <?php }?>
                </select>
            </div>
           </div>
        </div>
         <div class="d-flex flex-col w-[100%] ">
            <div class="box-p">
                <p>เลือกประเภทท้องที่ยว</p>
                <div class="search-box-p">
                    <select name="category" id="category" class="se" onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                        <option value="">ประเภทท้องที่ยว</option>
                        <?php foreach ($category as $data) { ?>
                            <option value="<?php echo $data['category_name']?>" key="<?php echo $data['c_id']?>"><?php echo $data['category_name']?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="box-p">
                <p>เลือกเทศกาล </p>
            <div class="search-box-p">
                <select name="" id="" class="se"  onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                    <option value="">เทศกาล</option>
                    <?php foreach ($datas as $data) { ?>
                        <!-- <option value="<?php echo $data['_id']?>" key="<?php echo $data['_id']?>"><?php echo $data['_name_th']?></option> -->
                        <p></p>
                    <?php }?>
                </select>
            </div>
           </div>
        </div>
     </div>
   </div>
     <?php } else { ?> 
    <div class="search-container">
        <div class="box-search">
            <input type="text" id="searchInput" class="search-box" placeholder="Search..." onchange="search()">
            <button onclick="search()" class="search-button">ค้นหา</button>
            <button class="search-btn-mb"><i class="bi bi-search"></i></button>
        </div>
        <div class="box-search">
         <button onclick="openSearch('open')" class="search-button">ค้นหาขั้นสูง</button>
        </div>
    </div>
    <div id="openSearch"class="openSearch">
     <div class="box-avn-search">
         <div class="d-flex flex-col w-[100%] mr-5">
            <div class="box-p">
                <p>เลือกภูมิภาค </p>
                <div class="search-box-p">
                    <select name="regions" id="regions" class="se" onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                        <option value="">ภูมิภาค</option>
                        <?php foreach ($region as $data) { ?>
                            <option value="<?php echo $data['name']?>" key="<?php echo $data['_id']?>"><?php echo $data['name']?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="box-p">
                <p>เลือกจังหวัด </p>
            <div class="search-box-p">
                <select name="previnces" id="previnces" class="se"  onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                    <option value="">จังหวัด</option>
                    <?php foreach ($datas as $data) { ?>
                        <option value="<?php echo $data['_name_th']?>" key="<?php echo $data['_id']?>"><?php echo $data['_name_th']?></option>
                        <p></p>
                    <?php }?>
                </select>
            </div>
           </div>
        </div>
         <div class="d-flex flex-col w-[100%] ">
            <div class="box-p">
                <p>เลือกประเภทท้องที่ยว</p>
                <div class="search-box-p">
                    <select name="category" id="category" class="se" onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                        <option value="">ประเภทท้องที่ยว</option>
                        <?php foreach ($category as $data) { ?>
                            <option value="<?php echo $data['category_name']?>" key="<?php echo $data['c_id']?>"><?php echo $data['category_name']?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="box-p">
                <p>เลือกเทศกาล </p>
            <div class="search-box-p">
                <select name="" id="" class="se"  onchange="search()"> <!-- เลือก ID และ Name สำหรับ <select> -->
                    <option value="">เทศกาล</option>
                    <?php foreach ($datas as $data) { ?>
                        <!-- <option value="<?php echo $data['_id']?>" key="<?php echo $data['_id']?>"><?php echo $data['_name_th']?></option> -->
                        <p></p>
                    <?php }?>
                </select>
            </div>
           </div>
        </div>
     </div>
   </div>
   <?php } ?>
    <!-- Grid -->
    <div class="title-box-hit">
    <div class="box-title">
        <h4>มาใหม่</h4>
        <h5 onclick="linkPath('/')">ย้อนกลับ</h5>
    </div>
    <div class="grid-container" id="grid-container">
     <?php 
        foreach ($travel_all as $data) { 
         $url_path = "detail-travel?id=" . $data['_id'];
         if($data['status_allow'] === 1) {
           
        ?>
        
        <div class="grid-item " id="grid-item" onclick="linkPath('<?php echo $url_path?>')">
                <?php echo $data['travel_name'] ?>
                <p style="display:none"><?php echo $data['category'] ?></p>      
                <p style="display:none"><?php echo $data['previnces'] ?></p>      
                <p style="display:none"><?php echo $data['regions'] ?></p>      
                <?php 
                $images = json_decode($data['image_travel'], true);
                if ($images) {
                    $firstImage = $images[0]; 
                    // $time = date('H:i', strtotime($data['date']));
                    $date = date('Y-m-d', strtotime($data['date']));
                    ?>
                     <div class="img">
                        <img src="<?php echo $firstImage['file_path'] ?>" alt="">
                    </div>
                 <?php }?>
                 <div class="box-editor bottom-top">
                     <div class="edit-pen fower" title="ถูกใจ" onclick="linkPath(''); ">
                       <i class="bi bi-emoji-heart-eyes-fill"></i> <?php echo $data['travel_view']?>
                     </div>
                     <div class="edit-pen fower" title="ถูกใจ" onclick="linkPath(''); ">
                      <p> <i class="bi bi-calendar-date"></i> <?php echo $date?></p>
                     </div>
                 </div>
            </div>
      <?php }
       
       } ?>
    </div>
    </div>
</body>
<script>
        function search() {
            var input, filter, grid, gridItems, item, i, txtValue, regions, previnces, category;
            input = document.getElementById("searchInput");
            regions = document.getElementById("regions");
            previnces = document.getElementById("previnces");
            category = document.getElementById("category");
            filter = input.value.toUpperCase();
            var regionFilter = regions.value.toUpperCase();
            var previnceFilter = previnces.value.toUpperCase();
            var categoryFilter = category.value.toUpperCase();
            grid = document.getElementById("grid-container");
            gridItems = grid.getElementsByClassName("grid-item");

            for (i = 0; i < gridItems.length; i++) {
                item = gridItems[i];
                txtValue = item.textContent || item.innerText;
                var matchesFilter = true;

                if (filter && txtValue.toUpperCase().indexOf(filter) === -1) {
                    matchesFilter = false;
                }
                if (regionFilter && txtValue.toUpperCase().indexOf(regionFilter) === -1) {
                    matchesFilter = false;
                }
                if (previnceFilter && txtValue.toUpperCase().indexOf(previnceFilter) === -1) {
                    matchesFilter = false;
                }
                if (categoryFilter && txtValue.toUpperCase().indexOf(categoryFilter) === -1) {
                    matchesFilter = false;
                }

                item.style.display = matchesFilter ? "" : "none";
            }
        }
</script>

