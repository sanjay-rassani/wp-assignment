<?php
require_once './utilities/db.php';
require_once './utilities/commentsAndLikes.php';


$post_id = $_GET['post_id'];
$user_id = $_GET['user_id'];
$isLiked = $_GET['isLiked'];

$check = toggle_like($post_id, $user_id, $isLiked);

header('Location: post.php?id=' . $post_id);
