<?php
date_default_timezone_set('America/Los_Angeles');

$servername = "localhost";
$username = "chongshu";
$password = "Shuchon1";
$dbname = "My_tracker";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//Get IP

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

//Get brwoser 
$brwoser = $_SERVER['HTTP_USER_AGENT'];

//Get redirect
$isp= gethostbyaddr($ip);

//get time and date
$time = date("H:i:s");
$date = date("Y-m-d");

// Insert to table
$sql = "INSERT INTO IP (Date,Time,IP,browser,redirect) VALUES ('$date', '$time','$ip', '$brwoser', '$isp')";

if (mysqli_query($conn, $sql)) {
  
} else {
 
}


//Mess up Louis   

//if (strpos($isp, 'msb-hoh112-lou') !== false) 
//{ 
//echo "<script type='text/javascript'>document.getElementById(\"wrap\").innerHTML= \"<center><b><div style='font\-size:36px\;margin-top:50px'>Got you!!<br/> <br/>lol <br/>redirecting... </div></b><center>\" </script>";
//echo "<script type='text/javascript'>window.setTimeout(function() {window.location.href='http://louis-yang.com';}, 2000);</script>";
//}




?>