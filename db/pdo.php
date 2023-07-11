<?php

$server = $_ENV['HOST_DB'];
$username = $_ENV['USER_DB'];
$password = $_ENV['PASSWORD_DB'];
$dbname = $_ENV['DATABASE_DB'];

try {
    $conn = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
