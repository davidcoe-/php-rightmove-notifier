<?php


class Rightmovescrap
{
	// Place the rightmove url that displays the required search results here.
	public $rightmove_url = 'http://www.rightmove.co.uk/property-for-sale/find.html?searchType=SALE&locationIdentifier=REGION%5E347&insId=2&radius=0.0&displayPropertyType=&minBedrooms=&maxBedrooms=&minPrice=&maxPrice=&retirement=&partBuyPartRent=&maxDaysSinceAdded=&_includeSSTC=on&sortByPriceDescending=&primaryDisplayPropertyType=&secondaryDisplayPropertyType=&oldDisplayPropertyType=&oldPrimaryDisplayPropertyType=&newHome=&auction=false';

	public function get_rightmove_listings() {

		$ch = curl_init($this->rightmove_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");  // Setting the useragent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // This returns the data inside the $ch variable as opposed to showing the result to screen.
		$scrapped_website = curl_exec($ch); //Put the scrapped data into a variable.
		curl_close($ch);



		$all_entries = $this->scrape_between($scrapped_website, '<ol id="summaries"', '</ol>'); // Get the area covering the data you want.


		//echo $all_entries;
		// $separate_results = explode('class="hlisting', $all_entries);   // Exploding the results into seperate array items

		return $all_entries;

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