<?php

require_once('rightmovescrap.php');
$scrapper = new rightmovescrap();
$html = $scrapper->get_rightmove_listings();

//var_dump($html);
echo "Hello<br />";
$img_links = array();
$source_html = new DOMDocument();

$source_html->loadHTML($html);

echo '<textarea rows="40">';
$all_list_items = $source_html->getElementsByTagName('li');


// For each list item found. Ensure it has a name element with the value 
// of summary-list-item as these are the individual houses themselves.
$temp_dom = new DOMDocument();
foreach($all_list_items as $single_list_item)
{

	if ($single_list_item->getAttribute('name') === 'summary-list-item')
	{

		// Get the house title out of the h2 tag.
		$domnodelist_house_title = $single_list_item->getElementsByTagName('h2');
		foreach ($domnodelist_house_title as $single_house_title) {
			$house_title = $single_house_title->nodeValue;
		}

		// Get the house price out of the price class.
		$domnodelist_price = $single_list_item->getElementsByTagName('p');
		foreach ($domnodelist_price as $single_house_price)
		{
			if(stristr($single_house_price->nodeValue,'price'))
			{
				echo $single_house_price->nodeValue;
			}
		}

		echo $house_price;

		// Add the data to addition DOM for potential later use
		$temp_dom->appendChild($temp_dom->importNode($single_list_item,true));

	}
}



echo "END--END";
echo '</textarea>';

//echo '<textarea rows="40">';
print_r($temp_dom->saveHTML());
//echo '</textarea>';
?>