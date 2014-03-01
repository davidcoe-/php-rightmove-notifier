<?php

require_once('rightmovescrap.php');
$scrapper = new rightmovescrap();
$html = $scrapper->get_rightmove_listings();
$rightmoveurl = "http://www.rightmove.com";

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
			if(stristr($single_house_desc->nodeValue,'More details'))
			{
				$house_desc = $single_house_desc->nodeValue;
				echo "\n Desc: ".$house_desc;
			}
		}

		// Get the house URL
		$i = 0;
		$domnodelist_url = $single_list_item->getElementsByTagName('a');
		foreach ($domnodelist_url as $single_house_url)
		{
			// Record just the first instance of the URL.
			if((stristr($single_house_url->getAttribute('href'),'property-')) AND ($i < 1))
			{
				$house_url = $rightmoveurl.$single_house_url->getAttribute('href');
				echo "\n URL: ".$house_url;
				$i++;
			}
			
		}

		// Get the main house image
		$domnodelist_images = $single_list_item->getElementsByTagName('img');
		foreach ($domnodelist_images as $single_image)
		{
			// look for either 'largephoto' or 'fixedpic' as a classname
			if((stristr($single_image->getAttribute('class'),'largephoto')) || (stristr($single_image->getAttribute('class'),'fixedpic')))
			{
				$small_house_image = $single_image->getAttribute('src');
				$large_house_image = str_replace('214x143','656x437',$small_house_image);	
				echo "\n IMAGE: ".$large_house_image;
			}
		}

		// Add the data to addition DOM for potential later use aswell as debugging.
		//$temp_dom->appendChild($temp_dom->importNode($single_list_item,true));


		$house_results[] = array(
			'title' => $house_title,
			'price' => $house_price,
			'description' => $house_desc,
			'url' => $house_url,
			'image' => $large_house_image
		);

	}

}



echo "

END--END

</textarea>";


echo "<pre>";
var_dump($house_results);
echo "</pre>";


// Debugging
//print_r($temp_dom->saveHTML());
?>