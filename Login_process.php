<?php
spl_autoload_register(
    function($class){
        require_once "model/$class.php";
    }
);
session_start();
// echo json_encode(["status" => "hi"]);

$password = $_GET['password'];
$email = $_GET['email'];
$dao = new Authentication();
$user = $dao ->retrieve($email);
// echo json_encode(["status" => $user]);
$success = false;
if($user != null){
    $hashed = $user->getPassword();
    // $success = password_verify($password, $hashed);
    if($hashed == $password){
        $_SESSION["email"] = $email;
        $_SESSION['profileID'] = $user->getProfileID();
        echo json_encode(["status" => "success", "profileID" => $_SESSION["profileID"]]);
        exit();
    
    }

}
else{
    echo "HELLO";
    echo json_encode(["status" => "Failed credential"]);
    echo "Failed credentials please try again";
}








?>







?>