<?php
error_reporting(1);
ini_set('display_errors', 1);

require_once('vendor/autoload.php');

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

$dotenv = Dotenv\Dotenv::createImmutable("./");
$dotenv->load();


require_once('db/pdo.php');


function get_device()
{
    AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);
    $ua = $_SERVER['HTTP_USER_AGENT'];
    // $ua = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
    $dd = new DeviceDetector($ua);
    $dd->parse();
    return $dd->getDeviceName();
}

function secure_login($username, $password)
{
    global $conn;

    $sql = "SELECT iduser, username, password FROM user WHERE username = :username";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Generate a unique session token
            $sessionToken = bin2hex(random_bytes(32));

            // Start session (if not already started)
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user_id'] = $user['iduser'];

            if ($_ENV['ENVIRONMENT'] === 'development') {
                $domain = $_ENV['DOMAIN_DEV'];
                $domain = explode(":", $domain)[0];
            } else {
                $domain = $_ENV['DOMAIN_PROD'];
            }

            // Store session in database
            $sql = "INSERT INTO user_sessions (user_id, session_token, device_name, created_at, last_activity)
                    VALUES (:user_id, :session_token, :device_name, NOW(), NOW())";
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user_id', $user['iduser']);
                $stmt->bindParam(':session_token', $sessionToken);
                $stmt->bindParam(':device_name', get_device());
                $stmt->execute();

                // Set the session token as a secure, http-only cookie
                if ($_ENV['ENVIRONMENT'] === 'development') {
                    setcookie("session_token", $sessionToken, time() + (86400 * 30), "/", $domain, false, true);
                } else {
                    setcookie("session_token", $sessionToken, [
                        'expires' => time() + (86400 * 30),
                        'path' => '/',
                        'domain' => $domain,
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'Strict', // Nilai SameSite: 'Strict', 'Lax', atau 'None'
                    ]);
                }

                // Redirect to dashboard or wherever needed
                header("Location: dashboard/home.php?msg=success_login");
            } catch (PDOException $e) {
                // Handle database error
                header("Location: /?msg=database_error");
            }
        } else {
            header("Location: /?msg=" . urlencode($user['password']));
        }
    } catch (PDOException $e) {
        // Handle database error
        header("Location: /?msg=database_error");
    }
}



function change_password($user_id, $new_password)
{
    global $conn;

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password = :password WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

function verify_session()
{
    global $conn;

    if (isset($_COOKIE['session_token'])) {
        $sessionToken = $_COOKIE['session_token'];

        $sql = "SELECT user_id FROM user_sessions WHERE session_token = :session_token";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':session_token', $sessionToken);
        $stmt->execute();
        $session = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($session) {
            // Update last_activity timestamp
            $sql = "UPDATE user_sessions SET last_activity = NOW() WHERE session_token = :session_token";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':session_token', $sessionToken);
            $stmt->execute();

            return $session['user_id'];
        }
    }
    return false;
}

function register_user($username, $password)
{
    global $conn;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();
}

function logout()
{
    global $conn;

    session_start();

    if (isset($_COOKIE['session_token'])) {
        $sessionToken = $_COOKIE['session_token'];

        $sql = "DELETE FROM user_sessions WHERE session_token = :session_token";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':session_token', $sessionToken);
        $stmt->execute();


        if ($_ENV['ENVIRONMENT'] === 'development') {
            $domain = $_ENV['DOMAIN_DEV'];
            $domain = explode(":", $domain)[0];
        } else {
            $domain = $_ENV['DOMAIN_PROD'];
        }

        // Clear cookie
        if ($_ENV['ENVIRONMENT'] === 'development') {
            setcookie("session_token", "", time() - 3600, "/", $domain, false, true);
        } else {
            setcookie("session_token", "", [
                'expires' =>  time() - 3600,
                'path' => '/',
                'domain' => $domain,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict', // Nilai SameSite: 'Strict', 'Lax', atau 'None'
            ]);
        }

        //Php session destroy
        session_destroy();
    }
    // Redirect to login page
    header("Location: /?msg=success_logout");
}
