<?php
session_start();
require_once './utilities/post.php';
require_once './utilities/db.php';

if (isset($_SESSION['_user'])) {
    $user_id = $_SESSION['_user']['user_id'];
    $user_posts = get_user_posts($user_id);
} else {
    header('Location: index.php');
}

if (isset($_POST['edit-post'])) {
}

if (isset($_POST['delete-post'])) {
    $db = db_connect();

    $post_id = $_POST['post-id'];

    $delete_statement = "
    DELETE FROM blogpost WHERE post_id = :post_id
    ";

    $delete_statement = $db->prepare($delete_statement);
    $delete_statement->bindParam(":post_id", $post_id);

    $delete_statement->execute();
    header("Location: viewposts.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
</head>

<body>
    <?php require_once 'header.php'; ?>

    <div class="container">


        <?php if (isset($user_posts) && sizeof($user_posts) > 0) : ?>
            <?php foreach ($user_posts as $key => $value) : ?>
                <div class="m-3 bg-light">
                    <h2><?= $value['post_title']  ?></h2>
                    <p><?= $value['post_body']  ?></p>
                    <div class="row">
                        <div class="col">
                            <form action="" method="post">
                                <input type="text" name="post-id" value="<?= $value['post_id'] ?>" hidden>
                                <input type="submit" name="delete-post" value="Delete" class="btn btn-danger btn-sm">
                            </form>
                        </div>
                        <div class="col">
                            <form action="editpost.php" method="get">
                                <input type="text" name="post-id" value="<?= $value['post_id'] ?>" hidden>
                                <input type="submit" value=" ✎ Edit post here" class="btn btn-link link-primary">
                            </form>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>

        <?php else : ?>
            <div class="bg-light w-80 m-4">
                <h5 class="h5">No Blog Posted Yet! <a href="./addpost.php"> Click here to add first blog! </a></h5>
            </div>
        <?php endif ?>



    </div>
</body>

</html>