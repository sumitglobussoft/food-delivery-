<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_StaticController extends Zend_Controller_Action {

    public function init() {

    }

    public function deliveryGuysDetailsAction() {
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        $result = $deliveryGuysModel->getAllDeliveryGuys();
        if ($result) {
             $this->view->deliveryguysdetails = $result;
        } else {
            echo 'controller error occured';
        }
   }

    public function addDeliveryGuyAction() {
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();

        if ($this->_request->isPost()) {
            $deliverydata['login_name'] = $this->getRequest()->getPost('login_name');
            $deliverydata['firstname'] = $this->getRequest()->getPost('firstname');
            $deliverydata['lastname'] = $this->getRequest()->getPost('lastname');
            $deliverydata['email'] = $this->getRequest()->getPost('email');
            $deliverydata['password'] = md5(sha1($this->getRequest()->getPost('password')));
            $deliverydata['phone'] = $this->getRequest()->getPost('phone');
            $deliverydata['city'] = $this->getRequest()->getPost('city');
            $deliverydata['state'] = $this->getRequest()->getPost('state');
            $deliverydata['country'] = $this->getRequest()->getPost('country');
            $deliverydata['address'] = $this->getRequest()->getPost('address');
            $deliverydata['status'] = $this->getRequest()->getPost('status');
            $deliverydata['reg_date'] = date('Y-m-d H-i-s');

            $result = $deliveryGuysModel->addDeliveryGuydetails($deliverydata);
            if ($result) {
                $this->redirect('/admin/delivery-guys-details');
            }
        }
    }

    public function editDeliveryguyDetailsAction() {
     
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
         $delguyid = $this->getRequest()->getParam('delguyid');
         if ($this->_request->isPost()) {
            $deliverydata['login_name'] = $this->getRequest()->getPost('login_name');
            $deliverydata['firstname'] = $this->getRequest()->getPost('firstname');
            $deliverydata['lastname'] = $this->getRequest()->getPost('lastname');
            $deliverydata['email'] = $this->getRequest()->getPost('email');
            $deliverydata['password'] = md5(sha1($this->getRequest()->getPost('password')));
            $deliverydata['phone'] = $this->getRequest()->getPost('phone');
            $deliverydata['city'] = $this->getRequest()->getPost('city');
            $deliverydata['state'] = $this->getRequest()->getPost('state');
            $deliverydata['country'] = $this->getRequest()->getPost('country');
            $deliverydata['address'] = $this->getRequest()->getPost('address');
            $deliverydata['status'] = $this->getRequest()->getPost('status');
            if($delguyid){
            $result = $deliveryGuysModel->updateDeliveryGuydetails($delguyid,$deliverydata);
            if ($result) {
                $this->redirect('/admin/delivery-guys-details');
            }
         }
        }
        
           if($delguyid){
            $deliveryguydetails = $deliveryGuysModel->getDeliveryGuyById($delguyid); 
            if($deliveryguydetails){
              $this->view->deliveryguydetails = $deliveryguydetails;
            }
             
         }
        
    }
    
        public function deliveryGuyOrdersAction() {
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        
        $delguyid = $this->getRequest()->getParam('delguy-id');
        
        if($delguyid){
         $result = $deliveryGuysModel->getDeliveryGuyOrders($delguyid);   
            if($result){
              $this->view->deliveryguysorderdetails = $result;   
                
            }else{
             $this->view->message ='No orders carried by thi delivery guy';    
               
            }
        }else{
          echo 'controller error occured';   
            
        }
      
   }
    

}
