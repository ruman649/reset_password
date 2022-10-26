<?php
session_start();
include 'connection.php';

if(isset($_GET['token'])){
    $token = $_GET['token'];

    $select_data = " select * from user_table where token='$token' ";
    $selected_data = mysqli_query($connection, $select_data);

    $array_data = mysqli_fetch_assoc($selected_data);

    $update = " update user_table set status='active' where token='$token' ";
    $updated = mysqli_query($connection, $update);

    if($updated){
        $_SESSION['msg'] = 'Account has been updated';
        header('location: login.php');
    }
    else{
        echo 'some problem occunr';
    }


}


?>