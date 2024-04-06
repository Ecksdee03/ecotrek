<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

date_default_timezone_set('Asia/Singapore');
$profileID = $_GET['profileID'];
$datetime_stamp = date("Y-m-d",time());
$start_location = $_GET['start_location'];
$end_location = $_GET['end_location'];
$carbon_emission = $_GET['carbon_emission'];

$sql = "INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES ('$profileID', '$datetime_stamp', '$start_location', '$end_location', $carbon_emission);";

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