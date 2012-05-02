<?php

class VideoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//require_once 'library/facebook/facebook.php';
    }

    public function indexAction()
    {
        // action body
        $this->view->testMessage ="Videolist Application:";
    }
    
    public function facebookAction() {
    	$token = $this->getRequest()->getParam('token');
    	$this->view->access_token = $token;
    	
    	$top = new Application_Model_BasicUserInformation();
    	$this->view->headline = $top->setVideolistHeadline($token);
    	
    	$videoapp = new Application_Model_VideoApplication();
    	
    	$videolist = $videoapp->getVideoList($token);
    	$this->view->video = $videolist;
    	
    	
    }


}

