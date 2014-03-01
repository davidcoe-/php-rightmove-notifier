<html>
<head>
	<meta charset="UTF-8">

</head>
<body>

<?php

$rightmove_url = 'http://www.rightmove.co.uk/property-for-sale/find.html?searchType=SALE&locationIdentifier=REGION%5E347&insId=2&radius=0.0&displayPropertyType=&minBedrooms=&maxBedrooms=&minPrice=&maxPrice=&retirement=&partBuyPartRent=&maxDaysSinceAdded=&_includeSSTC=on&sortByPriceDescending=&primaryDisplayPropertyType=&secondaryDisplayPropertyType=&oldDisplayPropertyType=&oldPrimaryDisplayPropertyType=&newHome=&auction=false';
$file_location = $_SERVER['DOCUMENT_ROOT'] .'/houses_found.json';

require_once('rightmovescrap.php');
$houses_raw_html = new rightmovescrap();
$all_houses = $houses_raw_html->get_rightmove_listings($rightmove_url);
$all_houses_json = json_encode($all_houses);

echo "<pre>";
var_dump($all_houses);
echo "</pre>";


/** **********************************************************************************
	Now to start using files to record and compare against previous found items
********************************************************************************** **/


// Check if file exists
if (file_exists($file_location))
{
	$existing_houses = file_get_contents($file_location);
	$existing_houses = json_decode($existing_houses, true);

	foreach ($all_houses as $value)
	{
		echo "<pre>";
		var_dump($value['id']);
		echo "</pre>";	

		if (in_array($value['id'], $existing_houses))
			{echo "\n Found! \n";}
			else {echo "\n NOT Found! \n";}
	}

} else {

}

echo "\n\n Existing Houses Array \n\n";
echo "<pre>";
var_dump($existing_houses);
echo "</pre>";

/**
$file = @fopen($file_location,"x");
if($file)
{
	echo fwrite($file,"Some Code Here"); 
	fclose($file); 
}
*/






/*
$f = (file_exists($file_location))? fopen($file_location, "a+") : fopen($file_location, "w+");

fwrite($f, $all_houses_json);
fclose($f);
chmod($file_location, 0777);
*/


	//$all_houses = json_decode($all_houses, true);


?>


</body>
</html>