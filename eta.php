

<?php
$USCtoHome= "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=34.018833,%20-118.285781&destinations=34.239166,%20-118.229774&key=AIzaSyCAcuoyKIQDdHK8ugKufKpIiQYa7taO_zQ";

function GetDrivingDistance($lat1, $long1, $lat2, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&key=AIzaSyCAcuoyKIQDdHK8ugKufKpIiQYa7taO_zQ";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
    return array('distance' => $dist, 'time' => $time);
}

    $dist = GetDrivingDistance("34.018833", "-118.285781",  "34.239166", "-118.229774");
    echo 'Distance: <b>'.$dist['distance'].'</b><br>Travel time duration: <b>'.$dist['time'].'</b>'; 
    
    

?>