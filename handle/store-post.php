<?php
require_once "../inc/connection.php";
if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
}

if (isset($_POST['submit'])) {

   $user_id= $_SESSION['user_id'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $errors = [];

    if (empty($title)) {
        $errors[] = "Your title is required ";
    } elseif (is_numeric($title)) {
        $errors[] = "Your title must be string";
    } elseif (strlen($title)< 2) {
        $errors[] = "Your title less than 2 chars ";
    }
    if (empty($body)) {
        $errors[] = "Your body is required ";
    } elseif (is_numeric($body)) {
        $errors[] = "Your body must be string";
    }

    if (!empty($_FILES['image']['name'])) {
        $iamge = $_FILES['image'];
        $name = $iamge['name'];
        $tmpName = $iamge['tmp_name'];
        $size = $iamge['size'] / (1024 * 1024);
        $error = $iamge['error'];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $newName = uniqid() . "." . $ext;


        $arr = ["png", "jpg", "jpeg", "gif"];
        if ($error != 0) {
            $errors[] = "image not found";
        } elseif ($size > 1) {
            $errors[] = "image large size";
        } elseif (!in_array($ext, $arr)) {
            $errors[] = "image not correct";
        }
    } else {
        $newName = null;
    }

    if (empty($errors)) {
        $query = "INSERT INTO posts(`title`,`body`,`image`, `user_id`)values('$title','$body','$newName',$user_id)";
        $runQuery = mysqli_query($conn, $query);
        if ($runQuery) {
            

        if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($tmpName, "../uploads/$newName");

        }
        $_SESSION['success'] = ["post inserted successfuly"];
        header("location: ../index.php");
        }else{
            $_SESSION['errors'] = ['error'];
            $_SESSION['title'] = $title;
            $_SESSION['body '] = $body;
    header( "location: ../create-post.php");

        }

    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['title'] = $title;
        $_SESSION['body '] = $body;
        header("location: ../create-post.php");
    }
} else {
    header("location: ../create-post.php");
}
