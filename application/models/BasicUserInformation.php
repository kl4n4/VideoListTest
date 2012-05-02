<?php

class Application_Model_BasicUserInformation{

	public function setVideolistHeadline($token)
	{
		$graph_url = "https://graph.facebook.com/1497983918?access_token=" . $token;
		//$json_feed_object = create_json_feed_object($graph_url);
		$details = json_decode(file_get_contents($graph_url));
		$name = $details->name;
		return "<p>Facebook Videolist of ".$name."</p>";
	}


}