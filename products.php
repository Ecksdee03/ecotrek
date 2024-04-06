<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$sql = "SELECT * FROM products";

$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

$products = [];
while( $row = $stmt->fetch() ) {
    $products[] = ['productID'=>$row['productID'], 'productName'=>$row['productName'], 'totalQuantity'=> $row['totalQuantity'], 'points'=>$row['points'], 'productURL'=>$row['productURL'], 'desiredQuantity'=>$row['desiredQuantity']];
}

echo json_encode($products,JSON_PRETTY_PRINT)

?>
