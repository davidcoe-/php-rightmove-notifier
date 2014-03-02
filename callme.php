<html>
<head>
	<meta charset="UTF-8">

</head>
<body>

<?php

$rightmove_url = 'http://www.rightmove.co.uk/property-for-sale/find.html?searchType=SALE&locationIdentifier=REGION%5E347&insId=2&radius=0.0&displayPropertyType=&minBedrooms=&maxBedrooms=&minPrice=&maxPrice=&retirement=&partBuyPartRent=&maxDaysSinceAdded=&_includeSSTC=on&sortByPriceDescending=&primaryDisplayPropertyType=&secondaryDisplayPropertyType=&oldDisplayPropertyType=&oldPrimaryDisplayPropertyType=&newHome=&auction=false';
$file_location = $_SERVER['DOCUMENT_ROOT'] .'/houses_found.csv';

require_once('rightmovescrap.php');
$houses_raw_html = new rightmovescrap();
$all_houses = $houses_raw_html->get_rightmove_listings($rightmove_url);
$all_houses_json = json_encode($all_houses);

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
		$existing_houses_count = count($existing_houses) - 1;
		foreach ($existing_houses as $existing_house)
		{
			if (!in_array($new_house['id'], $existing_house))
			{
				echo "\n ". key($existing_house) ." Found! \n";
				// add to array for emailing later
			}

			echo "\n Blah! \n";
			// add to array for saving later
		}

	}

} else {

}


/*
// write to a file
foreach ($all_houses as $single_house) {
	$ids_to_record = $ids_to_record.$single_house['id'] .',';
}

var_dump($ids_to_record);



$f = (file_exists($file_location))? fopen($file_location, "a+") : fopen($file_location, "w+");

fwrite($f, $ids_to_record);
fclose($f);
chmod($file_location, 0777);
*/

?>


</body>
</html>