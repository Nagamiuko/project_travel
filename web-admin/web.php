<?php
 $img_logp =  "assets/image/906343.png" ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
</head>
<body>
    <div class="body-box-layer">
        <div class="box-lert-bar">
            <div class="frame-box">
                <div class="box-frame-col">
                    <div class="logo">
                        <img src="<?=$img_logp?>" alt="" width="50"> 
                        <h1>Admin Dashboard</h1>
                    </div>
                </div>
                <div class="link"></div>
                <div class="box-frame-col">
                    <div class="box-menu-col">
                        <ul>
                            <li><i class="bi bi-house-door-fill"></i> หน้่าหลัก</li>
                            <li><i class="bi bi-people-fill"></i> จัดการผู้ใช้งาน</li>
                            <li><i class="bi bi-flag-fill"></i> จัดการที่ท้องเที่ยว</li>
                            <li><i class="bi bi-box-arrow-right"></i> ออกจากระบบ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-r-context">
          <div class="top-bar">
             <?php require "topbar.php" ;?>
          </div>
          <div class="content-board">
             <?php require "context.php" ;?>
          </div>
        </div>
    </div>
</body>
</html>