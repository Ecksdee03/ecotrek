<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$sql = "SELECT * FROM ride_hailing";

$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

$requests = [];
while( $row = $stmt->fetch() ) {
    $friends[] = ['name'=>$row['friendname'], 'id'=>$row['friendid'], 'points'=>$row['friendpoints']];
}

echo json_encode($friends,JSON_PRETTY_PRINT)

?>