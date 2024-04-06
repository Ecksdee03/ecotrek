<?php
    spl_autoload_register(
        function($class){
            require_once "model/$class.php";
        }
    );
    session_start();

    $id = $_GET['id'];
    $profileID = $_GET['profileID'];
    $dao = new Authentication();
    $status = $dao->addfriend($profileID, $id);
    $data = array('status' => $status);
    echo json_encode($data);
