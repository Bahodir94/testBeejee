<?php
class dbconnect{
    public function connect(){
         $host = 'localhost';
         $user = 'root';
         $pass = 'root';
         $db = 'test_beeje';
         $connection = mysqli_connect($host,$user,$pass,$db); 
         return $connection;
     }
}