<?php
$logo = "Hello";
$logobg = "assets/image/logo02.png";
$avatar = "assets/image/avatar.png";
$html = "<div class='welcome'>Welcome</div";

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
   <header>
       <?php include "head.php"; ?>
   </header>
   <section>
      <div class="w-[100%] h-screen img-log">
         <div class="container">
             <div class="content">
                <div class="head">
                    <?php include "grid.php" ?>
                </div>
             </div>
         </div>
      </div>
   </section>
</body>
</html>
