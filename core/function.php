<?php
// error_reporting(0);
// ini_set('display_errors', 0);

require_once('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable("./");
$dotenv->load();

require_once('db/pdo.php');

function login($username, $password)
{
    global $conn;
    $sql = "SELECT * FROM user WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {

        session_start();

        $_SESSION['username'] = $result['username'];
        $_SESSION['password'] = $result['password'];
        $_SESSION['login'] = true;

        header("Location: dashboard/home.php?msg=success_login&" . $result['username'] . "");
    } else {
        header("Location: /?msg=error_login");
    }
}

function logout()
{
    session_start();

    $helper = array_keys($_SESSION);

    if ($helper) {
        foreach ($helper as $key) {
            unset($_SESSION[$key]);
        }
    }

    session_destroy();

    header("Location: /?msg=success_logout");
}
