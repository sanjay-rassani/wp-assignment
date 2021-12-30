<?php
session_start();
if (isset($_SESSION['_user'])) {
} else {
    header('Location: index.php');
}

require_once './utilities/db.php';
require_once './utilities/post.php';

if (isset($_POST['update-post'])) {
    $post_id = $_GET['post-id'];
    $post_title = $_POST['post-title'];
    $post_body = $_POST['post-body'];
    $post_check = $_POST['post-check'] == 'on' ? 1 : 0;

    $res = update_post($post_id, $post_title, $post_body, $post_check);
    if ($res == "UPDATED") {
        header('Location: post.php?id=' . $post_id);
    }
}


if (isset($_GET['post-id'])) {
    $db = db_connect();

    $select_statement = "
    SELECT * FROM blogpost WHERE post_id = :post_id;
    ";

    $post_id = $_GET['post-id'];

    $select_statement = $db->prepare($select_statement);
    $select_statement->bindParam(':post_id', $post_id);

    $select_statement->execute();
    $post = $select_statement->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>

<body>
    <?php require_once 'header.php' ?>
    <div class="container">
        <p class="display-4 text-center">Edit Post</p>

        <form action="" method="post" class="m-3">
            <div class="mb-3">
                <label for="post-title" class="form-label h4">Post Title</label>
                <input type="text" class="form-control" value='<?= ($post['post_title']) ?>' name="post-title" required>
            </div>
            <div class="mb-3">
                <label for="post-body" class="form-label h4">Post Body</label>
                <textarea rows="10" type="text" class="form-control" name="post-body" value='<?= ($post['post_body']) ?>' required><?= ($post['post_body']) ?></textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="post-check" <?= $post['post_public'] == '1'  ? 'checked' : '' ?>>
                <label for="post-check" class="form-label">Publish</label>
            </div>
            <button class="btn btn-primary" name="update-post" size='sm'>UPDATE</button>
        </form>
    </div>
</body>

</html>