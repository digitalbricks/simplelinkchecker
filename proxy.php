<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
$url = file_get_contents('php://input');

echo json_encode(getHttpStatus($url));


function getHttpStatus($url){
    $status = doRequest($url);
    
    // if we got an redirect, follow until there is no redirect any more
    if($status['status'] == 302 OR $status['status'] == 301){
        $status_new = $status;
        while($status_new['status']==302 OR $status_new['status']==301){
            $status_new = doRequest($status_new['target']);
            $httpstatuscode = $status_new['status'];
            if($httpstatuscode==302 OR $httpstatuscode==301){
                $status['target'].=" <span class='inline-status code_{$httpstatuscode}'>{$httpstatuscode}</span> &rarr;<br />".$status_new['target'];
            } else {
                $status['target'].=" <span class='inline-status final-status code_{$httpstatuscode}'>{$httpstatuscode}</span>";
            }
            
        }
    }
    return $status;
}

function doRequest($url){
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