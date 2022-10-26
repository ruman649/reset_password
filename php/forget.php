<?php
session_start();
include 'connection.php';

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $select_mail_from_db = " select * from user_table where email='$email' " ;
    $query_selected = mysqli_query($connection, $select_mail_from_db);

    if($query_selected){
        $array_data = mysqli_fetch_assoc($query_selected);
        $token = $array_data['token'];

        $to = $email;
        $sub = "Recover Passsword!";
        $body = "Click This link for reset your password and set new password http://localhost:3000/php/forget_action.php?token=$token ";
        $from = "From: mruman649@gmail.com";
        if(mail($to, $sub, $body, $from)){
            ?>
                <p style="color:white; background:green; padding:10px;"><?php echo "go to $email and click the link for reset the password" ?></p>
            <?php
        }
        else{
            echo "mail not send";
        }
    }
    else{
        echo "email is not match";   
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forget password?</title>
</head>
<body style="text-align:center">
    <p>Enter Your email :</p>
    <form action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="text" placeholder="Enter Your Email" name="email" id=""><br><br>
        <input type="submit" value="submit" name="submit">
    </form>
</body>
</html>