<?php
require_once '../database/ConnectionManager.php';

$conn_manager = new ConnectionManager();
$conn = $conn_manager->getConnection();

$productId = $_GET['productId'];
$qty = $_GET['qty'];

$sql = "UPDATE products SET total_quantity = total_quantity - '$qty' WHERE productID = '$productId'";

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
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

// $data = [
//     "bamboo_toothbrush" => [
//         "productID" => "123",
//         "productName" => "Bamboo Toothbrush 10% Voucher",
//         "productQuantity" => 10,
//         "productPoints" => 25,
//         "productURL" => "images/products/bamboo_toothbrush.jpg"
//     ],
//     "metal_straw" => [
//         "productID" => "456",
//         "productName" => "Metal Straw 20% Voucher",
//         "productQuantity" => 12,
//         "productPoints" => 50,
//         "productURL" => "images/products/metal_straw.jpg"

//     ],
//     "wooden_cutlery" => [
//         "productID" => "789",
//         "productName" => "Wooden Cutlery 20% Voucher",
//         "productQuantity" => 3,
//         "productPoints" => 10,
//         "productURL" => "images/products/wooden_cutlery.jpg"

//     ],
// ];

// $result_arr = array();
// $result_arr["products_data"] = $data;

// $date = new DateTime("now", new DateTimeZone('Asia/Singapore'));
// $result_arr["info"] = array(
//     "author" => "Product Details",
//     "response_datetime_singapore" => $date->format('Y-m-d H:i:sP')
// );

// // set response code - 200 OK
// http_response_code(200);

// // show response
// echo json_encode($result_arr);

?>
