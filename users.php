<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$sql = "SELECT * FROM users";

$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

$users = [];
while( $row = $stmt->fetch() ) {
    $users[] = ['id'=>$row['profileID'], 'name'=>$row['name'], 'password'=> $row['password'], 'email'=>$row['email'], 'points'=>$row['points'], 'address'=>$row['address'] , 'biography'=>$row['biography'], 'profileURL'=>$row['profileURL']];
}

echo json_encode($users,JSON_PRETTY_PRINT)

?>