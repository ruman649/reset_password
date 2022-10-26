<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "user_reset_pass";

$connection = mysqli_connect($host, $user, $pass, $db_name);
if(!$connection){
    die(mysqli_connect_error());
}

?>