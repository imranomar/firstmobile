<?php
/**
 * simpleclient..php
 */

$lat= 25.27;
$lng = 55.30;
$geonameId = 8201288;
//$geonameid = 34534545454;


$client = new SoapClient(null, array(
	'location' => "http://127.0.0.1/firstmobile/simple_server.php",
	'uri'      => "http://127.0.0.1/firstmobile/"
	));

//$result = $client->__soapCall("geolocate",array($lat,$lng));
$result = $client->__soapCall("describe",array($geonameId));

print_r($result);

?>
