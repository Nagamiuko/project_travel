<?php
include_once "database/db.php";
session_start();

function search($keyword, $region, $province, $category) {
    $conditions = [];
    if (!empty($keyword)) {
        $keyword = $conn->real_escape_string($keyword);
        $conditions[] = "(name LIKE '%$keyword%' OR description LIKE '%$keyword%')";
    }
    if (!empty($region)) {
        $region = $conn->real_escape_string($region);
        $conditions[] = "region_id = '$region'";
    }
    if (!empty($province)) {
        $province = $conn->real_escape_string($province);
        $conditions[] = "province_id = '$province'";
    }
    if (!empty($category)) {
        $category = $conn->real_escape_string($category);
        $conditions[] = "category_id = '$category'";
    }

    $sql = "SELECT * FROM travel_location";
    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $result = $conn->query($sql);

    $items = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }

    $conn->close();
    return $items;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $keyword = $_POST['keyword'] ?? '';
    $region = $_POST['region'] ?? '';
    $province = $_POST['province'] ?? '';
    $category = $_POST['category'] ?? '';

    $results = search($keyword, $region, $province, $category);

    echo json_encode($results);
}
?>