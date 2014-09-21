<?php
// PHP Proxy example for Yahoo! Web services.
// Responds to both HTTP GET and POST requests
//
// Author: Jason Levitt
// December 7th, 2005
//

//http://localhost:8888/hack4dk/object.php?guid=80f4e0a2-1dfb-af48-b12f-629c23eb99fc&format=json


// Get the REST call path from the AJAX application
// Is it a POST or a GET?
$guid = $_GET['guid'];
$format = $_GET['format'];

$url = "http://api.larm.fm/v6/View/Get?view=Object&query=".$guid."&pageIndex=0&pageSize=20&sessionGUID=&format=".$format."&userHTTPStatusCodes=False";

// Open the Curl session
$session = curl_init($url);


// Don't return HTTP headers. Do return the contents of the call
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// Make the call
$xml = curl_exec($session);

// The web service returns XML. Set the Content-Type appropriately
header("Content-Type: application/".$format);
//header("Content-Type: text/plain");

echo $xml;
//echo $url;

curl_close($session);

?>