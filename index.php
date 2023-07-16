<?php require_once('inc/header.php'); ?>
<?php require_once('inc/navbar.php'); ?>
<?php require_once('inc/connection.php'); ?>
<?php
if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
}


if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
} else {
    $page = 1;
}

$limit = 2;
$offset = ($page - 1) * $limit;
$query = "select  count(id)as total from posts";
$runQuery = mysqli_query($conn, $query);
if (mysqli_num_rows($runQuery) == 1) {
    $post = mysqli_fetch_assoc($runQuery);
    $total = $post['total'];
}

$numberOfPagr = ceil($total / $limit);
if ($page < 1 || $page > $numberOfPagr) {
    header("location" . $_SERVER["PHP_SELF"] . "?page=1");
}
$query = "select id , title,created_at from posts limit $limit offset $offset";
$runQuery = mysqli_query($conn, $query);
if (mysqli_num_rows($runQuery) > 0) {
    $posts =   mysqli_fetch_all($runQuery, MYSQLI_ASSOC);
} else {
    $msgs = "Not  post founded";
}

?>

<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3 class="lead fs-2 "><?php echo $msg['All posts'] ?></h3>
                </div>
                <div>
                    <a href="create-post.php" class="btn btn-sm btn-success"><?php echo $msg['Add new post'] ?></a>
                </div>
            </div>
            <?php require_once "inc/success.php" ?>
            <?php require_once "inc/delete.php" ?>

            <?php if (!empty($posts)) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo $msg['Title'] ?></th>
                            <th scope="col"><?php echo $msg['Published At'] ?></th>
                            <th scope="col"><?php echo $msg['Actions'] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post) : ?>
                            <tr>
                                <td><?php echo $post['title'] ?> </td>
                                <td><?php echo $post['created_at'] ?></td>
                                <td>
                                    <a href="show-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-primary"><?php echo $msg['show'] ?></a>
                                    <a href="edit-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-secondary"><?php echo $msg['edit'] ?></a>
                                    <a href="handle/delete-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('do you really want to delete post?')"><?php echo $msg['Delete'] ?></a>
                                </td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
            <?php else :
                echo $msgs;
            endif ?>
        </div>
    </div>
</div>

<div class="container d-flex justify-content-center mt-5">


    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?php if ($page == 1) echo "disabled" ?>">
                <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only"></span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#"><?php echo $page ?> <?php echo $msg['OF'] ?> <?php echo $numberOfPagr ?> </a></li>
            <li class="page-item <?php if ($page == $numberOfPagr) echo "disabled" ?>">
                <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $page + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only"></span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php require('inc/footer.php'); ?>