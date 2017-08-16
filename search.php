<?php

ini_set( 'display_errors', 1 );

$accessToken = '+O9PZhDDNsc1w33rE7/U949xa8I7P9uxUShSGR9LFbABjQrYKo3p+xffPlfDfQu/AjIddjC9DtzyYXiA62fCBgF9ElS0gw4i8tK8E3F9RaspQGrcuSYMati25NRNxMOArqUBvqh6mFWj/Jul/9CPbQdB04t89/1O/w1cDnyilFU=';

$jsonString = file_get_contents('php://input');
error_log($jsonString);
$jsonObj = json_decode($jsonString);

$message = $jsonObj->{"events"}[0]->{"message"};
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};


$loca = jsonObj->{"events"}[0]->{"location"};
$city = jsonObj->{"events"}[0]->{"city"};

//if{$message->{"text"} =='weather'}{

//require_once 'geo.php';
require_once 'weather.php';
//};
$messageData = $phpObj;

$response = [
    'replyToken' => $replyToken,
    'messages' => [$messageData]
];
error_log(json_encode($response));

$ch = curl_init('https://api.line.me/v2/bot/message/reply');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
));
$result = curl_exec($ch);
error_log($result);
curl_close($ch);
?>

