<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$profileID = $_GET['profileID'];

$sql = "SELECT * FROM rewards_history where profileID = '$profileID'";

$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

$rewards = [];
while( $row = $stmt->fetch() ) {
    $rewards[] = ['productID'=>$row['productID'], 'quantity'=>$row['quantity']];
}

echo json_encode($rewards,JSON_PRETTY_PRINT)

?>