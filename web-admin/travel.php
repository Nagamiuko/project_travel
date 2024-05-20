
<?php echo $title_page;
require "api/db/db.php";

$jsonDataRegion = file_get_contents('../region.json');
$region = json_decode($jsonDataRegion, true);
$prevince = file_get_contents('../prevince.json');
$previnces = json_decode($prevince, true);

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


?>
  <body>

  <div id="addPopup" class="login-popup addPopup">
    <div class="edit-profile">
        <button onclick="closeAddPopup()" class="btn-close"></button>
        <h1>Add Travels</h1>
            <form action="../actionAddItem.php" method="post" enctype="multipart/form-data">
                <label for="name">Name Travel:</label><br>
                <input type="text" id="name" name="name" value="" required placeholder="*เขาค้อ"><br>

                <label for="typeTravel">Category Travel:</label><br>
                <select style="width:100%" id="typeTravel" name="typeTravel" class="select-op" required>
                    <option value="">เลือกประเภทท้องเที่ยว</option>
                    <?php foreach($category as $data) { ?>
                        <option value="<?php echo $data['category_name']?>">
                            <?php echo $data['category_name']?>
                        </option>
                    <?php } ?>
                </select><br>
                <label for="typeTravel">Regions Travel:</label><br>
                <select style="width:100%" id="regions" name="regions" class="select-op" required>
                    <option value="">เลือกภูมิภาค</option>
                    <?php foreach($region as $data) { ?>
                        <option value="<?php echo $data['name']?>">
                            <?php echo $data['name']?>
                        </option>
                    <?php } ?>
                </select><br>
                <label for="typeTravel">Previnces Travel:</label><br>
                <select style="width:100%" id="previnces" name="previnces" class="select-op" required>
                    <option value="">เลือกจังหวัด</option>
                    <?php foreach($previnces as $data) { ?>
                        <option value="<?php echo $data['_name_th']?>">
                            <?php echo $data['_name_th']?>
                        </option>
                    <?php } ?>
                </select><br>

                <p style="color: #f71c1c;">ตัวอย่าง :: </p> 
                <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3822.858086793001!2d100.9946950759577!3d16.63388998413048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTbCsDM4JzAyLjAiTiAxMDDCsDU5JzUwLjIiRQ!5e0!3m2!1sth!2sth!4v1714534588988!5m2!1sth!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe><br>

                <label for="LocationTravel">Location Travel:</label><br>
                <p style="color: #f71c1c;">ตัวอย่าง :: โปรดปรับขนาดเท่ากับ  ความกว้าง : 400 x ความสูง : 300</p>
                <textarea type="text" id="location" name="location" style="width: 100%; height:230px; padding:10px;"> <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3822.858086793001!2d100.9946950759577!3d16.63388998413048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTbCsDM4JzAyLjAiTiAxMDDCsDU5JzUwLjIiRQ!5e0!3m2!1sth!2sth!4v1714534588988!5m2!1sth!2sth" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></textarea><br>

                <label for="image">Image Travels: <p style="color: #f71c1c;">ตัวอย่างไฟล์ที่รองรับ :: png , jpg , jpeg , gif , heic </p> </label><br>
                <div id="image-preview"></div></br>
                <input type="file" name="images[]" id="images" multiple  accept="image/* , image/heic" onchange="previewImages(event);"><br>

                <label for="details">Details Travels:</label><br>
                <textarea required type="text" id="details" name="details" style="width: 100%; height:230px"></textarea><br>

                <button class="btn-successful" type="submit">Save</button>
            </form>
    </div>
  </div>
  <div class="content">
    <div class="container">
      <div class="table-responsive">
       <button onclick="openAddPopup()" class="more">Add</button>
        <table class="table table-striped custom-table">
          <thead>
            <tr>
              <!-- <th scope="col">
                <label class="control control--checkbox">
                  <input type="checkbox"  class="js-check-all"/>
                  <div class="control__indicator"></div>
                </label>
              </th> -->
              <th scope="col">No</th>
              <th scope="col">Name</th>
              <th scope="col">Details</th>
              <th scope="col">Category</th>
              <th scope="col">Previnces</th>
              <th scope="col">Region</th>
              <th scope="col">Status Allow</th>
              <th scope="col">Allow Travel</th>
              <th scope="col">Option</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($dataItem as $item) { ?>
            <tr scope="row">
              <td>
               <?=$item['_id']?>
              </td>
              <!-- <td class="pl-0">
                <div class="d-flex align-items-center">
                  <label class="custom-control ios-switch">
                  <input type="checkbox" class="ios-switch-control-input" checked="">
                  <span class="ios-switch-control-indicator"></span>
                  </label>

                </div>
                <a href="#">James Yates</a>
              </td> -->
              <td class="pl-0">
                <a href="#"><?=$item['travel_name']?></a>
              </td>
              <td>
                รายละเอียด
                <small class="d-block"> <?=$item['details_travel']?></small>
              </td>
              <td> <?=$item['category']?></td>
              <td> <?=$item['previnces']?></td>
              <td> <?=$item['regions']?></td>
              <td> <?php echo $item['status_allow'] === 0 ? '<p style="color:#cd0000;">รออนุมัติ</p>' : '<p style="color:#00a71c;">อนุมัติแล้ว</p>'; ?></td>
              <?php if( $item['status_allow'] == 1) {
                echo ' <td> </td>';
              }else{?>
              <td><form action="actionAllow?t_id=<?php echo $item['_id']?>" method="POST"><button  style="color:#00a71c; padding:5px 10px;   background:#fff;  border: 0.5px solid#00a120; border-radius:5px;" class="more">Allow</button></form> </td>
              <?php } ?>
              <td><a href="/web-admin/detail-travel?id=<?=$item['_id']?> " class="more" style="color:#ff5e00; padding:5px 20px;   background:#fff;  border: 0.5px solid #ff5e00; border-radius:5px;">Details</a> <a href="/web-admin/edit-travel?id=<?= $item['_id']?>'" class="more" style="color:#ff15b5;; padding:5px 20px;   background:#fff;  border: 0.5px solid #ff15b5; border-radius:5px;">Edit</a></td>
            
            </tr>
           <?php } ?>
          </tbody>
        </table>
      </div>


    </div>

  </div>
    
  </body>
</html>

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