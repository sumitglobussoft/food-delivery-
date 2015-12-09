<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_OrderController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function orderAjaxHandlerAction(){
        $this->_helper->_layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $method = $this->getRequest()->getParam('method');
        
        switch($method){
            case 'test':
                break;
            default :
                break;
        }
    }
}
