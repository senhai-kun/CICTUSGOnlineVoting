<?php
    
    date_default_timezone_set('Asia/Manila');
    $date = date('Y-m-d H:i:s');
    
    $url='localhost';
    $username='root';
    $password='';
    $dbname="votingsystem_db";

    $conn = new mysqli($url,$username,$password,$dbname);
    if($conn->connect_error){
        die('Failed to connect ' .$conn->connect_error);
    }
?>
