<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$profileID = $_GET['profileID'];
$name = $_GET['name'];
// $password = $_GET['password'];
$email  = $_GET['email'];
$address = $_GET['address'];
$biography = $_GET['biography'];
// $profileURL = $_GET['profileURL'];

$sql = "UPDATE users SET name = '$name', email = '$email', address = '$address', biography = '$biography' WHERE profileID = '$profileID'";

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