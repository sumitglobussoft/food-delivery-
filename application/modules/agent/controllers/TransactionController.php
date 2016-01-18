<?php
require_once 'Zend/Controller/Action.php';

class Agent_TransactionController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * Dev: priyanka varanasi
     * Date : 23/12/2015
     * Desc : TO show the agent transactions 
     */
    
    public function agentPaymentsAction() {
        
    $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
    $objCore = Engine_Core_Core::getInstance();
    $objSecurity = Engine_Vault_Security::getInstance();
    $this->_appSetting = $objCore->getAppSetting();
    $agent_id = $this->view->session->storage->agent_id;
    $url = $this->_appSetting->apiLink . '/agent-transactions';
    $data['agent_id'] = $agent_id;
    $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
    
    if($curlResponse->code==200){
      
        $this->view->transactiondetails = $curlResponse->data;
        
    }
    }
 
}
