<?php

require_once('rightmovescrap.php');
$scrapper = new rightmovescrap();
$html = $scrapper->get_rightmove_listings();

//var_dump($html);
echo "Hello<br />";
$img_links = array();
$source_html = new DOMDocument();

$source_html->loadHTML($html);


//print_r($source_html);
echo '<textarea rows="40">';
$all_list_items = $source_html->getElementsByTagName('li');


foreach($all_list_items as $single_list_item)
{
	//var_dump($single_list_item);
	if ($single_list_item->getAttribute('name') === 'summary-list-item')
	{
		echo $single_list_item->getAttribute('name') ."<br />";
	}
}

echo "<br /> ENDEND <br />";

/*
print_r($all_list_items);
*/


$temp_dom = new DOMDocument();
foreach($all_list_items as $n)
{
	$temp_dom->appendChild($temp_dom->importNode($n,true));
	var_dump($temp_dom);
	echo "<br /> //////// <br />";

}

echo '</textarea>';


//echo '<textarea rows="40">';
print_r($temp_dom->saveHTML());
//echo '</textarea>';
?>