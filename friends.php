<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$profileID = $_GET['profileID'];

$sql = "SELECT u.name as friendname, f.friend2id as friendid, u.points as friendpoints FROM friends f, users u WHERE f.friend1id = '$profileID' AND f.friend2id = u.profileID";

$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

$friends = [];
while( $row = $stmt->fetch() ) {
    $friends[] = ['name'=>$row['friendname'], 'id'=>$row['friendid'], 'points'=>$row['friendpoints']];
}

echo json_encode($friends,JSON_PRETTY_PRINT)

?>