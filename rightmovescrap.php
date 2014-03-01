<?php


class Rightmovescrap
{
	// Place the rightmove url that displays the required search results here.

	public function get_rightmove_listings($rightmove_url = FALSE) {

		$ch = curl_init($rightmove_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");  // Setting the useragent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // This returns the data inside the $ch variable as opposed to showing the result to screen.
		$scrapped_website = curl_exec($ch); //Put the scrapped data into a variable.
		curl_close($ch);

		$html = $this->scrape_between($scrapped_website, '<ol id="summaries"', '</ol>'); // Get the area covering the data you want.

		$rightmoveurl = "http://www.rightmove.com";


		$source_html = new DOMDocument();
		$source_html->loadHTML($html);

		$all_list_items = $source_html->getElementsByTagName('li');

		$temp_dom = new DOMDocument();

		// For each list item found. Ensure it has a name element with the value 
		// of summary-list-item as these are the individual houses themselves.
		foreach($all_list_items as $single_list_item)
		{

			if ($single_list_item->getAttribute('name') === 'summary-list-item')
			{


				// Get the house title out of the h2 tag.
				$domnodelist_house_title = $single_list_item->getElementsByTagName('h2');
				foreach ($domnodelist_house_title as $single_house_title) {
					$house_title = $single_house_title->nodeValue;
					//echo "\n Title: ".$house_title;
				}

				// Get the house price out of the span with a pound sign.
				$domnodelist_price = $single_list_item->getElementsByTagName('span');
				foreach ($domnodelist_price as $single_house_price)
				{
					if(stristr($single_house_price->nodeValue,'£'))
					{
						$house_price = $single_house_price->nodeValue;
						//echo "\n Price: ".$house_price;
					}
				}

				// Get the house description
				$domnodelist_desc = $single_list_item->getElementsByTagName('p');
				foreach ($domnodelist_desc as $single_house_desc)
				{
					if(stristr($single_house_desc->nodeValue,'More details'))
					{
						$house_desc = $single_house_desc->nodeValue;
						//echo "\n Desc: ".$house_desc;
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
						//echo "\n URL: ".$house_url;
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
						//echo "\n IMAGE: ".$large_house_image;
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

		echo "<pre>";
		var_dump($house_results);
		echo "</pre>";

		// Debugging
		//print_r($temp_dom->saveHTML());

		return $house_results;

	}



	public function scrape_between($data, $start, $end)
	{
		$data = stristr($data, $start); // Stripping all data from before $start
		$data = substr($data, strlen($start));  // Stripping $start
		$stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
		$data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
		return $data;   // Returning the scraped data from the function
	}
}


?>