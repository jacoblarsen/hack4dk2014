<?php
// PHP Proxy example for Yahoo! Web services.
// Responds to both HTTP GET and POST requests
//
// Author: Jason Levitt
// December 7th, 2005
//

//http://localhost:8888/hack4dk/search.php?from=1977-05-06&to=1977-05-06&format=json

// Is it a POST or a GET?
$from = $_GET['from'];

$to = $_GET['to'];

$format = $_GET['format'];

$url = "http://api.larm.fm/v6/View/Get?view=Search&sort=PubStartDate%2Bdesc&filter=%28PubStartDate:[".$from."T00:00:00Z%20TO%20".$to."T00:00:00Z]%20AND%20%28Type%3ASchedule%20OR%20Type%3AScheduleNote%29%29&pageIndex=0&pageSize=20&sessionGUID=049da351-b81f-424e-82c4-1162926d3688&format=".$format."&userHTTPStatusCodes=False"; 

// Open the Curl session
$session = curl_init($url);


// Don't return HTTP headers. Do return the contents of the call
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// Make the call
$xml = curl_exec($session);

// The web service returns XML. Set the Content-Type appropriately
//header("Content-Type: application/json");
$header = "Content-Type: application/".$format;

header($header);
//header("Content-Type: text/plain");

echo $xml;
//echo $url;

curl_close($session);

?>