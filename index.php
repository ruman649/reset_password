<?php
session_start();


include  "./php/connection.php";

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $pass = mysqli_real_escape_string($connection, $_POST['pass']);
    $cpass = mysqli_real_escape_string($connection, $_POST['cpass']);

    $select_mail_from_db = " select * from  user_table where email='$email' ";
    $query_of_selected_mail_form_db = mysqli_query($connection, $select_mail_from_db);
    $count_mail = mysqli_num_rows($query_of_selected_mail_form_db);

    if($count_mail){
        // $_SESSION['mail_exist'];
        echo "NO";
        header("location: index.php");
    }else{
        if($pass === $cpass){
            $incrypt_pass = password_hash($pass, PASSWORD_BCRYPT);
            $token = bin2hex(random_bytes(15));

            $insert_into_db = " insert into user_table (name, email, phone, pass, token, status) values ( '$name', '$email', '$phone', '$incrypt_pass', '$token', 'inactive')";
           
            $query_of_insert_into_db = mysqli_query($connection, $insert_into_db);
            
            if($query_of_insert_into_db){

                $sub = "activate Your Account";
                $body = "click this link for activate your account http://localhost:3000/php/activate.php?token=$token ";
                $from = "From: mruman649@gmail.com";

                   $mail =  mail($email, $sub, $body, $from);
                   if($mail){
                        $_SESSION['msg'] = "go to ~$email~ and click the link for activate your account";
                        header('location: php/login.php');
                   }
                   else{
                        echo "email not send some problems";
                   }
            }
            else{
                echo "data not inserted";
            }
            
        }
        else{
            echo "pass is not match";
        }
    }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registration</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->


    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/89726b4d6a.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


    <link rel="stylesheet" href="./style.css">

</head>

<body>



    <div class="container mt-3">

        <div class="card bg-light">
            <article class="card-body mx-auto" style="max-width: 400px;">
                <h4 class="card-title mt-3 text-center">Create Account</h4>
                <p class="text-center ">Create Account</p>
                <p>
                    <a href="" class="btn btn-block bg-danger "> Google</a>
                    <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i> Login via facebook</a>
                </p>
                <p class="divider-text">
                    <span class="bg-light">OR</span>
                </p>
                <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);  ?>">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input required name="name" class="form-control" placeholder="Full name" type="text">
                    </div> <!-- form-group// -->

                    <!-- <div class="mail-exist">
                        <p>
                            <?php
                                if(isset($_SESSION['mail_exist'])){
                                    echo "mail already exist! plz, choose onother mail";
                                }
                            ?>
                        </p>
                    </div> -->
                    <div class="form-group input-group">
                        
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        
                        <input required name="email" class="form-control" placeholder="Email address" type="email">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                        </div>
                        <input required name="phone" class="form-control" placeholder="Phone number" type="text">
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input required name="pass" class="form-control" placeholder="Create password" type="password">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input required name="cpass" class="form-control" placeholder="c peat password" type="password">
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-block"> Create Account </button>
                    </div> <!-- form-group// -->
                    <p class="text-center">Have an account? <a href="./php/login.php">Log In</a> </p>
                    <a href="./php/forget.php">Forget Password</a>
                </form>
            </article>
        </div> <!-- card.// -->

    </div>
    <!--container end.//-->





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>

</html>