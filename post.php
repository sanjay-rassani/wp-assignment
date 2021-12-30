<?php
session_start();
$user = $_SESSION['_user'];

require_once './utilities/db.php';
require_once './utilities/commentsAndLikes.php';


if (isset($_POST['post-comment'])) {
    $comment_text = $_POST['comment-text'];
    $post_id = $_GET['id'];
    $user_id = $user['user_id'];
    $res = post_comment($comment_text, $post_id, $user_id);
    if ($res == 'ERROR') {
        die();
    }
}

$post_id = $_GET['id'];
$user_id = $user['user_id'];
$isLiked = is_post_liked($post_id, $user_id);

$is_post_read = check_read($post_id, $user_id);

$post = get_post_by_id($post_id);

$post_title = $post['post_title'];
$post_body = $post['post_body'];
$author = $post['user'];
$reads = $post['read'];
$likes = $post['like'];
$post_date = $post['post_date']; //String object
$post_date = date_create($post_date); // DateTime object
$post_date = date_format($post_date, "jS, F, Y.");
$comments = get_comments_by_id($post_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    <style>
        #avatar {
            background-color: aliceblue;
            border-radius: 50%;
            align-items: center;
            font-size: 5vh;
            text-align: center;
        }
    </style>
</head>

<body>

    <?php require_once 'header.php' ?>

    <div class="bg-light m-3">
        <div class="card-body">
            <h4 class="card-title m-5 text-center display-4"><?= $post_title ?></h4>
            <div class="container">
                <div class="row border-bottom">
                    <span class="col card-subtitle text-center text-muted mb-2">By <?= $author ?></span>
                    <span class="col card-subtitle text-center text-muted mb-2"> Posted on: <?= $post_date ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $post_body ?>
                    </div>
                </div>
                <div class="row border-top mt-2">
                    <div class="col text-center">
                        <?php if ($isLiked != 0) : ?>
                            <a href="togglelike.php?post_id=<?= $post_id . '&user_id=' . $user_id . '&isLiked=0' ?>">Like</a>
                        <?php else : ?>
                            <a href="togglelike.php?post_id=<?= $post_id . '&user_id=' . $user_id . '&isLiked=1' ?>">DisLike</a>
                        <?php endif ?>
                    </div>
                    <div class="col text-center">
                        <?php if ($likes > 0) : ?>
                            <a href="postlikes.php?id=<?= $post_id ?>">
                            <?php endif; ?>
                            <span><?= $likes ?> Likes</span>
                            <?php if ($likes > 0) : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="col text-center">
                        <?php if ($reads > 0) : ?>
                            <a href="postreads.php?id=<?= $post_id ?>">
                            <?php endif; ?>
                            <span><?= $reads ?> Reads</span>
                            <?php if ($reads > 0) : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <!-- add comment -->
                    <div class="card">
                        <form method="POST" class="row">
                            <div class="col-11">
                                <textarea name="comment-text" class="w-100"></textarea>
                            </div>
                            <div class="col-1">
                                <input type="submit" name='post-comment' class="btn btn-info btn-sm h-100 w-100" value="Comment">
                            </div>
                        </form>
                    </div>
                    <!-- read comment -->
                    <?php foreach ($comments as $comment) : ?>
                        <div class="card">
                            <div class="row">
                                <div class="col-1">
                                    <div id="avatar">
                                        <?= substr($comment['user_full_name'], 0, 1) ?>
                                    </div>
                                </div>
                                <div class="col-11 ml-auto">
                                    <textarea class="w-100" disabled><?= $comment['comment_text'] ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>