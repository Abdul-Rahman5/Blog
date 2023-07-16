<?php require_once('inc/header.php'); ?>
<?php require_once('inc/navbar.php'); ?>
<?php require_once('inc/connection.php'); ?>
<?php
if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qurey = "SELECT * from posts where id=$id ";
    $runQuery = mysqli_query($conn, $qurey);
    if (mysqli_num_rows($runQuery) == 1) {
        $post =  mysqli_fetch_assoc($runQuery);
    } else {
        $msg = "Post not found";
    }
} else {
    header("location: index.php");
}


?>

<div class="container-fluid pt-4">
    <div class="row text-center">

        <?php if (!empty($post)) : ?>
            <div class="col-md-10 offset-md-1">
                <div class="d-flex justify-content-between border-bottom mb-5">
                    <div>
                        <h3 class="lead fs-1"><?php echo $post['title'] ?> </h3>
                    </div>

                    <div>
                        <a href="index.php" class="text-decoration-none"><?php echo $msg['Back'] ?></a>
                    </div>
                </div>
                <?php require_once "inc/updated.php" ?>

                <div>
                    <img src="uploads/<?php echo $post['image'] ?>" alt="" class="w-25 rounded-3">
                </div>
                <div class="lead mt-3">
                    <?php echo $post['body'] ?>
                </div>

            </div>
        <?php else :
            echo $msg;
        endif ?>
    </div>
</div>

<?php require('inc/footer.php'); ?>