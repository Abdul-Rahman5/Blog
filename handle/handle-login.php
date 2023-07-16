<?php
require_once "../inc/connection.php";
if (isset($_POST['submit'])) {
    $email = htmlspecialchars(trim( $_POST['email']));   
    $password = htmlspecialchars(trim( $_POST['password']));

    $erroes = [];
    if (empty($email)) {
        $erroes[] = "email is required";
    } elseif (! filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $erroes[] = "email not valid";
    } 
    if (empty($password)) {
        $erroes[] = "password is required";
    } elseif (strlen($password) < 6) {
        $erroes[] = "password less than 6 chars ";
    } 


if (empty($erroes)) {
        $query = "select * from users where email='$email'";
        $runQuery = mysqli_query($conn, $query);
        if (mysqli_num_rows($runQuery)==1) {
          $user=  mysqli_fetch_assoc($runQuery);

          $is_valid=  password_verify($password,$user['password']);

            if ($is_valid) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['success'] = ['Welcome user'];

                header("location: ../index.php");
                
            }else{
                $_SESSION['errors'] = ['credintials not correct '];
                header("location: ../login.php");
            }


         
        }else{
            $_SESSION['errors'] = ['this accoint not exist'];
            header("location: ../login.php");
        }




}else{
        $_SESSION['errors'] = $erroes;
        header("location: ../login.php");

}



}else{
    header("location: ../login.php");
}