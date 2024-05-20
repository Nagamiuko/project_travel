
<?php

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
              <td><?=$item['admin_check']?></td>
              <td><a class="more" onclick="linkPath('/web-admin/edit-user?id=<?=$item['_id']?>')" type="submit" style="color:#ff15b5;; padding:5px 20px;   background:#fff;  border: 0.5px solid #ff15b5; border-radius:5px;">edit</a> <a href="#" class="more" style="color:#e90000;; padding:5px 20px;   background:#fff;  border: 0.5px solid #e90000; border-radius:5px;">delete</a></td> 
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </body>
</html>
