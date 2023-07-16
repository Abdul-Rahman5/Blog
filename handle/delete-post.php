<?php
require_once "../inc/connection.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qurey = "SELECT * from posts where id=$id ";
    $runQuery = mysqli_query($conn, $qurey);
    if (mysqli_num_rows($runQuery) == 1) {
        $post =  mysqli_fetch_assoc($runQuery);
        $image = $post['image'];
        unlink("../uploads/$image");
        
        $qurey = "delete from posts where id=$id";
      $runQuery=  mysqli_query($conn, $qurey);
      if ($runQuery) {
            $_SESSION['delete'] = 'post deleted succssfuly';
    header( "location: ../index.php");

      }else{
            $_SESSION['delete'] = ['error while deleting'];
            header("location: ../index.php");

      }

    } else {
        $msg = "Post not found";
    }
} else {
    header("location: ../index.php");
}
