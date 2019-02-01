<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
$url = file_get_contents('php://input');

echo json_encode(getHttpStatus($url));


function getHttpStatus($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_TIMEOUT,10);
    $headers = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check if there's a Location: header (redirect)
    if (preg_match('/^Location: (.+)$/im', $headers, $matches)){
        $target = trim($matches[1]);
    } else {
        $target ="";
    }

    $values['url'] = $url;
    $values['status'] = $httpcode;
    $values['target'] = $target;

    return $values;
}

?>