<?php

require_once 'Model/ConnectionManager.php';
require_once 'User.php';

class Authentication{
    public function insertRecords($name, $hashed, $email, $points, $address, $biography , $pictureURL){
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection(); 
        $sql = "insert into users(name, password, email,points,address,biography, profileURL)
                values(:name, :password, :email, :points, :address, :biography, :pictureURL)";
        $stmt =$pdo->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":password", $hashed);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":points", $points);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":biography", $biography);
        $stmt->bindParam(":pictureURL", $pictureURL);
        $status=$stmt->execute();
        $stmt=null;
        $pdo = null;
        return $status;
        // $sql = 
    }


    public function retrieve($email){
        $conn_manager = new ConnectionManager();
        $pdo = $conn_manager->getConnection();
        
        $sql = "select * from users where email=:email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":email",$email,PDO::PARAM_STR);
        $stmt->execute();
        
        $user = null;
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($row = $stmt->fetch()){
            $user = new User($row["email"],$row["password"], $row['name'], $row['points'], $row['address'], $row['biography'], $row['profileURL'], $row['profileID']);
        }
        else{
            $user = null;
        }
        
        $stmt = null;
        $pdo = null;
        return $user;
    }

    public function retrievefriendprofile($profileID){
        $conn_manager = new ConnectionManager();
        $pdo = $conn_manager->getConnection();
        
        $sql = "select * from users where profileID=:profileID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":profileID",$profileID,PDO::PARAM_INT);
        $stmt->execute();
        
        $user = null;
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($row = $stmt->fetch()){
            $user = new User($row["email"],$row["password"], $row['name'], $row['points'], $row['address'], $row['biography'], $row['profileURL'], $row['profileID']);
        }
        else{
            $user = null;
        }
        
        $stmt = null;
        $pdo = null;
        return $user;
    }



    public function retrievepoints($profileID){
        $conn_manager = new ConnectionManager();
        $pdo = $conn_manager->getConnection();
        $currentYear = date("Y");
        $sql = "SELECT 
        EXTRACT(MONTH FROM datetime_stamp) AS month,
        SUM(carbon_emission) AS totalptsformonth
        FROM user_travel
        WHERE profileID =:profileID
        AND YEAR(datetime_stamp) = :currentYear
        GROUP BY month
        ORDER BY month;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":profileID",$profileID,PDO::PARAM_INT);
        $stmt->bindParam(":currentYear", $currentYear, PDO::PARAM_INT);
        $stmt->execute();
        $pointsData = [];
        
        $user = null;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
           $points = [$row["totalptsformonth"]];
           $pointsData[] = $points;
        }
      
        $stmt = null;
        $pdo = null;
        return $pointsData;
    }



    public function findfriends($profileID){
        $conn_manager = new ConnectionManager();
        $pdo = $conn_manager->getConnection();
        $currentYear = date("Y");
        $sql = "SELECT
        CASE
          WHEN friend1ID = :profileID THEN friend2ID
          ELSE friend1ID
          END AS friend_id
      FROM friends
      WHERE friend1ID = :profileID OR friend2ID = :profileID
      ORDER BY friend_id DESC;
      ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":profileID",$profileID,PDO::PARAM_INT);
        $stmt->execute();
        $friendsID = [];
        
        $user = null;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
           $friendID = [$row["friend_id"]];
           $friendsID[] = $friendID;
        }
      
        $stmt = null;
        $pdo = null;
        return $friendsID;
    }


    function numberoffriends($profileID){
        $conn_manager = new ConnectionManager();
        $pdo = $conn_manager->getConnection();
        $currentYear = date("Y");
        $sql = "SELECT
        CASE
          WHEN friend1ID = :profileID THEN friend2ID
          ELSE friend1ID
          END AS friend_id
      FROM friends
      WHERE friend1ID = :profileID OR friend2ID = :profileID;
      ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":profileID",$profileID,PDO::PARAM_INT);
        $stmt->execute();
        $friendsID = [];
        
        $user = null;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
           $friendID = [$row["friend_id"]];
           $friendsID[] = $friendID;
        }
      
        $stmt = null;
        $pdo = null;
        return count($friendsID);
    }


    public function retrievefriendsnamebyID($name, $profileID){
        $conn_manager = new ConnectionManager();
        $pdo = $conn_manager->getConnection();
        $currentYear = date("Y");
        $sql = "SELECT 
        name from users where profileID = :profileID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":profileID",$profileID,PDO::PARAM_INT);
        $stmt->execute();
        
        $user = null;
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
           $name = $row["name"];
        }
      
        $stmt = null;
        $pdo = null;
        return $name;
    }

    public function addfriend($profileID, $id){
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection(); 
        $sql = "insert into friends(friend1ID, friend2ID)
                values(:profileID, :id)";
        $stmt =$pdo->prepare($sql);
        $stmt->bindParam(":profileID", $profileID, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $status=$stmt->execute();
        if($status == false){
            $status = "PDO Exception: " . $e->getMessage();
        }
        $stmt=null;
        $pdo = null;
        return $status;
        // $sql = 
    }


    public function deletefriend($profileID, $id){
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection(); 
        $sql = "delete from friends where (friend1ID =:profileID  and friend2ID=:id) or (friend1ID=:id and friend2ID=:profileID)";
        $stmt =$pdo->prepare($sql);
        $stmt->bindParam(":profileID", $profileID, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $status=$stmt->execute();
        if($status == false){
            $status = "PDO Exception: " . $e->getMessage();
        }
        $stmt=null;
        $pdo = null;
        return $status;
    }

    


    

    



    
}






?>