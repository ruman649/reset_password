<?php
session_start();
include 'connection.php';


if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $pass = mysqli_real_escape_string($connection, $_POST['pass']);


    $match_mail = " select * from user_table where email='$email' and status='active' ";
    $queary_of_match_mail = mysqli_query($connection, $match_mail);

    $count_mail = mysqli_num_rows($queary_of_match_mail);

    if($count_mail){
        $array_of_data = mysqli_fetch_assoc($queary_of_match_mail);
        $db_pass = $array_of_data['pass'];
        $match_pass = password_verify($pass, $db_pass);
        
        if($match_pass){
            $checked = $_POST['checked'];
            if($checked){
                setcookie('user_email', $email, time()+86400);
                setcookie('user_pass', $pass, time()+86400);
                setcookie('user_check', $checked, time()+86400);
            }
            else{
                setcookie('user_email', $email, time()-86400);
                setcookie('user_pass', $pass, time()-86400);
                setcookie('user_check', $checked, time()-86400);    
            }
            header("location: ../home.php");
        }else{
            echo "password is not match";
        }

    }
    else{
        echo "mail not exist and maybe you did not active your account";
    }


}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->


    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/89726b4d6a.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


    <link rel="stylesheet" href="../style.css">

</head>

<body>

    <div class="container mt-3">
        <div class="card bg-light">
            <article class="card-body mx-auto" style="max-width: 400px;">
                <h4 class="card-title mt-3 text-center">log in</h4>
                <p>
                    <a href="" class="btn btn-block bg-danger text-white"><i class="fab fa-google "></i> Google</a>
                    <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i> Login via facebook</a>
                </p>
                <p class="divider-text">
                    <span class="bg-light">OR</span>
                </p>

                <div class="">
                    <?php
                        if(isset($_SESSION['msg'])){
                            ?>
                            <p style="color:white; background:green; padding:10px">
                                <?php
                                echo $_SESSION['msg'];
                                ?>
                            </p>
                            <?php
                        }
                    ?>
                </div>

                <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input required name="email" class="form-control" placeholder="Email address" type="email" value="<?php 
                            if(isset($_COOKIE['user_email'])){
                                echo $_COOKIE['user_email'];
                            }
                        ?>">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input required name="pass" class="form-control" placeholder="Create password" type="password" value="<?php 
                            if(isset($_COOKIE['user_pass'])){
                                echo $_COOKIE['user_pass'];
                            }
                        ?>">
                    </div> <!-- form-group// -->
                    <label class="container">
                        <input type="checkbox" name="checked" <?php 
                            if(isset($_COOKIE['user_check'])){
                                echo "checked";
                            } 
                        ?>>
                        <span class="checkmark">Remember Me</span>
                    </label>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-block"> Log In </button>
                    </div> <!-- form-group// -->
                    <p class="text-center"> New user? <a href="index.php">Registration First</a> </p>
                    <a href="forget.php">Forget Password</a>
                </form>
            </article>
        </div> <!-- card.// -->

    </div>
    <!--container end.//-->





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>

</html>