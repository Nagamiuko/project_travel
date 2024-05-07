<?php
require "db/db.php";
header("Content-Type: application/json; charset=UTF-8");
class TravelAPI {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllTravelLocations() {
        $sql = "SELECT * FROM travel_location";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $travel_user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($travel_user);
    }

    public function getTravelLocationsByUserId($user_id) {
        $sql = "SELECT * FROM `travel_location` WHERE u_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $user_id]);
        $travel_user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($travel_user);
    }
    public function getTravelLocationsById($_id) {
        $sql = "SELECT * FROM `travel_location` WHERE _id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $_id]);
        $travel_user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($travel_user);
    }
    public function updateTravelLocation($_id) {
        if (!isset($_id) || empty($_id)) {
            http_response_code(400);
            echo"<script> console.log('Failed to update travel location ".$_id."');</script>";
            echo json_encode(array("message" => "Missing travel ID."));
            return;
        }

        // ตรวจสอบว่ามีข้อมูลที่ส่งมาแล้วหรือไม่
        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data)) {
            http_response_code(400);
            echo json_encode(array("message" => "No data provided for update."));
            return;
        }

        // ตรวจสอบและดึงข้อมูลที่ต้องการอัปเดต
        $sql = "SELECT * FROM `travel_location` WHERE `_id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $_id]);
        $travel_location = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$travel_location) {
            http_response_code(404);
            echo json_encode(array("message" => "Travel location not found."));
            return;
        }

        // ดึงข้อมูลที่ต้องการอัปเดตจากข้อมูลที่ส่งมา
        $nameTravel = !empty($data['name']) ? $data['name'] : $travel_location['travel_name'];
        $typeTravel = !empty($data['typeTravel']) ? $data['typeTravel'] : $travel_location['category'];
        $location = !empty($data['location']) ? $data['location'] : $travel_location['location_travel'];
        $details = !empty($data['details']) ? $data['details'] : $travel_location['details_travel'];
        $image_pathOly = $travel_location['image_travel'];

        // ตรวจสอบและอัปโหลดไฟล์ภาพใหม่ (ถ้ามี)
        $image_path = $image_pathOly;
        if (!empty($_FILES['images']['name'])) {
            $file_name = $_FILES['images']['name'];
            $file_tmp = $_FILES['images']['tmp_name'];
            $upload_dir = 'uploads/';
            move_uploaded_file($file_tmp, $upload_dir . $file_name);
            $image_path = $upload_dir . $file_name;
        }

        // อัปเดตข้อมูลในฐานข้อมูล
        $sql = "UPDATE `travel_location` SET 
                `travel_name` = :name, 
                `details_travel` = :details, 
                `location_travel` = :location, 
                `category` = :typeTravel, 
                `image_travel` = :image_path 
                WHERE `_id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'name' => $nameTravel,
            'details' => $details,
            'location' => $location,
            'typeTravel' => $typeTravel,
            'image_path' => $image_path,
            'id' => $_id
        ]);

        // ตอบกลับด้วยข้อมูลที่อัปเดตเรียบร้อยแล้ว
        http_response_code(200);
        echo json_encode(array("message" => "Travel location updated successfully."));
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === 'GET') {
            if (isset($_GET['u_id'])) {
                $user_id = $_GET['u_id'];
                $this->getTravelLocationsByUserId($user_id);
            } else if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $this->getTravelLocationsById($id);
            } else {
                $this->getAllTravelLocations();
            }
         } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //   parse_str(file_get_contents("php://input"), $_POST);
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $this->updateTravelLocation($id);
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Missing travel ID."));
            }
        }
         else {
            http_response_code(400);
            echo json_encode(array("message" => "Invalid request method."));
        }
    }
}

// ใช้คลาส TravelAPI เพื่อจัดการ API
$travelAPI = new TravelAPI($conn);
$travelAPI->handleRequest();
?>

