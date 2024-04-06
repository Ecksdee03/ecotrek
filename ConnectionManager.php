<?php

    class ConnectionManager{
        public function getConnection(){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ecotrek";

            return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        }
    }







?>