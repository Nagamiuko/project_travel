<?php
require_once 'db/db.php';
header("Content-Type: application/json; charset=UTF-8");

// สร้างเส้นทาง API โดยใช้เส้นทางที่ถูกส่งมาผ่านตัวแปร $_GET['url']
$request = $_GET['url'];
switch ($request) {
    case '/category/get-all-category':
        getAllTravelCategory();
        break;
    case '/get-all-item':
        getAllTravelLocations();
        break;
    case '/get-all-user':
        getAllUser();
        break;
    default:
        http_response_code(404);
        echo json_encode(array("message" => "Not Found"));
        break;
}

// ฟังก์ชั่นสำหรับเรียกใช้งาน API เกี่ยวกับหมวดหมู่ทั้งหมด
function getAllTravelCategory() {
    global $conn;
    $sql = "SELECT * FROM travel_category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $travel_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($travel_categories);
}

function getAllUser() {
    global $conn;
    $sql = "SELECT * FROM user_travel";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete record']);
    }
}
// ฟังก์ชั่นสำหรับเรียกใช้งาน API เกี่ยวกับสถานที่ท่องเที่ยวทั้งหมด
function getAllTravelLocations() {
    global $conn;
    // $sql = "SELECT * FROM travel_location";
    $sql = "SELECT *  FROM travel_location INNER JOIN travel_category ON travel_location.category = travel_category.category_name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $travel_locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($travel_locations);
}
