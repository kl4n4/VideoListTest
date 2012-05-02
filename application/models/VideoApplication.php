<?php


class Application_Model_VideoApplication{
		
	public function getVideoList($token)
	{	
		//Facebook Problem - cannot use library/facebook/facebook.php
		$user = 1497983918;
		$counter = 0;
		$feed_url = "https://graph.facebook.com/".$user."/feed?limit=500&format=json&until=".strtotime('now')."&access_token=".$token;
		//echo $feed_url;
		$video_list = array();
		
		$w=1;
		while($w <= 8){
			$video_list = $this->writeVideoArray($video_list, $counter, $feed_url);
			$counter = sizeof($video_list);
			$paging_text = $this->get_next_feed_page($feed_url);
			$feed_url=$paging_text;
			//leave the loop when there are no further JSON Feed files are available on facebook
			if($feed_url == null){
				$w=8;
			}
			//maximum number of 8 Videos should be displayed
			if($counter>=8){
				$w=8;
			}
			$w++;
		}
		return $video_list;
	}
	
	/*
	 * Get the older Feed on the Facebook Wall by addressing the linked next Facebook Graph 
	 */
	protected function get_next_feed_page($url){
		$paging = $this->create_json_feed_object($url)->paging;
		return $paging->next;
	}
	
	/*
	 * Writes the results from the Facebook JSON File into the video_list array
	 * */
	protected function writeVideoArray($video_list, $counter, $feed_url){
		$details = $this->create_json_feed_object($feed_url);
		foreach ($details->data as $entry)
		{
			if(strpbrk($entry->caption, "youtube.com") && strpbrk($entry->source, "www.youtube.com") && $counter<8){
				//Create Video Object and store the appropriate information
				$video = new Application_Model_Video();
		
				$video->setVideoName($entry->name);
				$video->setVideoLink($entry->link);
				$posted = date("g:i A F j, Y", strtotime($entry->created_time));
				$video->setVideoPostInfo($posted);
				$video_list[$counter] = $video;
				$counter++;
			}
		}
		return $video_list;
	}
	
	/*
	 * Function parses the Facebook Graph URL into a readable JSON Object
	* */
	protected function create_json_feed_object($url){
		$json_feed_object = json_decode(file_get_contents($url));;
		return $json_feed_object;
	}
	
	
	/*
	 *Curl Disguise to generate a readable JSON string
	 */
	protected function disguise_curl($url)
	{
		$curl = curl_init();
		$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
		$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Keep-Alive: 300";
		$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$header[] = "Accept-Language: en-us,en;q=0.5";
		$header[] = "Pragma: ";
	
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_REFERER, '');
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($curl, CURLOPT_AUTOREFERER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$html = curl_exec($curl);
		//Close the Curl connection
		curl_close($curl);
	
		return $html;
	}
	
}
