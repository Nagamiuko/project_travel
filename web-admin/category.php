
<?php echo $title_page;
require "api/db/db.php";



$url_del = URL_API."travel-api?del-category-id=";
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

  <div id="addCategory" class="login-popup addPopup">
    <div class="edit-profile">
        <button onclick="closeAddCategory()" class="btn-close"></button>
        <h1>Add Category</h1>
            <form action="actionCategory.php" method="post" enctype="multipart/form-data">
                <label for="name">Name Category:</label><br>
                <input type="text" id="name" name="name" value="" required placeholder="*เขาค้อ"><br>
                <button class="btn-successful" type="submit">Save</button>
            </form>
    </div>
  </div>
  <div class="content">
    <div class="container">
      <div class="table-responsive">
       <button onclick="openAddCategory()" class="more">Add</button>
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
              <th scope="col">Name Category</th>
              <th scope="col">Option</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($category as $item) { ?>
            <tr scope="row">
              <td>
               <?=$item['c_id']?>
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
                <a href="#"><?=$item['category_name']?></a>
              </td>
              <td><button onclick="deleteCat('<?=$item['c_id']?>')" class="more" style="color:#ff15b5;; padding:5px 20px;   background:#fff;  border: 0.5px solid #ff15b5; border-radius:5px;">Delete</button></td>
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
      async function deleteCat(id) {
          try {
            if (id) {
                const url = `<?=$url_del?>${id}`;
                  Swal.fire({
                      title: '',
                      text: 'คุณต้องการลบตัวเลือกใช้หรือไม่',
                      icon: 'info',
                      confirmButtonText: 'OK',
                      showCancelButton: true,
                      cancelButtonText: 'Cancel'
                  }).then(async (swalResult) => {
                      if (swalResult.isConfirmed) {
                          const response = await fetch(url, {
                          method: 'DELETE',
                          headers: {
                              'Content-Type': 'application/json'
                          }
                      });
                      let result;
                      try {
                          result = await response.json();
                      } catch (e) {
                          result = { message: 'Unexpected error occurred' };
                      }
                      console.log(result);
                      Swal.fire({
                            title: 'Success',
                            text: 'คุณทำการลบตัวเลือกนี้เรียบร้อย',
                            icon: 'success',
                            showConfirmButton: false
                        })
                        setTimeout(() => {
                            Swal.close();
                            window.location.reload();
                        }, 1000);

                      } else if (swalResult.dismiss === Swal.DismissReason.cancel) {
                        //text
                      }
                  });
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