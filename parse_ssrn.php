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
		echo $span->nodeValue, PHP_EOL;
		$totalDownload = $totalDownload + (int)$span->nodeValue ;
		}
		$divNum = $divNum + 1 ;
		}
	$i = $i +1;
	}
}
echo $totalDownload;


?>