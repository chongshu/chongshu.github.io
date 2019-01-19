<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<meta name="robots" content="noindex" />
</head>
<style>
table, th, td {
   border: 1px solid black;
}

tr:nth-child(even){background-color: #f2f2f2}

tr:hover {background-color: #f5f5f5;}

a {text-decoration: none; color:#074587;}

a{font-weight: bold;}

.collapse {width:200px}

input[type="text"]{background: rgba(0, 0, 0, 0);border: none;outline: none;font-weight:bold;}

</style>

<body>

<?php


$page = $_SERVER['PHP_SELF'];
$sec = "3000";
header("Refresh: $sec; url=$page");



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



$sql = "SELECT ID, Date,Time,IP,browser, redirect, city, country FROM IP  ORDER BY ID DESC";


$result = $conn->query($sql);

?>

<center>

<div>
<div style="background-color: white;width:350px; float:left; font-size:30px; margin-left:10px"> 
 <br/> <br/> 
<div id="ETA">

Driving Time: <br/> <br/>

<?php
$USCtoHome= "https://maps.googleapis.
/maps/api/distancematrix/json?units=imperial&origins=34.018833,%20-118.285781&destinations=34.239166,%20-118.229774&key=AIzaSyCAcuoyKIQDdHK8ugKufKpIiQYa7taO_zQ";

function GetDrivingDistance($lat1, $long1, $lat2, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&&origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&key=AIzaSyCAcuoyKIQDdHK8ugKufKpIiQYa7taO_zQ";
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

    $dist1 = GetDrivingDistance("34.017429", "-118.281402",  "34.239178", "-118.230038");
    echo 'USC to Home: <b>' . $dist1['time'].'</b><br/>'; 
    
    $dist2 = GetDrivingDistance("34.239178", "-118.230038", "34.017429", "-118.281402");
    echo 'Home to USC: <b>' . $dist1['time'].'</b><br/>'; 
    

?>

</div>




<div id="paper">
 <br/> <br/> 
Paper Downloads <a target="_blank" href="https://papers.ssrn.com/sol3/cf_dev/AbsByAuth.cfm?per_id=2170339"/> SSRN </a> <br/> <br/>

<?php


# Use the Curl extension to query Google and get back a page of results
$url = "https://papers.ssrn.com/sol3/cf_dev/AbsByAuth.cfm?per_id=2170339";
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$html = curl_exec($ch);
curl_close($ch);

# Create a DOM parser object
$dom = new DOMDocument();

# Parse the HTML from Google.
# The @ before the method call suppresses any warnings that
# loadHTML might throw because of invalid HTML in the page.
@$dom->loadHTML($html);

# Iterate over all the <a> tags
$totalDownload = 0;
$i = 1;
foreach($dom->getElementsByTagName('div') as $div) {
	if ($div->getAttribute('class') == "downloads") {
	$divNum = 1; //could be 1,2,3
		foreach($div->getElementsByTagName('span') as $span) {
		if ($divNum==2) {
		echo "Paper " . $i . ": <strong>"; 
		echo $span->nodeValue, PHP_EOL;
		echo "</strong/> <br/> ";
		$totalDownload = $totalDownload + (int)$span->nodeValue ;
		}
		$divNum = $divNum + 1 ;
		}
	$i = $i +1;
	}
}
echo "<br/> Total: <strong/>" . $totalDownload . "</strong>";
?>


</div>

</div>
 

<div style="float:left;margin-left:50px;">  
 
<table id="table" >
  <tr style="color:white;background-color:black;">
    <th>ID</th>
    <th>Date</th> 
    <th>Time</th>
    <th>IP</th>
    <th>Hostname</th>
    <th> Browser </th>
    <th> Country </th>
    <th> City</th>
    <th> Note</th>
    
    

  </tr>
  


<?php

if ($result->num_rows > 0) {
    
    // output data of each row
    while($row = $result->fetch_assoc()) {
    $note =" ";
    $isp = $row["redirect"];
    $browser = $row["browser"];
    $ip = $row["IP"];
    $id = $row["ID"];
    $country= $row["country"];
    $city= $row["city"];
    $new = 0;
  //       if (empty($country)) {
//    	echo $country;
    //     $location = json_decode(file_get_contents('http://freegeoip.net/json/'.$row["IP"]));
   //      $country = $location->country_name;
   //      $city = $location->city;
   //      $sql_insert ="UPDATE IP SET city = '$city', country= '$country' WHERE ID = $id";
   //      mysqli_query($conn, $sql_insert );
   //      $new = 1;
 //   }
   
    
    //Skip bot
    if  (strpos($isp, 'bot') !== false) {continue;$delete  = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'spider') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'amazonaws') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($browser, 'crawler') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($browser, 'facebook') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($browser, 'Crawler') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($browser, 'sitemap') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($browser, 'Sitemap') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'pro-sitemaps') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($browser, 'bot') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($browser, 'spider') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'phishmongers') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'umbrellastudy') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'researchscan') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'nugura.cs.usyd.edu.au') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'poneytelecom') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'planetlab') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($browser, 'Media Center') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, '52.165.148.51') !== false) {continue;}
    if  (strpos($isp, '52.173.241.248') !== false) {continue;}

    //Skip Me
    if  (strpos($isp, '71-94-154-105') !== false) {continue;}
    if  (strpos($isp, 'hoh112-phd-cs.marshall.usc.edu') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if  (strpos($isp, 'usc-secure-wireless-088-114.usc.edu') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
          if  (strpos($isp, '2607:fb90') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}

   // Country
   //if  ($location->country_name !== "United States" && $location->country_name !== "China") {continue;}
    if  (strpos($country, 'Russia') !== false) {continue;}
   //Tag
    if (strpos($ip, '107.184.76.69') !== false) {$note = "John Matsusaka";}
    if (strpos($ip, '104.32.165.160') !== false || strpos($isp, 'msb-hoh112-lou') !== false) {continue;$delete = "DELETE FROM IP WHERE ID = $id"; mysqli_query($conn, $delete );}
    if (strpos($ip, '47.137.28.179') !== false || strpos($isp, 'msb-hoh112-cab') !== false) {$note = "Felipe Cabezón";}
    if (strpos($isp, 'hoh112-phd-yc') !== false) {$note = "AJ Chen";}
    if (strpos($isp, 'uta.edu') !== false) {$note = "U Texas Arlington ";}
    if (strpos($isp, 'umich.edu') !== false) {$note = "U Michigan Ross ";}
    if (strpos($isp, 'umn.edu') !== false) {$note = "U Minnesota";}
    if (strpos($isp, 'upenn.edu') !== false) {$note = "U Penn";}
    if (strpos($isp, 'illinois.edu') !== false) {$note = "UIUC";}
 	

   	$style ="";
	if ($new ==1) {$style = "style=\"background-color:#fea4b6\""; }
    	echo "<tr ". $style .">";
    	echo "<th>" .   $row["ID"] . "</th>";
    	echo "<th>" .  $row["Date"] . "</th>";
    	echo "<th>" .  $row["Time"] . "</th>";
    	echo "<th><a target=\"_blank\" href=\"https://whatismyipaddress.com/ip/" . $ip . "\">" .  $ip . "</a></th>";
    	echo "<th>" .  $isp   . "</th>";
    	echo "<th class=\"collapse\">" . "<input type='text'  size='15' value='". $browser ."' />" . "</th>";
    	echo "<th>" . $country . "</th>";
    	echo "<th>  <a target=\"_blank\" href=\"https://www.google.com/maps/place/" . $country . ",+" . $city  . "\">" .  $city  . "</a></th>";
    	echo "<th>" .  $note   . "</th>";
    	echo "</tr>"; 
    }
} else {
    echo "0 results";
}
$conn->close();

?>
</table>

</div>


</div>

</center>


</body>
</html>