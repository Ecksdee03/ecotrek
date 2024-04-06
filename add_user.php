<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$name = $_GET['name'];
$password = $_GET['password'];
$email  = $_GET['email'];
$address = $_GET['address'];
$biography = $_GET['biography'];
$profileURL = $_GET['profileURL'];

$sql = "INSERT INTO users (name, password, email, address, biography, profileURL) VALUES ('$name', '$password', '$email', '$address', '$biography', '$profileURL')";

$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$status = $stmt->execute();


echo json_encode($status,JSON_PRETTY_PRINT)

?>