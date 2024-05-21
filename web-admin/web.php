<?php
error_reporting(0);
require __DIR__ . "/../env-config.php";
 $img_logp =  "assets/image/906343.png" ;
 $user_name =  $user['fullname'];
 $avatar_image =  $user['image_avatar'];

 $dataUser = [];
 $dataItem = [];
 $url_api = URL_API . "api?url=/get-all-user";
 $res = file_get_contents($url_api);
 if ($res !== false) {
     $item = json_decode($res, true);
     if ($item !== null) { // แก้จาก $res เป็น $item
         $dataUser = $item;
     } else {
         echo "Failed to decode JSON response.";
     }
 } else {
     echo "Failed to fetch API data.";
 }
 $url_api_item = URL_API . "api?url=/get-all-item";
 $items = file_get_contents($url_api_item);
 if ($items !== false) {
     $item = json_decode($items, true);
     if ($item !== null) { // แก้จาก $res เป็น $item
         $dataItem = $item;
     } else {
         echo "Failed to decode JSON response.";
     }
 } else {
     echo "Failed to fetch API data.";
 }
 
// echo $dataUser['fullname'] ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>dashboard</title>
</head>
<body>
    <div class="body-box-layer">
        <div class="box-lert-bar">
            <div class="frame-box">
                <div class="box-frame-col">
                    <div class="logo">
                        <div class="img">
                            <img src="<?=$img_logp?>" alt="" width="45"> 
                        </div>
                        <h1>Dashboard</h1>
                    </div>
                </div>
                <div class="link" style="width:100%"></div>
                <div class="box-frame-col">
                    <div class="logo">
                      <div class="img">
                        <!-- <img src="<?=$avatar?>" alt="" width="45">  -->
                        <img src="<?=$url_host.'/'.$avatar_set?>" alt="" width="50"> 
                      </div>
                        <div class="text-name">
                            <h1>Admin : <?php echo $user_name ;?></h1>
                        </div>
                    </div>
                </div>
                <div class="link"></div>
                <div class="box-frame-col">
                    <div class="box-menu-col">
                        <ul>
                            <li onclick="openMangeHome('close')"><i class="bi bi-house-door-fill"></i> หน้าหลัก</li>
                            <li onclick="openMangeUser('open'); "><i class="bi bi-people-fill"></i> จัดการผู้ใช้งาน</li>
                            <li onclick="openMangeTravel('open')"><i class="bi bi-flag-fill"></i> จัดการที่ท้องเที่ยว</li>
                            <li onclick="openMangeCategory('open')"><i class="bi bi-tags-fill"></i> จัดการหมวดหมู่</li>
                            <li onclick="linkPath('/logout');"><i class="bi bi-box-arrow-right"></i> ออกจากระบบ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-r-context">
            <section id='home-box'>
                <div class="top-bar">
                    <?php  $title_page = "" ; require "topbar.php" ;?>
                </div>
                <div class="content-board">
                  <?php 
                     $title_text = "🔧 Welcome To Admin Dashboard 🔧";
                     require "welcome.php" ;
                    ?>
                </div>
            </section>
            <section id='user-box'>
                <div class="top-bar">
                    <?php  
                     $title_page = "จัดการผู้ใช้งาน" ;
                     $data = $dataUser; 
                     require "topbar.php" ;?>
                </div>
               <div class="content-board">
                  <?php 
                    $title_page = "" ;
                    require "customer.php" ;
                   ?>
                </div>
            </section>
            <section id='travel-box'>
               <div class="top-bar">
                    <?php $title_page = "จัดการที่ท้องเที่ยว"; $dataItem = $dataItem ; require "topbar.php" ;?>
               </div>
              <div class="content-board">
                 <?php  
                   $title_page = "" ; 
                   require "travel.php" ;
                 ?>
              </div>
          </section>
            <section id='category-box'>
               <div class="top-bar">
                    <?php $title_page = "จัดการทหมวดหมู่"; $dataItem = $dataItem ; require "topbar.php" ;?>
               </div>
              <div class="content-board">
                 <?php  
                   $title_page = "" ; 
                   require "category.php" ;
                 ?>
              </div>
          </section>
        </div>
    </div>
</body>
</html>