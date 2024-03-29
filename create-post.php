<?php require_once('inc/header.php'); ?>
<?php require_once('inc/navbar.php'); ?>
<?php

if (!isset($_SESSION['user_id'])) {
    header("location: ../login.php");
}

?>
<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3><?php echo $msg['Add new post'] ?></h3>
                </div>
                <div>
                    <a href="index.php" class="text-decoration-none"><?php echo $msg['Back'] ?></a>
                </div>
            </div>

            <?php require_once "./inc/errors.php"; ?>

            <form method="POST" action="handle/store-post.php" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="title" class="form-label"><?php echo $msg['Title'] ?></label>
                    <input type="text" class="form-control" value="<?php if (!empty($_SESSION['title']))
                                                                        echo $_SESSION['title'];
                                                                    unset($_SESSION['title'])  ?>" id="title" name="title">
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label"><?php echo $msg['body'] ?></label>
                    <textarea class="form-control" id="body" name="body" rows="5"><?php if (!empty($_SESSION['body ']))  echo $_SESSION['body '];
                                                                                    unset($_SESSION['body'])  ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label"><?php echo $msg['image'] ?></label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary" name="submit"><?php echo $msg['Submit'] ?></button>
            </form>
        </div>
    </div>
</div>

<?php require('inc/footer.php'); ?>