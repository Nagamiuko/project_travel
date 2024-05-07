 <?php
session_start();
require 'database/db.php';

$user_id = $_SESSION['_id'];
$sql = "SELECT * FROM user_travel WHERE _id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="assets/js/popup-login.js"> </script>
    <link href="assets/css/login.css" rel="stylesheet">
    <title>Edit Profile</title>
</head>
<body>
    <div class="edit-profile">
        <button onclick="closeEditProfile()" class="btn-close"></button>
        <h1>Edit Profile</h1>
        <form action="actionEditprofile.php" method="post">
            <label for="name">FullName:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>">
            <label for="username">UserName:</label><br>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>">
            <label for="password">New Password:</label><br>
            <input type="password" id="password" name="password" placeholder="***********" >
            <label for="address">Address:</label></br>
            <textarea style="width: 100%;" id="address" name="address" ><?php echo $user['address']; ?></textarea><br>
            <label for="sex">Sex:</label><br>
            <input type="radio" id="male" name="sex" value="male" <?php if ($user['sex'] == 'male') echo 'checked'; ?>>
            <label for="male">Male</label><br>
            <input type="radio" id="female" name="sex" value="female" <?php if ($user['sex'] == 'female') echo 'checked'; ?>>
            <label for="female">Female</label><br><br>
            <label for="tel">Telephone:</label>
            <input type="tel" id="tel" name="tel" value="<?php echo $user['tel']; ?>"><br><br>
            <button class="btn-successful" type="submit">Save</button>
        </form>
    </div>
</body>
</html>
