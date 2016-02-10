<?php

require_once 'Zend/Controller/Action.php';

class Admin_OrderController extends Zend_Controller_Action {

    public function init() {

    }

    public function orderDetailsAction() {
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

}
