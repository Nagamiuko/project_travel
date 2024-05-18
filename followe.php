<?php
 require "database/db.php";
 require "env-config.php";

$userLogin = $_SESSION['username'] ;
$user_id = $_SESSION['_id'];
$message = '' ;
$alertSuccessfully = '<script>alert("อัปโหลดไฟล์ เรียบร้อยแล้ว !");</script>' ;
$alertError = '<script>alert("มีข้อผิดพลาดในการอัปโหลดไฟล์ !");</script>' ;

$travel_user = [] ;

$url = URL_API."travel-api?follow_id=".$user_id."";
$url_del = URL_API."travel-api?user_unfollow_id=";

$jsonDataRegion = file_get_contents('region.json');
$region = json_decode($jsonDataRegion, true);
$jsonData = file_get_contents('prevince.json');
$datas = json_decode($jsonData, true);

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
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
                            <option value="<?php echo $data['_id']?>" key="<?php echo $data['_id']?>"><?php echo $data['_name_th']?></option>
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
            <button onclick="search()" class="search-btn-mb"><i class="bi bi-search"></i></button>
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
                        <option value="<?php echo $data['_id']?>" key="<?php echo $data['_id']?>"><?php echo $data['_name_th']?></option>
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
    <div class="grid-container" id="grid-container">
            <?php foreach ($travel_user as $data) { ?>
            <div class="grid-item" id="grid-item" >
                <?php echo $data['travel_name'] ?>
                <?php echo $data['_id'] ?>
                <?php 
                $images = json_decode($data['image_travel'], true);
                if ($images) {
                    $firstImage = $images[0]; 
                    ?>
                     <div class="img" onclick="linkPath('detail-travel?id=<?php echo $data['t_id']?>'); ">
                        <img src="<?php echo $firstImage['file_path'] ?>" alt="" >
                    </div>
                 <?php }?>
                <div class="box-editor">
                    <div class="edit-pen" title="Edit Item" >
                    
                    </div>
                    <div class="delete-pen" title="Delete Item" onclick="unFollowLocation('<?php echo $data['f_id']?>')">
                        <i class="bi bi-trash3"></i>
                    </div>
                </div>
            </div>

        <?php } ?>
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
<script>
        async function unFollowLocation(id) {
            try {
                const response = await fetch(`<?=$url_del?>${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();
                console.log(result);
                if (response.ok) {
                    Swal.fire({
                        title: 'Success',
                        text: result.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Cancel'
                }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            console.log('User cancelled the action');
                        }
                })
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to delete the location.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Error:', error);
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