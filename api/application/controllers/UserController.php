<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class UserController extends Zend_Controller_Action {

    public function init() {
         $this->_helper->viewRenderer->setNoRender(true);
    }
/* Dev : Priyanka Varanasi
   * Date: 2/12/2015
   * Desc: Users Profile ans settings action
   */

    public function userSettingsAction(){
        
        
        
   
        
    }
   /*
   * Dev : Priyanka Varanasi
   * Date: 3/12/2015
   * Desc: User transactions Action
   */
   public function transactionProcessAction(){
       
   $usertransactionModal  =   Application_Model_UserTransactions::getInstance();
   $response = new stdClass();
   $method = $this->getRequest()->getParam('method');
    if($method){
        
   switch ($method) {
       
      case'inserttransaction':
          
      if ($this->getRequest()->isPost()) {
          
      $data['order_id'] = $this->getRequest()->getPost('order_id');
      $data['tx_type'] = $this->getRequest()->getPost('transactiontype');
      $data['tx_amount'] = $this->getRequest()->getPost('amount');
      $data['tx_code'] = $this->getRequest()->getPost('transactioncode');
      $data['tx_date'] = $this->getRequest()->getPost('date');
      $data['tx_status'] = $this->getRequest()->getPost('status');
      $data['user_id'] = $this->getRequest()->getPost('userid');
                
      $transactionId  = $usertransactionModal->insertUseTransactions($data);
              if ($transactionId) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data['transaction_id'] = $transactionId;
                      
                     } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 197;
                    
                       }
               }else{
                     $response->message = 'Could Not Serve The Request';
                     $response->code = 401;
                     $response->data = NULL;
                   
                   }
                    echo json_encode($response,true); 
                     die(); 
                    break;
                    
    case'updatetransaction': 
        
      if ($this->getRequest()->isPost()) {
            
               $txstatus = $this->getRequest()->getPost('status');
            if(!empty($txstatus)){
               $data['tx_status'] = $txstatus;
           }
            $orderid = $this->getRequest()->getPost('order_id');
           
            $userid = $this->getRequest()->getPost('userid');
            
         if($userid && $orderid ){
             $update  = $usertransactionModal->updateTransaction($userid,$orderid,$data);
              if ($update) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data = $update;
             
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 197;
                        $response->data = $update;
                     }
                   }else{
                     $response->message = 'Could Not Serve The Request';
                     $response->code = 401;
                     $response->data = NULL;
                   
                        }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = Null;
          
        }
          echo json_encode($response,true);
            die();
        break;  
    } 
    }else{
       $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = Null;
            echo json_encode($response);
            die();  
        
    }
    
}

}
?>