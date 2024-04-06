<?php
spl_autoload_register(
    function($class){
        require_once "model/$class.php";
    }
);


$profileID = $_GET['profileID'];
$id = $_GET['id'];
$dao = new Authentication();
$status = $dao->deletefriend($profileID, $id);
$data = array('status'=>$status);
echo json_encode($data);









?>