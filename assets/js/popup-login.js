
function openLoginPopup() {
    document.getElementById('loginPopup').style.display = 'block';
}
function closeLoginPopup() {
    document.getElementById('loginPopup').style.display = 'none';
}

// Function to open the registration popup
function openRegister() {
    document.getElementById('registerPopup').style.display = 'block';
    document.getElementById('loginPopup').style.display = 'none'; // Hide login popup
}

// Function to close the registration popup
function closeRegisterPopup() {
    document.getElementById('registerPopup').style.display = 'none';
}
function openEditProfile() {
    document.getElementById('editProfile').style.display = 'block';
    document.getElementById('menuPopup').style.display = 'none'; // Hide login popup
}

function closeEditProfile() {
    document.getElementById('editProfile').style.display = 'none';
}


function openMenuPopup() {
    document.getElementById('menuPopup').style.display = 'block';
}
function closeMenuPopup() {
    document.getElementById('menuPopup').style.display = 'none';
}

function openAddPopup() {
    document.getElementById('addPopup').style.display = 'block';
}
function closeAddPopup() {
    document.getElementById('addPopup').style.display = 'none';
}

function openEditPopup() {
    document.getElementById('editTravelPopup').style.display = 'block';
}
function closeEditPopup() {
    document.getElementById('editTravelPopup').style.display = 'none';
}
function openDetailTravel(id) {
    document.getElementById('openTravel').style.display = 'block';
    // getDataById(id)
    // console.log("Click On! :",id);
}
function closeDetailTravel() {
    document.getElementById('openTravel').style.display = 'none';
}
function openSearch() {
    var openSearchDiv = document.getElementById('openSearch');
    openSearchDiv.classList.toggle('active');
    if (openSearchDiv.style.display === 'none' || openSearchDiv.style.display === '') {
        openSearchDiv.style.display = 'block';
    } else {
        openSearchDiv.style.display = 'none';
    }
}

// function getDataById(id) {
//     fetch(`${URL_API}travel-api.php?id=${id}`)
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return response.json();
//     })
//     .then(data => {
//         console.log(data);
//         document.getElementById('dataContainer').innerHTML = `
//         <p>Name: ${data?.travel_name}</p>
//         <p>Location: ${data?.location_travel}</p>
//         <p>Details: ${data?.details_travel}</p>
//         <p>Details: ${data?.image_travel}</p>
//         <div class="slider-container">
//             ${data?.image_travel?.map((item) => `
//                 <div class="slide">
//                     <img src="${item?.file_path}" alt="Image" width="500">
//                 </div>
//             `)}
//             <button id="prevBtn">Previous</button>
//             <button id="nextBtn">Next</button>
//         </div>
//     `;
    
//     })
//     .catch(error => {
//         console.error('There was a problem with the fetch operation:', error);
//         // แสดงข้อความข้อผิดพลาดหรือทำอะไรก็ตามที่คุณต้องการ
//     });
// }