<?php
session_start();

if (!isset($_GET['user_id'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
}

$user = $_SESSION['_user'];

$user_id = $user['user_id'];
$user_likes = $user['user_likes'];
$user_reads = $user['user_reads'];
$user_comments = $user['user_comments'];
$user_follows = $user['user_follows'];
$user_posts = $user['user_posts'];
$user_full_name = $user['user_full_name'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css">
    <title><?= $user['user_full_name'] ?> | Profile </title>
</head>

<body>

    <?php include "header.php"; ?>

    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center"><?= $user_full_name ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Posts</td>
                            <td>
                                <a href="viewposts.php?user_id=<?= $user_id ?>">
                                    <?= $user_posts ?> View
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Likes</td>
                            <td><?= $user_likes ?></td>
                        </tr>
                        <tr>
                            <td>Reads</td>
                            <td><?= $user_reads ?></td>
                        </tr>
                        <tr>
                            <td>Comments</td>
                            <td><?= $user_comments ?></td>
                        </tr>
                        <tr>
                            <td>Following</td>
                            <td>
                                <a href="userfollowing.php?user_id=<?= $user_id ?>">
                                    <?= $user_follows ?> View
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>