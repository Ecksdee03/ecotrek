<?php
spl_autoload_register(
    function($class){
        require_once "model/$class.php";
    }
);
$dao = new Authentication();
$search = $_GET['tbval'];
$profileID = $_GET['profileID'];
$newlist = [];
$listoffriendsID = $dao->findfriends($profileID);
foreach($listoffriendsID as $innerarray){
    foreach($innerarray as $friendID){
        $name = $dao->retrievefriendsnamebyID($search,$friendID);
        if (strpos($name, $search) !== false) {
            $profile = $dao->retrievefriendprofile($friendID);
            $pictureURL = $profile->getPictureURL();
            $nameoffriend = $profile->getName();
            $friendID = $profile->getProfileID();
            $friendData = [
                'pictureURL' => $pictureURL,
                'nameoffriend' => $nameoffriend,
                'id' => $friendID
            ];
            $newlist[] = $friendData;
        }
    
    }
   
    
}

$data = array('friends'=>$newlist);
echo json_encode($data);


?>