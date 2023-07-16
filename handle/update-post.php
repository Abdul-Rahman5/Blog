<?php
require_once "../inc/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['submit'])) {
    
    $title = htmlspecialchars(trim( $_POST['title']));
    $body = htmlspecialchars(trim($_POST['body']));

    $id = $_GET['id'];
    $qurey = "SELECT * from posts where id=$id ";
    
    $runQuery = mysqli_query($conn, $qurey);
    if (mysqli_num_rows($runQuery) == 1) {
        $post =  mysqli_fetch_assoc($runQuery);
        $oldImage = $post['image'];
    } else{
            $_SESSION['updated'] = ["post not found"];
            header("location: ../index.php");
    }

    $errors = [];

    if (empty($title)) {
        $errors[] = "Your title is required ";
    } elseif (is_numeric($title)) {
        $errors[] = "Your title must be string";
    } elseif (strlen($title) < 2) {
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
        $newName = $oldImage;
    }

    if (empty($errors)) {
        $query = "update  posts set  `title`='$title',`body`='$body',`image`='$newName' where id=$id";
        $runQuery = mysqli_query($conn, $query);
        if ($runQuery) {
            if (!empty($_FILES['image']['name'])) {
                unlink("../uploads/$oldImage");
                move_uploaded_file($tmpName, "../uploads/$newName");

            }   
            $_SESSION['updated'] =  ["post updated successfuly"];
            header("location: ../show-post.php?id=$id");
        } else {
            $_SESSION['errors'] = ['error while update'];
            header("location: ../edit-post.php");
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("location: ../edit-post.php?id=$id");
    }
    } else {
        header("location: ../edit-post.php?id=$id");
    }
} else {
    header("location: ../index.php");
}

