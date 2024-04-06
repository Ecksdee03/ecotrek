<?php
    spl_autoload_register(
        function($class){
            require_once "model/$class.php";
        }
    );
    session_start();

    $email = $_GET['email'];
    $dao = new Authentication();
    $userdetails = $dao->retrieve($email);
    $userpoints = $dao->retrievepoints($_SESSION['profileID']);
    $friends =  $dao->findfriends($_SESSION['profileID']);
    $newfriendlist = []; // Initialize the array before the loop
    $nooffriends = $dao->numberoffriends($_SESSION['profileID']);
    foreach ($friends as $innerarray) {
        foreach($innerarray as $friend){
            $frienddetails = $dao->retrievefriendprofile($friend);
            $picFREN = $frienddetails->getPictureURL();
            $nameFREN = $frienddetails->getName();
            $id = $frienddetails->getProfileID();
            $friendData = [
                'profilepic' => $picFREN,
                'name' => $nameFREN,
                'id' => $id
            ];
        
            $newfriendlist[] = $friendData;     
        }
       
    }
    
    $profileURL = $userdetails->getPictureURL();
    $name = $userdetails->getName();    
    $points = $userdetails->getPoints();
    $address = $userdetails->getAddress();
    $biography = $userdetails->getBiography();

    // $lis = [];
    // $tryout = 123;
    // foreach($userpoints as $up ){
    //     $ptspermonth = $up->getcarbon_emission();
    //     array_push($lis, $ptspermonth );
    
    // }
    $data = array('profileURL' => $profileURL, 'name' => $name, 'points' => $points, 'address' => $address, 'biography' => $biography, 'pt'=>$userpoints, 'friend' =>$newfriendlist, 'nooffriends' => $nooffriends);
    echo json_encode($data);
