<?php
 session_start();
 error_reporting(0);
 require "database/db.php";
 
    $logobg = "assets/image/logo02.png";
    $avatar = "assets/image/avatar.png";
    $html = "<div class='welcome'>Welcome</div";
    $user_id = $_SESSION['_id'];
    $sql = "SELECT * FROM user_travel WHERE _id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $avatar_set = $user['image_avatar'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="assets/css/custom.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">
    <link href="assets/css/menu-pop.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <?php if(!$_SESSION['username']) { ?>
     <nav>
         <div class="p-5 flex justify-between items-center w-[100%] bg-dark h-10 flex-media">
             <div class="box-menu">
               <div class="box-bg-logo" onclick="linkPath('/')">
                    <img src="<?=$logobg ?>" alt="">
                </div>
                 <div class="text-cyan-200 text-xl menu-lg">
                    <button onclick="openLoginPopup()">Sign In</button>
                </div>
            </div>
         </div>
     </nav>
  <?php } else {?>
     <nav>
         <div class="p-5 flex justify-between items-center w-[100%] bg-dark h-10 flex-media">
             <div class="box-menu">
                <div class="box-bg-logo" onclick="linkPath('/')">
                    <img src="<?=$logobg ?>" alt="">
                </div>
                <div class="box-bg-logo box-menu-pro avatar-img" onclick="openMenuPopup()">
                  <?php if($user['admin_check'] === 'Admin'){ ?>
                    <div class="menu-bord">
                      <button onclick="linkPath('/web-admin/')"><i class="bi bi-box-arrow-up-right"></i> ไปหน้าจัดการระบบ</button> 
                    </div>
                   <?php }?>
                   <img src="<?php echo !empty($avatar_set) ? $avatar_set : $avatar ?>" alt="">
                </div>
                <div id="menuPopup" class="menu-pop">
                      <button onclick="closeMenuPopup()" class="btn-close"></button>
                         <div class="menu-item-pro">
                             <ul>
                               <li style="color:black !important; 
                                          width:130px;
                                          text-overflow: ellipsis;
                                          overflow: hidden;
                                         "
                                ><i class="bi bi-person-circle"></i> : <?php echo $_SESSION['username']; ?></li>
                               <div class="line"></div>
                               <li onclick="openEditProfile(); closeMenuPopup()"><i class="bi bi-pencil-square"></i> บัญชีของฉัน</li>
                               <div class="line"></div>
                               <li> <a onclick="linkPath('myproduct')"><i class="bi bi-airplane-fill"></i> ท้องเที่ยว</a></li>
                               <div class="line"></div>
                               <li><a onclick="linkPath('my-follow')"><i class="bi bi-star-fill"></i> ติดตามของฉัน</a></li>
                               <div class="line"></div>
                               <p onclick="location.href='logout'"><i class="bi bi-box-arrow-right" style="front-size:25px"></i> ออกระบบ</p>
                         </div>
                  </div>
            </div>
        </div>
    </nav>
    <?php } ?>
        <div id="editProfile" class="login-popup menu-pop-edit-profile">
          <?php include "edit-profile.php" ?>
        </div>
        <div id="loginPopup" class="login-popup">
            <button onclick="closeLoginPopup()" class="btn-close"></button>
            <h2>Sign In</h2>
            <form action="login" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Sign In" name="login">
            </form>
            <button onclick="closeLoginPopup(); openRegister()">Register</button>
        </div>
        <div id="registerPopup" class="login-popup menu-pop-edit-profile ">
            <button onclick="closeRegisterPopup()" class="btn-close"></button>
            <h2>Sign Up</h2>
            <form action="register.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="name">Full-Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <label for="address">Address:</label></br>
                <textarea style="width:100%;"id="address" name="address" required></textarea><br><br>
                <label for="sex">Sex:</label><br>
                <input type="radio" id="male" name="sex" value="male">
                <label for="male">Male</label><br>
                <input type="radio" id="female" name="sex" value="female">
                <label for="female">Female</label><br><br>
                <label for="tel">Telephone:</label></br>
                <input type="tel" id="tel" name="tel" required><br><br>
                <input type="submit" value="Sign Up">
            </form>
        </div>
<script  src="assets/js/popup-login.js" lang="js"></script>
<script src="assets/js/link.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>

