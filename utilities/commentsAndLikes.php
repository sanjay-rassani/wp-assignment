<?php

function post_comment($comment_text, $post_id, $user_id)
{
    try {
        $db = db_connect();
        $statement = "
        INSERT INTO blogpostcomments (post_id, user_id, comment_text)
        VALUES (:post_id, :user_id, :comment_text);
        ";

        $statement = $db->prepare($statement);
        $statement->bindParam(":post_id", $post_id);
        $statement->bindParam(":user_id", $user_id);
        $statement->bindParam(":comment_text", $comment_text);
        $statement->execute();
        return "COMMENT_POSTED";
    } catch (PDOException $e) {
        return "ERROR";
    }
}

function get_post_by_id($post_id)
{
    try {
        $db = db_connect();

        $select_statment = "
        SELECT bp.post_title, bp.post_date, bp.post_body, bu.user_full_name 'user', 
        (SELECT COUNT(*) FROM BlogPostLikes WHERE post_id = bp.post_id) 'like', 
        (SELECT COUNT(*) FROM BlogPostReads WHERE post_id = bp.post_id) 'read'
        FROM blogpost bp
        JOIN user bu on bu.user_id = bp.user_id
        LEFT JOIN blogpostreads br on br.post_id = bp.post_id
        LEFT JOIN blogpostlikes bl on bl.post_id = bp.post_id
        WHERE bp.post_id = :post_id 
        ";

        $select_statment = $db->prepare($select_statment);
        $select_statment->bindParam(":post_id", $post_id);
        $select_statment->execute();
        $post =  $select_statment->fetch(PDO::FETCH_ASSOC);
        return $post;
    } catch (PDOException $e) {
        return "ERROR";
    }
}

function get_comments_by_id($post_id)
{
    try {
        $db = db_connect();
        $select = "
        SELECT bu.user_full_name, bc.comment_text
        FROM blogpostcomments bc
        JOIN user bu on bu.user_id = bc.user_id
        WHERE bc.post_id = :post_id
        ORDER BY bc.comment_date desc
        ";

        $select = $db->prepare($select);
        $select->bindParam(":post_id", $post_id);
        $select->execute();
        $result = $select->fetchAll();
        return $result;
    } catch (PDOException $e) {
        return "ERROR";
    }
}

function is_post_liked($post_id, $user_id)
{
    try {
        $db = db_connect();
        $statement = "
        SELECT count(*) FROM blogpostlikes WHERE user_id = :user_id AND post_id = :post_id;
        ";
        $statement = $db->prepare($statement);
        $statement->bindParam(':user_id', $user_id);
        $statement->bindParam(':post_id', $post_id);

        $statement->execute();
        $res = $statement->fetchColumn();
        // var_dump($res);
        // die();
        if ($res > "0") return 0;
        else return 1;
    } catch (PDOException $th) {
        return 'ERROR';
    }
}


function check_read($post_id, $user_id)
{
    try {
        $db = db_connect();
        $statement = "
        SELECT count(*) FROM blogpostreads WHERE user_id = :user_id AND post_id = :post_id;
        ";
        $statement = $db->prepare($statement);
        $statement->bindParam(':user_id', $user_id);
        $statement->bindParam(':post_id', $post_id);

        $statement->execute();
        $res = $statement->fetchColumn();
        if ($res > "0") return 0;
        else {
            // mark as read
            $statement = "
            INSERT INTO blogpostreads (user_id, post_id) VALUES (:user_id, :post_id);
            ";
            $statement = $db->prepare($statement);
            $statement->bindParam(':user_id', $user_id);
            $statement->bindParam(':post_id', $post_id);

            $statement->execute();
            return 1;
        };
    } catch (PDOException $th) {
        return 'ERROR';
    }
}

function toggle_like($post_id, $user_id, $isLiked)
{

    // $user_id = (int) $user_id;
    // $post_id = (int) $post_id;
    try {
        $db = db_connect();
        if ($isLiked != 0) {
            $statement = "
            DELETE FROM blogpostlikes WHERE user_id = $user_id && post_id = $post_id; 
            ";
            $statement = $db->prepare($statement);
            // $statement->bindParam(":user_id", $user_id);
            // $statement->bindParam(":post_id", $post_id);
            $statement->execute();
            return "DONE";
        } else {
            $statement = "
            INSERT INTO blogpostlikes (user_id, post_id) VALUES ($user_id, $post_id);
            ";
            $statement = $db->prepare($statement);
            // $statement->bindParam(":user_id", $user_id);
            // $statement->bindParam(":post_id", $post_id);
            $statement->execute();
            return "DONE";
        }
    } catch (PDOException $th) {
        return 'ERROR';
    }
}
