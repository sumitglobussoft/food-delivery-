<?php

require_once 'Zend/Controller/Action.php';

class Admin_OrderController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function orderdetailsAction() {
        $ordersModel = Admin_Model_Orders::getInstance();
        $result = $ordersModel->getAllOrders();
 
        if ($result) {
            $inprocessArr = $deliveredArr = $cancelledArr = array();
            foreach ($result as $key => $value) {
//               echo "-----".$key;
//               echo '<pre>'; print_r($value);die;
                if ($value['order_status'] == 1) {
//                   $this->view->processStatus = $result; //In Process
                    $inprocessArr[] = $value;
                } else if ($value['order_status'] == 2) {
//                   $this->view->deliveredStatus = $result; //Delivered
                    $deliveredArr[] = $value;
                } else if($value['order_status'] == 3) {
//                   $this->view->canceledStatus = $result; //Canceled
                    $cancelledArr[] = $value;
                }
            }
            $this->view->processStatus = $inprocessArr;
            $this->view->deliveredStatus = $deliveredArr;
            $this->view->canceledStatus = $cancelledArr;
        } else {
            echo 'controller error occured';
        }
        $this->view->orderdetails = $result;
    }

    public function allOrderDetailsAction() {
      
        $ordersModel = Admin_Model_Orders::getInstance();
        $orderId = $this->getRequest()->getParam("orderId");
        $result = $ordersModel->getallorderdetails($orderId);
        if ($result) {
            $this->view->allorderdetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    public function deliveryGuyDetailsAction(){
       $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
       $result = $deliveryGuysModel->getAllDeliveryGuys();
       $result1 = $deliveryGuysModel->getAllDeliveryGuystatus();
      
        if ($result1) {
            $activeArr = $inactiveArr = array();
            foreach ($result1 as $key => $value) {

                if ($value['status'] == 1) {
                    $activeArr[] = $value;
                } else if($value['status'] == 0) {
                    $inactiveArr[] = $value;
                }
            }
            $this->view->activeStatus = $activeArr;
            $this->view->inactiveStatus = $inactiveArr;
        } else {
            echo 'controller error occured';
        }

        $this->view->deliveryGuys = $result1;
    }

//    public function allDeliveryGuyDetailsAction() {
//        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
//        $uname = $this->getRequest()->getParam("uname");
//
//        $result = $deliveryGuysModel->getAlldeliveryGuysdetails($uname);
//        if ($result) {
//            $this->view->alluserdetails = $result;
//        } else {
//            echo 'controller error occured';
//        }
//    }

    public function addDeliveryGuyDetailsAction() {
//        die("test");
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();

        if ($this->_request->isPost()){
            $deliverydata['login_name'] = $this->getRequest()->getPost('uname');
            $deliverydata['firstname'] = $this->getRequest()->getPost('first_name');
            $deliverydata['lastname'] = $this->getRequest()->getPost('last_name');
            $deliverydata['email'] = $this->getRequest()->getPost('email');
            $deliverydata['password'] = $this->getRequest()->getPost('password');
            $deliverydata['phone'] = $this->getRequest()->getPost('phone');
            $deliverydata['city'] = $this->getRequest()->getPost('city');
            $deliverydata['state'] = $this->getRequest()->getPost('state');
            $deliverydata['country'] = $this->getRequest()->getPost('country');
            $deliverydata['address'] = $this->getRequest()->getPost('address');
            $deliverydata['status'] = $this->getRequest()->getPost('status');

            $result = $deliveryGuysModel->addDeliveryGuydetails($deliverydata);
            if($result){
              $this->redirect('/admin/delivery-guy-details');
                
            }
    }
    }

}
