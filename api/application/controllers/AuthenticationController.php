<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class AuthenticationController extends Zend_Controller_Action{

    public function init()
    { 
        $this->_helper->viewRenderer->setNoRender(true);
    }
}