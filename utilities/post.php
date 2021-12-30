<?php

require_once 'db.php';

function add_post($title, $body, $public, $user_id)
{
    try {
        $db = db_connect();

        $insert_statement = "
        INSERT INTO blogpost (user_id, post_title, post_body, post_public)
        VALUES (:user_id, :post_title, :post_body, :post_public);
        ";


        $insert_statement = $db->prepare($insert_statement);
        $insert_statement->bindParam(":user_id", $user_id);
        $insert_statement->bindParam(":post_title", $title);
        $insert_statement->bindParam(":post_body", $body);
        $insert_statement->bindParam(":post_public", $public);
        $insert_statement->execute();
        return "INSERTED";
    } catch (PDOException $e) {
        return "ERROR";
    }
}

function get_user_posts($user_id)
{
    try {

        $db = db_connect();

        $select_statement = "
        SElECT * FROM blogpost WHERE user_id = :user_id;
        ";

        $select_statement = $db->prepare($select_statement);
        $select_statement->bindParam(":user_id", $user_id);

        $select_statement->execute();
        $posts = $select_statement->fetchAll(PDO::FETCH_ASSOC);

        return $posts;
    } catch (PDOException $e) {
        return "ERROR";
    }
}

function update_post($post_id, $post_title, $post_body, $post_check)
{
    try {
        $db = db_connect();
        $statement = "
        UPDATE blogpost SET post_title = :post_title, post_body = :post_body, post_public = :post_check WHERE post_id = :post_id;
        ";

        $statement = $db->prepare($statement);
        $statement->bindParam(":post_id", $post_id);
        $statement->bindParam(":post_title", $post_title);
        $statement->bindParam(":post_body", $post_body);
        $statement->bindParam(":post_check", $post_check);

        $statement->execute();

        return "UPDATED";
    } catch (PDOException $e) {
        return "ERROR";
    }
}
