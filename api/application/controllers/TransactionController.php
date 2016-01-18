<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class TransactionController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function agentTransactionsAction(){
        
       $usertransactionModel = Application_Model_UserTransactions::getInstance();
        $orderproductsModel = Application_Model_OrderProducts::getInstance();
        $response = new stdClass();
       if ($this->getRequest()->isPost()) {
          $agent_id = $this->getRequest()->getPost('agent_id');
         
      $usertransactions = $orderproductsModel->getAgentProductTransactions($agent_id); 
     
       if($usertransactions){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $usertransactions;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
        echo json_encode($response,true);
        die(); 
     }else{
     $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
             echo json_encode($response,true);
        die();
           }
        
    
    }
    
}
