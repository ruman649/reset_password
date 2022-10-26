<?php

session_start();
include "connection.php";


if (isset($_GET['token'])) {
$token = $_GET['token'];
$_SESSION['token'] = $token;
}


if (isset($_POST['submit'])) {
    $pass = mysqli_real_escape_string($connection, $_POST['pass']);
    $cpass = mysqli_real_escape_string($connection, $_POST['cpass']);
    
    if ($pass === $cpass) {
        $token =  $_SESSION['token'];
        $pass_incrypt = password_hash($pass, PASSWORD_BCRYPT);
            $update = " update user_table set pass='$pass_incrypt' where token='$token' ";
            $query_updated = mysqli_query($connection, $update);

            if ($query_updated) {
                $_SESSION['msg'] = 'Your password Updated! Now, Your can login';
                header("location: login.php");
            } else {
                echo "some problem occured! data cant updated";
            }

        } else {
            echo "Password and Confirm Password are not matching";
        }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reset password</title>
</head>

<body style="text-align:center">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="text" placeholder="New Password" name="pass" id=""><br><br>
        <input type="text" name="cpass" id="" placeholder="Confirm New Password"><br><br>
        <input type="submit" value="submit" name="submit">
    </form>
</body>

</html>