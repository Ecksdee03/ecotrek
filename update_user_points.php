<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$profileID = $_GET['profileID'];
$points = $_GET['points'];

$sql = "UPDATE users SET points = points +'$points' WHERE profileID = '$profileID'";

$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$status = $stmt->execute();

if ($status) {
    $status = ['status'=>true];
} else {
    $status = ['status'=>false];
}
echo json_encode($status,JSON_PRETTY_PRINT)

?>