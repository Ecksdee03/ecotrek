<?php
spl_autoload_register(
    function($class){
        require_once "Model/$class.php";
    }
);
// $name, $password, $email, $points, $address, $biography , $pictureURL
$name = $_GET['name'];
$password =  $_GET['password'];
$email = $_GET['email'];
$points = 0;
$address = $_GET['address'];
$biography = "-";
$pictureURL = "Images/images.jpg";
// $hashed = password_hash($password, PASSWORD_DEFAULT);
$dao = new Authentication();
$st = $dao->retrieve($email);
if($st == null){
    $status = $dao->insertRecords($name, $password, $email, $points, $address, $biography , $pictureURL);
echo "Whatsup la";
if($status){
    echo "success";
}
else{
    echo "fail";
}
}
else{
    $data = "User already exist";
    echo json_encode($data);
}






?>