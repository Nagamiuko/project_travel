<?php
session_start();
error_reporting(0);
require 'api/db/db.php';
require __DIR__ . "/../env-config.php";
require 'head.php';
$dataTravel = [] ;
$dataComment = [] ;
$dataCategory = [] ;

$id = $_GET['id'];
$url = URL_API.'travel-api?t_id='.$id;
$url_follow = URL_API.'travel-api';
$del_comment = URL_API.'travel-api?user_del_id=';
$response = file_get_contents($url);
$comment_url = URL_API.'travel-api?travel_id='.$id;
$comment_res = file_get_contents($comment_url);
$date = date('Y-m-d', strtotime($dataTravel['date']));
$user_id = $_SESSION['_id'];
$sql = "SELECT * FROM user_travel WHERE _id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$avatar_set = $user['image_avatar'];
if ($response !== false) {
    $data = json_decode($response, true);
    if ($data !== null) {
        $dataTravel = $data ;
    } else {
        echo "Failed to decode JSON response.";
    }
} else {
    echo "Failed to fetch API data.";
}
if ($comment_res !== false) {
    $data = json_decode($comment_res, true);
    if ($data !== null) {
        $dataComment = $data ;
    } else {
        echo "Failed to decode JSON response.";
    }
} else {
    echo "Failed to fetch API data.";
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    if (!isset($_SESSION['view_count'])) {
        $_SESSION['view_count'] = 0;
    }
        $stmt = $conn->prepare("UPDATE travel_location SET travel_view = travel_view + 1 WHERE _id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
}
?>
<body>
    <section>
        <div id="detail-Travel">
            <button onclick="linkPath('/web-admin/');" class="btn-close"></button>
            <div class="detail-travel">
                <div class="content-box">
                    <div class="content-detail">
                        <div class="box-row">
                          <div class="slider-container">
                             <?php 
                                $images = json_decode($dataTravel['image_travel'], true);
                                if ($images) {
                                    foreach ($images as $img) { ?>
                                        <div class="slide">
                                            <img src="<?php echo URL_HOST.$img['file_path'] ?>" alt="" width="500">
                                        </div>
                                 <?php } }?>
                            <button id="prevBtn"><i class="bi bi-arrow-left-circle-fill"></i></button>
                            <button id="nextBtn"><i class="bi bi-arrow-right-circle-fill"></i></button>
                          </div>
                          <div class="box-frame-map">
                            <p></p>
                            <p>IMAGE</p>
                          </div>
                        </div>
                        <div class="box-row">
                            <div class="box-name-travel">
                                <h6><p>ชื่อที่ท้องเที่ยว : <?php echo $dataTravel['travel_name']?></p> </h6>
                                <h6><p>แหล่งท้องเที่ยว : <?php echo $dataTravel['category_name']?></p> </h6>
                                <h6><p>วันที่ประกาศ : <?php echo $date ?></p> </h6>
                            </div>
                            <div class="box-text-detail">
                              <h6>รายละเอียด: </h6>
                              <p><?php echo $dataTravel['details_travel'] ?> </p> 
                            </div>
                        </div>
                        <div class="box-row">
                            <div class="box-frame-map">
                              <p><?php echo $dataTravel['location_travel'] ?></p> 
                              <p>MAP</p>
                            </div>
                        </div>
                    </div>
                    <div class="content-detail">
                       <div class="box-comment">
                        <?php if(!empty($_SESSION['username'])) {?>
                         <div class="title-comment">
                          <div class="flex-end-lr">
                              <div class="name-image">
                                  <div class="img-avatar" style="background-image: url('<?php echo !empty($avatar_set) ? URL_HOST.$avatar_set : URL_HOST.$avatar?>');"></div>
                                    <div class="name-user">
                                        <?php echo $user['fullname'] ?>
                                    </div>
                              </div>
                              <div class="fowerving">
                                <?php if($user_id !== $dataTravel['user_id']){ ?>
                                 <form action="actionFollow" method="POST">
                                  <input style="display:none;" type="text" id="userid" name="userid" value="<?php echo $user_id?>">
                                  <input style="display:none;" type="text" id="travelid" name="travelid" value="<?php echo $dataTravel['_id']?>">
                                   <button>ติดตาม</button>
                                  </form>
                                <?php } else {echo '';} ?>
                              </div>
                          </div>
                           <form id="myForm" class="comment-btn" method="POST" action="actionComment?id=<?php echo $id?>">
                                <div class="comment-my ">
                                     <textarea id="comment_travel" name="comment_travel" placeholder="แสดงความคิดเห็น" type="text" id="location" name="location" style="width: 100%; height:80px; padding:10px;"></textarea>
                                </div>
                                <div class="comment-my">
                                    <button>ส่ง</button>
                                </div>
                          </form>
                         </div>
                          <?php }else{ ?>
                            <div class="title-comment">
                                <div class="comment-my flex justify-center">
                                    <button onclick="openLoginPopup();">กรุณา<p class="text-cyan-400"><svg class="svg-inline--fa fa-lock ml-1" style="width:12px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="lock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-v-94f785d5=""><path class="" style="" fill="currentColor" d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"></path></svg>เข้าสู่ระบบ</p>เพื่อแสดงความคิดเห็น</button>
                                </div>
                            </div>
                          <?php }?>
                            <div class="title-comment">
                                <div class="name-image">
                                    <?php
                                    if($dataComment) {
                                      foreach($dataComment as $data) { ?>
                                     <div class="comment">
                                        <div class="name-user">
                                            <div class="l">
                                                <div class="img-avatar" style="background-image: url('<?php echo !empty($data['image_avatar']) ? URL_HOST.$data['image_avatar'] : $avatar?>');"></div>
                                                <span><?php echo $data['fullname']?></span> 
                                            </div>
                                            <div class="r">
                                                Updata : <?php echo $data['date'] ?>
                                            </div>
                                            <?php if($user_id === $data['u_id'] ) { ?>
                                            <div class="btn-c">
                                                    <!-- <button>แก้ไข</button> -->
                                                    <button onclick="deleteComment('<?php echo $data['comment_id']?>');">ลบ</button>
                                            </div>
                                           <?php } else { ?>
                                            <div class="btn-c">
                                              <i class="bi bi-clock-history text-black"></i>
                                            </div>
                                            <?php } ?>
                                        </div>
                                           <div class="comment-text">
                                                    <p><?php echo !empty($data['comment_text']) === null ? 'ไม่มีคอมเม้น' : $data['comment_text'] ?></p>
                                                    <i class="bi bi-chat-quote-fill"></i>
                                            </div>
                                      </div>
                                      <?php }}else {
                                        echo "<div class='comment-text'><p>ไม่มีความคิดเห็น</p></div> ";
                                      }?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlide(index) {
  slides.forEach((slide, i) => {
    if (i === index) {
      slide.style.display = 'block';
    } else {
      slide.style.display = 'none';
    }
  });
}

function nextSlide() {
  currentSlide++;
  if (currentSlide >= totalSlides) {
    currentSlide = 0;
  }
  showSlide(currentSlide);
}

function prevSlide() {
  currentSlide--;
  if (currentSlide < 0) {
    currentSlide = totalSlides - 1;
  }
  showSlide(currentSlide);
}
showSlide(currentSlide);
document.getElementById('nextBtn').addEventListener('click', nextSlide);
document.getElementById('prevBtn').addEventListener('click', prevSlide);
function submitForm() {
  document.getElementById("myForm").reset();
}
</script>
<script>

 async function deleteComment(id) {
            try {
                const response = await fetch(`<?=$del_comment?>${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();
                console.log(result);
                if (response.ok) {
                    Swal.fire({
                        title: 'Success',
                        text: result.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Cancel'
                }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            console.log('User cancelled the action');
                        }
                })
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
 <style lang="css">
.slider-container {
  width: 400px;
  margin: 0 auto;
  overflow: hidden;
  position: relative;
}

.slide {
  display: none;
  max-width: 500px;
  mwx-height:300px
}

.slide img {
  object-fit: cover;
  width: 100%;
  height: 300px;
}

.slider-container button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  padding: 10px 20px;
  background-color: transparent;
  color: #fff;
  border: none;
  cursor: pointer;
}
.slider-container button i {
  font-size:30px;
}

#prevBtn {
  left: 0;
}

#nextBtn {
  right: 0;
}
.dots {
  text-align: center;
  margin-top: 20px;
}

.dot {
  display: inline-block;
  height: 10px;
  width: 10px;
  margin: 0 5px;
  background-color: #bbb;
  border-radius: 50%;
  cursor: pointer;
}

.active {
  background-color: #717171;
}

 </style>