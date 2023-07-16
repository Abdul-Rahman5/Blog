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
        $_SESSION['errors'] = ['post not found'];
        header("location: index.php");
    }
} else {
    header("location: index.php");
}


?>




<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?php require_once "./inc/errors.php"; ?>

            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3><?php echo $msg['Edit post'] ?></h3>
                </div>
                <div>
                    <a href="index.php" class="text-decoration-none"><?php echo $msg['Back'] ?></a>
                </div>
            </div>
            <form method="POST" action="handle/update-post.php?id=<?php echo $id ?>" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="title" class="form-label"><?php echo $msg['Title'] ?></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $post['title'];
                                                                                            unset($post['title']) ?>">
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label"><?php echo $msg['body'] ?></label>
                    <textarea class="form-control" id="body" name="body" rows="5"><?php echo $post['body']; ?></textarea>
                </div>
                <div class="mb-3">
                    <img class="w-25" src="uploads/<?php echo $post['image'] ?>" alt="">

                </div>
                <div class="mb-3">
                    <label for="body" class="form-label"><?php echo $msg['image'] ?></label>
                    <input type="file" class="form-control-file" id="image" value="testone" name="image">


                </div>
                <button type="submit" class="btn btn-primary" name="submit"><?php echo $msg['Submit'] ?></button>
            </form>
        </div>
    </div>
</div>

<?php require('inc/footer.php'); ?>