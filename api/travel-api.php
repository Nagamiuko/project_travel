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
    public function getAllTravelCategory() {
        $sql = "SELECT * FROM travel_category";
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
    
    public function deleteTravelLocationsById($_id) {
        $sql = "DELETE FROM `travel_location` WHERE _id = :id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute(['id' => $_id]);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete record']);
        }
    }
    public function deleteCommentById($_id) {
        $sql = "DELETE FROM `comment_travel` WHERE comment_id = :id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute(['id' => $_id]);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete record']);
        }
    }

    public function getTravelCommentById($_id) {
        $sql = "SELECT comment_travel.*, username , fullname, image_avatar FROM comment_travel 
        INNER JOIN user_travel ON comment_travel.u_id = user_travel._id
        WHERE comment_travel.t_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $_id]);
        $travel_user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($travel_user);
    }
    
    public function getTravelLocationsDetailById($_id) {
        $sql = "SELECT travel_location.*, travel_category.*
                FROM travel_location
                INNER JOIN travel_category ON travel_location.category = travel_category.category_name
                WHERE travel_location._id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $_id]);
        $travel_user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($travel_user);
    }
    // public function getTravelLocationsDetailById($_id) {
    //     $sql = "SELECT travel_location.*, travel_category.*, user_follow.*
    //             FROM travel_location
    //             INNER JOIN travel_category ON travel_location.category = travel_category.c_id
    //             LEFT JOIN user_follow ON travel_location._id = user_follow.t_id
    //             WHERE travel_location._id = :id";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute(['id' => $_id]);
    //     $travel_user = $stmt->fetch(PDO::FETCH_ASSOC);
    //     echo json_encode($travel_user);
    // }
    public function getTravelLocationsFollowById($_id) {
        $sql = "SELECT user_follow.*, travel_location.*
                FROM user_follow
                INNER JOIN travel_location ON user_follow.t_id = travel_location._id
                WHERE user_follow.user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $_id]);
        $travel_user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($travel_user);
    }
    public function deleteTravelLocationsFollowById($_id) {
        $sql = "DELETE FROM user_follow WHERE f_id = :id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute(['id' => $_id]);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'UnFollow successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to UnFollow']);
        }
    }

    public function getTravelCategoryById($_id) {
        $sql = "SELECT * FROM `travel_category` WHERE c_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $_id]);
        $travel_user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($travel_user);
    }


    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === 'GET') {
            if (isset($_GET['u_id'])) {
                $user_id = $_GET['u_id'];
                $this->getTravelLocationsByUserId($user_id);
            } else if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $this->getTravelLocationsById($id);
            } else if (isset($_GET['c_id'])) {
                $id = $_GET['c_id'];
                $this->getTravelCategoryById($id);
            } else if (isset($_GET['t_id'])) {
                $id = $_GET['t_id'];
                $this->getTravelLocationsDetailById($id);
            } else if (isset($_GET['travel_id'])) {
                $id = $_GET['travel_id'];
                $this->getTravelCommentById($id);
            } else if (isset($_GET['follow_id'])) {
                $id = $_GET['follow_id'];
                $this->getTravelLocationsFollowById($id);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Not Data API."));
                echo json_encode(array("message" => preg_match('~^/api/category/get-all-category/?$~', $_SERVER["REQUEST_URI"])));
            }
         }else if($_SERVER["REQUEST_METHOD"] === 'DELETE'){
            if (isset($_GET['del_id'])) {
                $id = $_GET['del_id'];
                $this->deleteTravelLocationsById($id);
            }
            if (isset($_GET['user_del_id'])) {
                $id = $_GET['user_del_id'];
                $this->deleteCommentById($id);
            }
            if (isset($_GET['user_unfollow_id'])) {
                $id = $_GET['user_unfollow_id'];
                $this->deleteTravelLocationsFollowById($id);
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Invalid request method."));
        }
    }
}
    
// ใช้คลาส TravelAPI เพื่อจัดการ API
$travelAPI = new TravelAPI($conn);
$travelAPI->handleRequest();
?>

