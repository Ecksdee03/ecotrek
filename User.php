<?php

class User{
    private $profileID;
    private $name;
    private $password; 
    private $email;
    private $points;
    private $address;
    private $biography;
    private $pictureURL;

    public function __construct($email, $password, $name, $points, $address, $biography, $pictureURL, $profileID){
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->points = $points;
        $this->address = $address;
        $this->biography = $biography;
        $this->pictureURL = $pictureURL;
        $this->profileID = $profileID;
    }

    public function getName(){
        return $this->name;
    }
    public function getPoints(){
        return $this->points;
    }
    public function getAddress(){
        return $this->address;
    }
    public function getBiography(){
        return $this->biography;
    }
    public function getPictureURL(){
        return $this->pictureURL;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getProfileID(){
        return $this->profileID;
    }
    public function getPassword(){
        return $this->password;
    }


//     profile_id INT NOT NULL AUTO_INCREMENT,
//   name VARCHAR(255) NOT NULL,
//   email VARCHAR(255) NOT NULL,
//   password VARCHAR(255) NOT NULL,
//   points INT NOT NULL DEFAULT 0,
//   address VARCHAR(255),
//   PRIMARY KEY (profile_id)

}