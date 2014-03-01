<html>
<head>
	<meta charset="UTF-8">

</head>
<body>

<?php

$rightmove_url = 'http://www.rightmove.co.uk/property-for-sale/find.html?searchType=SALE&locationIdentifier=REGION%5E347&insId=2&radius=0.0&displayPropertyType=&minBedrooms=&maxBedrooms=&minPrice=&maxPrice=&retirement=&partBuyPartRent=&maxDaysSinceAdded=&_includeSSTC=on&sortByPriceDescending=&primaryDisplayPropertyType=&secondaryDisplayPropertyType=&oldDisplayPropertyType=&oldPrimaryDisplayPropertyType=&newHome=&auction=false';

require_once('rightmovescrap.php');
$get_houses = new rightmovescrap();
$all_houses = $get_houses->get_rightmove_listings($rightmove_url);



?>


</body>
</html>