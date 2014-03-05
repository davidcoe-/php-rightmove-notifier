<html>
<head>
	<meta charset="UTF-8">
</head>
<body>

<?php

// Please change these values to match your requirements
$rightmove_url = 'http://www.rightmove.co.uk/property-for-sale/find.html?searchType=SALE&locationIdentifier=REGION%5E347&insId=2&radius=0.0&displayPropertyType=&minBedrooms=&maxBedrooms=&minPrice=&maxPrice=&retirement=&partBuyPartRent=&maxDaysSinceAdded=&_includeSSTC=on&sortByPriceDescending=&primaryDisplayPropertyType=&secondaryDisplayPropertyType=&oldDisplayPropertyType=&oldPrimaryDisplayPropertyType=&newHome=&auction=false'; // The exact search URL that you wish to replicate and repeat
$file_location = getcwd() .'/houses_found.csv'; // The location of the file house ids are saved to for future reference. This stops the script sending you the same houses each time it runs
$from = 'example@example.com'; // The email address the email will come from
$to = 'example@example.com'; // The email address the email will got too

/** **********************************************************************************
	Start the 
********************************************************************************** **/

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
	//Create File
	echo "Error finding file";
	file_put_contents($file_location, '');
}

if(empty($all_houses))
	echo "No new houses found";


// Save all new record
if (!empty($ids_to_record))
{
	file_put_contents($file_location, $ids_to_record);
}

// Email the message
if (!empty($email_list)) {
	$email_list_count = count($email_list);

	$subject = $email_list_count.'x New Property Found';
	$message .= '
		<html>
		<body><h1>Hello,</h1>';

	foreach ($email_list as $house) {
		$message .= '

		<a style="font-size: 30px;" href="'.$house['url'].'"> ' . $house['title'] . '</a><br />
		<strong style="font-size: 30px;">' . $house['price'] . '</strong><br /><br />
		' . $house['description'] . '.<br /><br />
		<a style="font-size: 30px;" href="'. $house['url'] .'">
		<img src="'.$house['image'].'" width="100%" alt="'. $house['title'] .'" /> <br /><br />'
		. $house['url'] . '</a>;
		<br /><br /><hr /><br /><br />
		';
	}

	$message .= '</body></html>';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset="UTF-8"' . "\r\n";
	$headers .= 'To: Me <$to>' . "\r\n";
	$headers .= 'From: Rightmove Scrapper <$from>' . "\r\n";

	if(mail($to, $subject, $message, $headers)) // Send the Email
	{
		echo "Email Sent - $email_list_count property found";
	} else {
		echo "Email not sent";
	}
}

echo "\n Finished with no errors";

?>

</body>
</html>