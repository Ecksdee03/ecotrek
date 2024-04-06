<?php

class user_travel{
    private $profileID;
    private $datetime_stamp;
    private $start_location; 
    private $end_location;
    private $carbon_emission;

    public function __construct($profileID, $datetime_stamp, $start_location, $end_location, $carbon_emission){
        $this->profileID = $profileID;
        $this->datetime_stamp = $datetime_stamp;
        $this->start_location = $start_location;
        $this->end_location = $end_location;
        $this->carbon_emission = $carbon_emission;
    }

    public function getprofileID(){
        return $this->profileID;
    }
    public function getdatetime_stamp(){
        return $this->datetime_stamp;
    }
    public function getstart_location(){
        return $this->start_location;
    }
    public function getend_location(){
        return $this->end_location;
    }
    public function getcarbon_emission(){
        return $this->carbon_emission;
    }


//     profile_id INT NOT NULL AUTO_INCREMENT,
//   name VARCHAR(255) NOT NULL,
//   email VARCHAR(255) NOT NULL,
//   password VARCHAR(255) NOT NULL,
//   points INT NOT NULL DEFAULT 0,
//   address VARCHAR(255),
//   PRIMARY KEY (profile_id)

}