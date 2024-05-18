<?php
$t1 = "assets/image/t1.jpeg";
$t2 = "assets/image/t2.jpeg";
$avatar = "assets/image/avatar.png";
?> 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="assets/js/popup-login.js"> </script>
    <link href="assets/css/login.css" rel="stylesheet">
</head>
<body>
    <div class="detall-travel">
        <button onclick="closeDetailTravel()" class="btn-close"></button>
        <div id="dataContainer"></div>
        <div class="box-detail-travel">
           <!-- <div class="box-img-l">
              <img src="<?=$t1?>" alt="" width="500">
           </div> -->
        </div>  
       
    </div>
</body>
</html>

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

</script>
<style>
.slider-container {
  width: 80%;
  margin: 0 auto;
  overflow: hidden;
  position: relative;
}

.slide {
  display: none;
}

.slide img {
  width: 100%;
  height: auto;
}

.slider-container button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
}

#prevBtn {
  left: 0;
}

#nextBtn {
  right: 0;
}
</style>