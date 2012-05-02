<?php

class IndexController extends Zend_Controller_Action
{

    public function init() {
      /* Initialize action controller here */
    }

    public function indexAction() {

      /*$fb = new Application_Model_Facebook();

      if (!$fb->getSession()) {

        $this->view->redirect_url =
               Application_Model_Facebook::OAUTH_URL
               . '?client_id='.Application_Model_Facebook::APP_ID
               . '&scope=user_birthday'
               . '&redirect_uri='.$_SERVER['HTTP_REFERER']
               . '&response_type=token';
        $this->_helper->viewRenderer->setScriptAction('redirect');

      } else {

        Zend_Debug::dump($fb->getUserInfo());
        
      }*/
    }

}