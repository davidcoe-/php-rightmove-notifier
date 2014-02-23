<?php

require_once('rightmovescrap.php');
$scrapper = new rightmovescrap();
$html = $scrapper->get_rightmove_listings();

//var_dump($html);

$img_links = array();
$source_html = new DOMDocument();

$source_html->loadHTML($html);
$all_houses = $source_html->getElementsByTagName('li');

print_r($all_houses);

$all_houses = iterator_to_array($all_houses);

print_r($all_houses);

foreach($all_houses->item as $house)
{
	print_r($house);
}

?>