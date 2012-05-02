<?php

class Application_Model_Video{
	private	$videoname;
	private $videolink;
	private $videopost;
	
	public function setVideoName($name)
	{
		$this->videoname = $name;
	}
	
	public function getVideoName()
	{
		return $this->videoname;
	}

	public function setVideoLink($link){
		$this->videolink = $link;
	}
	
	public function getVideoLink(){
		return $this->videolink;
	}
	
	public function setVideoPostInfo($post){
		$this->videopost = $post;
	}
	
	public function getVideoPostInfo(){
		return $this->videopost;
	}
	
	
	/*
	 *Youtube Video Parser to generate an iframe element which contains an individual youtube Video Link. 
	 * */
	public function getVideoFrame($url, $return='embed',$width='',$height='',$rel=0){
		$yt_url = parse_url(substr($url, 1, 42));
	  
	    if(strpos($yt_url['path'],'embed') == 1){
	        $id = end(explode('/',$yt_url['path']));
	    }
	     //URL is xxxx only
	    else if(strpos($url,'/')==false){
	        $id = $url;
	    }
	    else{
	        parse_str($yt_url['query']);
	        //$id = $v;
	        $id = end(explode('v=',$yt_url['query']));
	    }
	    //Return embed iframe
	    if($return == 'embed'){
	        return '<iframe width="'.($width?$width:250).'" height="'.($height?$height:157).'" src="http://www.youtube.com/embed/'.$id.'?rel='.$rel.'" frameborder="0" allowfullscreen></iframe>';
	    }
	    else{
	        return $id;
	    }
	}
}