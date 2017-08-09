<?php

//darkweather key
$key = 'AIzaSyBZ1uw7HMAGXG01-1sd3tkmFxlTqXeU7a8';


//geocode
$base_url = 'https://maps.googleapis.com/maps/api/geocode/json?;

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $base_url.'address='.$location.'='.$key');
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す


$response = curl_exec($curl);
$result = json_decode($response, true);

curl_close($curl);
?>