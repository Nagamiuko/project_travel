
<?php
$url_del = URL_API."travel-api?del-user-id=";
?>
  <body>
  <div class="content">
    <div class="container">
      <div class="table-responsive">
        <table class="table table-striped custom-table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Username</th>
              <th scope="col">Full Name</th>
              <th scope="col">Address</th>
              <th scope="col">Contact</th>
              <th scope="col">Status</th>
              <th scope="col">Option</th>
            </tr>
          </thead>
          <tbody>
           <?php foreach ( $data as $item) { ?>
            <tr scope="row">
              <td>
              <?=$item['_id']?>
              </td>
              <!-- <div class="d-flex align-items-center">
                <label class="custom-control ios-switch">
                <input type="checkbox" class="ios-switch-control-input" checked="">
                <span class="ios-switch-control-indicator"></span>
                </label>

              </div> -->
              <td class="pl-0">
                <img src="<?=URL_HOST.$item['image_avatar']?>" width="45" >
                <a href="#"> <?=$item['username']?></a>
              </td>
              <td class="pl-0">
                <a href="#"><?=$item['fullname']?></a>
              </td>
              <td>
                <?=$item['address']?>
                <small class="d-block">ที่อยู่ปัจจุบัน</small>
              </td>
              <td>+66 <?=$item['tel']?> </td>
              <td> <?php echo $item['admin_check'] === 'Admin' ? '<p style="color:#ff5e00; padding:5px 10px;  background:#fff;  border: 0.5px solid #ff5e00; border-radius:5px; text-align: center;">Admin</p>' : '<p style="color:#00a71c; padding:5px 10px;  background:#fff;  border: 0.5px solid #00a71c; border-radius:5px; text-align: center;">User</p>'; ?></td>
              <td><a class="more" onclick="linkPath('/web-admin/edit-user?id=<?=$item['_id']?>')" type="submit" style="color:#ff15b5;; padding:5px 20px;   background:#fff;  border: 0.5px solid #ff15b5; border-radius:5px;">edit</a> <button onclick="deleteUser('<?=$item['_id']?>')" class="more" style="color:#e90000;; padding:5px 20px;   background:#fff;  border: 0.5px solid #e90000; border-radius:5px;">delete</button></td> 
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

async function deleteUser(id) {
    try {
      if (id) {
          const url = `<?=$url_del?>${id}`;
            Swal.fire({
                title: '',
                text: 'คุณต้องการลบผู้ใช้หรือไม่',
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