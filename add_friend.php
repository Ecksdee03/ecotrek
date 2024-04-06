<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$profileID1 = $_GET['profileID1'];
$profileID2 = $_GET['profileID2'];

$sql = "INSERT INTO friends (friend1id, friend2id) VALUES ('$profileID1', '$profileID2'), ('$profileID2', '$profileID1')";

$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$status = $stmt->execute();


echo json_encode($status,JSON_PRETTY_PRINT)

?>