<?php
require "env-config.php";
try {
    $conn = new PDO("mysql:host=" . DATABASE_HOSTNAME . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //  echo "<script>alert('Connection successfully');</script>";
} catch(PDOException $e) { 
    echo "<script>alert('Connection failed:". $e->getMessage()."');</script>";
}
?>


<?php
// require "env-config.php";

// class Database {
//     private $conn;

//     public function __construct() {
//         try {
//             $this->conn = new PDO("mysql:host=" . DATABASE_HOSTNAME . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
//             $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch(PDOException $e) {
//             // Handle connection error
//             die("Connection failed: " . $e->getMessage());
//         }
//     }

//     public function disconnect() {
//         $this->conn = null;
//     }

//     public function query($sql) {
//         try {
//             $stmt = $this->conn->query($sql);
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         } catch(PDOException $e) {
//             // Handle query error
//             die("Query failed: " . $e->getMessage());
//         }
//     }

//     public function execute($sql, $params = []) {
//         try {
//             $stmt = $this->conn->prepare($sql);
//             $stmt->execute($params);
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         } catch(PDOException $e) {
//             // Handle execute error
//             die("Execution failed: " . $e->getMessage());
//         }
//     }
// }

// Example usage:
// $db = new Database();
// $data = $db->query("SELECT * FROM travel_location");
// var_dump($data);
?>
