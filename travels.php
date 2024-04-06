<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$profileID = $_GET['profileID'];

$sql = "SELECT * from user_travel where profileID = '$profileID'";

$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

$travel = [];
while( $row = $stmt->fetch() ) {
    $travel[] = ['datetime_stamp'=>$row['datetime_stamp'], 'start_location'=>$row['start_location'], 'end_location'=>$row['end_location'],'carbon_emission'=>$row['carbon_emission']];
}

echo json_encode($travel,JSON_PRETTY_PRINT)

?>