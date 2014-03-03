<html>
<head>
	<meta charset="UTF-8">
</head>
<body>

<?php

$rightmove_url = 'http://www.rightmove.co.uk/property-for-sale/find.html?searchType=SALE&locationIdentifier=REGION%5E347&insId=2&radius=0.0&displayPropertyType=&minBedrooms=&maxBedrooms=&minPrice=&maxPrice=&retirement=&partBuyPartRent=&maxDaysSinceAdded=&_includeSSTC=on&sortByPriceDescending=&primaryDisplayPropertyType=&secondaryDisplayPropertyType=&oldDisplayPropertyType=&oldPrimaryDisplayPropertyType=&newHome=&auction=false';
$file_location = $_SERVER['DOCUMENT_ROOT'] .'/houses_found.csv';
$from = '';
$to = '';

require_once('rightmovescrap.php');
$houses_raw_html = new rightmovescrap();
$all_houses = $houses_raw_html->get_rightmove_listings($rightmove_url);

/** **********************************************************************************
	Now to start using files to record and compare against previous found items
********************************************************************************** **/

// Check if file with id's exists
if (file_exists($file_location))
{
	// Get the id from the file and convert to a PHP array
	$existing_houses = file_get_contents($file_location);
	$existing_houses = str_getcsv($existing_houses);

	// Get each new house
	foreach ($all_houses as $new_house)
	{
		if (!in_array($new_house['id'], $existing_houses))
		{
			$email_list[] = $new_house;
		}
		$ids_to_record = $ids_to_record.$new_house['id'] .',';
	}

} else {

}

// Save all new record
if (!empty($ids_to_record))
{
	file_put_contents($file_location, $ids_to_record);
}


echo "<pre>";
var_dump($email_list);
echo "</pre>";

// Email the message
if (!empty($email_list)) {
	$email_list_count = count($email_list);

	$subject = $email_list_count.'x New Property Found';
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $from . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$message = '<html><body>';
	$message = '<style>a {color: #A10E8B;} a:visited {color: #bbbbbb;}</style>';
	$message = '<style>a {color: #A10E8B;} a:visited {color: #bbbbbb;}</style>';
	$message .= '<h1>Hello,</h1>';

	foreach ($email_list as $house) {
		$message .= '

		<a style="font-size: 30px;" href="'.$house['url'].'"> ' . $house['title'] . '</a><br />
		<strong style="font-size: 30px;">' . $house['price'] . '</strong><br /><br />
		' . $house['description'] . '.<br /><br />
		<a style="font-size: 30px;" href="'. $house['url'] .'">
		<img src="'.$house['image'].'" width="100%" alt="'. $house['title'] .'" /> <br /><br />'
		. $house['url'] . '</a>;

		';
	}

	$message .= '</body></html>';

	if(mail($to, $subject, $message, $headers))
		echo "Email Sent";

}

?>


</body>
</html>