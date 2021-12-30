<?php
session_start();
if (isset($_SESSION['_user'])) {
} else {
    header('Location: index.php');
}

if (isset($_POST['post-title'])) {
    $post_title = $_POST['post-title'];
    $post_body = $_POST['post-body'];
    $post_check = isset($_POST['post-check']) && $_POST['post-check'] == 'on' ? 1 : 0;

    require_once './utilities/post.php';

    $user_id = $_SESSION['_user']['user_id'];

    $res = add_post($post_title, $post_body, $post_check, $user_id);
    if ($res == "INSERTED") {
        echo "
        <script>
        alert('Post Added');
        </script>
        ";
        header("Location: home.php");
    } else {
        echo "
        <script>
        alert('Error!');
        </script>
        ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
</head>

<body>

    <?php require_once 'header.php'; ?>

    <form action="" method="post" class="m-3">
        <div class="mb-3">
            <label for="post-title" class="form-label">Post Title</label>
            <input type="text" class="form-control" name="post-title" required>
        </div>
        <div class="mb-3">
            <label for="post-body" class="form-label">Post Body</label>
            <textarea type="text" class="form-control" name="post-body" required></textarea>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="post-check">
            <label for="post-check" class="form-label">Publish</label>
        </div>
        <button class="btn btn-primary" size='sm'>Post</button>
    </form>

</body>

</html>