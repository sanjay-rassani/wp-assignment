<?php

require_once 'config.php';

try {
    $db_connection = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);
    $db_connection->exec("DROP DATABASE " . DB_NAME);
    echo "<h1>Unistalled.</h1>";
} catch (PDOException $e) {
    echo "<h1>No db found!</h1>";
}
