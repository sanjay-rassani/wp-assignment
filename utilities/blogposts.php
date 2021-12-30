<?php
require_once 'db.php';

function get_all_posts()
{
    try {
        $db_connection = db_connect();

        $select_statment = "
        SELECT DISTINCT b.post_id, b.user_id, post_title, SUBSTRING(post_body, 1, 150) as post_body, post_date, user_full_name, 
        (SELECT COUNT(*) FROM BlogPostLikes WHERE post_id = b.post_id) as likes, 
        (SELECT COUNT(*) FROM BlogPostReads WHERE post_id = b.post_id) as _reads,
        (SELECT COUNT(*) FROM BlogPostComments WHERE post_id = b.post_id) as _comments
        FROM BlogPost b JOIN User u ON b.user_id = u.user_id 
        LEFT JOIN BlogPostLikes bl on bl.post_id=b.post_id 
        LEFT JOIN BlogPostReads br on br.post_id=b.post_id 
        LEFT JOIN BlogPostComments bc on bc.post_id=b.post_id
        WHERE b.post_public = 1";

        $select_statment = $db_connection->prepare($select_statment);

        $select_statment->execute();
        $blogposts = $select_statment->fetchAll(PDO::FETCH_ASSOC);

        return !empty($blogposts) ? $blogposts : null;
    } catch (PDOException $e) {
        var_dump($e);
        return null;
    }
}

function get_users_who_like($post_id)
{
    $select_statment = "
        SELECT u.user_full_name FROM BlogPostLikes b JOIN User u ON b.user_id = u.user_id WHERE post_id = :post_id;";

    return get_users($post_id, $select_statment);
}

function get_users_who_read($post_id)
{
    $select_statment = "
        SELECT u.user_full_name FROM BlogPostReads b JOIN User u ON b.user_id = u.user_id WHERE post_id = :post_id;";

    return get_users($post_id, $select_statment);
}

function get_users_who_comment($post_id)
{
    $select_statment = "
        SELECT u.user_full_name FROM BlogPostComments b JOIN User u ON b.user_id = u.user_id WHERE post_id = :post_id;";

    return get_users($post_id, $select_statment);
}

function get_users_who_are_followed($user_id)
{
    $select_statment = "
        SELECT u.user_full_name FROM UserFollower b  JOIN User u ON b.follower_id = u.user_id WHERE u.user_id != :post_id;";

    return get_users($user_id, $select_statment);
}

function get_users($post_id, $select_statment)
{
    try {
        $db_connection = db_connect();

        // $select_statment = "
        // SELECT u.user_full_name FROM :table b JOIN User u ON b.user_id = u.user_id WHERE post_id = :post_id;";

        $select_statment = $db_connection->prepare($select_statment);

        // $select_statment->bindParam(":table", $table);
        $select_statment->bindParam(":post_id", $post_id);

        // var_dump($select_statment->execute());
        $select_statment->execute();
        $users = $select_statment->fetchAll(PDO::FETCH_ASSOC);

        return !empty($users) ? $users : null;
    } catch (PDOException $e) {
        var_dump($e);
        return null;
    }
}
