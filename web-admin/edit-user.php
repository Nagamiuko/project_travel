<?php
session_start();
require 'api/db/db.php';
require "head.php";

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM user_travel WHERE _id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
 <body>
    <div class="login-popup">
        <div class="edit-profile">
            <button onclick="linkPath('/web-admin/')" class="btn-close"></button>
            <h1>Edit Profile</h1>
            <form action="../actionEditprofile" method="post" enctype="multipart/form-data">
                <label for="name">FullName:</label><br>
                <input type="text" id="name" name="name" value="<?php echo $user['fullname']; ?>">
                <label for="username">UserName:</label><br>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>">
                <label for="password">New Password:</label><br>
                <input type="password" id="password" name="password" placeholder="***********" >
                <label for="address">Avatar:</label></br>
                <div id="image-preview"></div></br>
                <input type="file" id="images" name="images" onchange="previewImages(event)" ></br>
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