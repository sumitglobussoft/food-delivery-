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
     * Dev: Priyanka Varanasi
     * Date : 17/12/2015
     * Desc: To get all grocery details regarding logged agent
     * 
     */

    public function groceryReviewsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/grocerydetails?method=getGroceryReviewsByAgentId';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse->code == 200) {

            $this->view->reviewdetails = $curlResponse->data;
        }
    }

      public function hotelReviewsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/grocerydetails?method=getHotelReviewsByAgentId';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
    
        if ($curlResponse->code == 200) {

            $this->view->reviewdetails = $curlResponse->data;
        }
    }
}