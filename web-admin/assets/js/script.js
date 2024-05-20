const openMangeHome = (key) => {
  if (key === "close") {
    document.getElementById("home-box").style.display = "block";
    document.getElementById("user-box").style.display = "none";
    document.getElementById("travel-box").style.display = "none";
  } else {
    document.getElementById("home-box").style.display = "none";
  }
};
const openMangeUser = (key) => {
  if (key === "open") {
    document.getElementById("user-box").style.display = "block";
    document.getElementById("home-box").style.display = "none";
    document.getElementById("travel-box").style.display = "none";
  } else {
    document.getElementById("user-box").style.display = "none";
  }
};
const openMangeTravel = (key) => {
  if (key === "open") {
    document.getElementById("user-box").style.display = "none";
    document.getElementById("travel-box").style.display = "block";
    document.getElementById("home-box").style.display = "none";
  } else {
    document.getElementById("travel-box").style.display = "none";
  }
};
// const openEditUser = (key) => {
//   if (key === "open") {
//     document.getElementById("edit-box").style.display = "block";
//   } else {
//     document.getElementById("edit-box").style.display = "none";
//   }
// };
function openAddPopup() {
    document.getElementById('addPopup').style.display = 'block';
}
function closeAddPopup() {
    document.getElementById('addPopup').style.display = 'none';
}
const linkPath = (link) => {
    window.location.href = link ;
}