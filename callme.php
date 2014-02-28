<?php

require_once('rightmovescrap.php');
$scrapper = new rightmovescrap();
$html = $scrapper->get_rightmove_listings();

//var_dump($html);
echo "Hello<br />";
$img_links = array();
$source_html = new DOMDocument();

$source_html->loadHTML($html);

echo '<textarea rows="40" cols="150">';
$all_list_items = $source_html->getElementsByTagName('li');


// For each list item found. Ensure it has a name element with the value 
// of summary-list-item as these are the individual houses themselves.
$temp_dom = new DOMDocument();
foreach($all_list_items as $single_list_item)
{

	if ($single_list_item->getAttribute('name') === 'summary-list-item')
	{

		echo "

########### House ITEM ###########
	";

		// Get the house title out of the h2 tag.
		$domnodelist_house_title = $single_list_item->getElementsByTagName('h2');
		foreach ($domnodelist_house_title as $single_house_title) {
			$house_title = $single_house_title->nodeValue;
			echo "\n Title: ".$house_title;
		}

		// Get the house price out of the span with a pound sign.
		$domnodelist_price = $single_list_item->getElementsByTagName('span');
		foreach ($domnodelist_price as $single_house_price)
		{
			if(stristr($single_house_price->nodeValue,'£'))
			{
				$house_price = $single_house_price->nodeValue;
				echo "\n Price: ".$house_price;
			}
		}

		// Get the house description
		$domnodelist_desc = $single_list_item->getElementsByTagName('p');
		foreach ($domnodelist_desc as $single_house_desc)
		{
			if(stristr($single_house_desc->nodeValue,'description'))
			{
				$house_desc = $single_house_desc->nodeValue;
				echo "\n Desc: ".$house_desc;

			}
		}

		// get the house images

		// Get the house URL

		// Add the data to addition DOM for potential later use
		$temp_dom->appendChild($temp_dom->importNode($single_list_item,true));

	}



}



echo "


END--END";


//$xml = simplexml_load_string($html); 
//$myresult = $xml->xpath("//li"); 
//echo $myresult[0]->asXml();



echo '</textarea>';

//echo '<textarea rows="40">';
print_r($temp_dom->saveHTML());
//echo '</textarea>';
?>