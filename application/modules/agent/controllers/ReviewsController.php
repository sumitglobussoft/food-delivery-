<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Agent_ReviewsController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * Dev: sowmya 
     * Date : 29/4/2016
     * Desc: To get all store reviews regarding logged agent
     * 
     */

    public function storeReviewsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/storedetails?method=getStoreReviewsByAgentId';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse->code == 200) {

            $this->view->reviewdetails = $curlResponse->data;
        }
    }
 /*
     * Dev: sowmya 
     * Date : 29/4/2016
     * Desc: To get all hotel reviews regarding logged agent
     * 
     */
      public function hotelReviewsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/storedetails?method=getHotelReviewsByAgentId';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
    
        if ($curlResponse->code == 200) {

            $this->view->reviewdetails = $curlResponse->data;
        }
    }
}