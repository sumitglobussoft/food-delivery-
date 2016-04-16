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

//alter by sowmya 18 march 2016
    public function addDeliveryGuyAction() {
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();

        if ($this->_request->isPost()) {
            $deliverydata['login_name'] = $this->getRequest()->getPost('login_name');
            $deliverydata['firstname'] = $this->getRequest()->getPost('firstname');
            $deliverydata['lastname'] = $this->getRequest()->getPost('lastname');
            $deliverydata['email'] = $this->getRequest()->getPost('email');
            $deliverydata['password'] = md5($this->getRequest()->getPost('password'));
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

//alter by sowmya 18 march 2016
    public function editDeliveryguyDetailsAction() {

        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        $delguyid = $this->getRequest()->getParam('delguyid');
        if ($this->_request->isPost()) {
            $delguyid = $delguyid;
            $deliverydata['login_name'] = $this->getRequest()->getPost('login_name');
            $deliverydata['firstname'] = $this->getRequest()->getPost('firstname');
            $deliverydata['lastname'] = $this->getRequest()->getPost('lastname');
            $deliverydata['email'] = $this->getRequest()->getPost('email');
            $deliverydata['password'] = md5($this->getRequest()->getPost('password'));
            $deliverydata['phone'] = $this->getRequest()->getPost('phone');
            $deliverydata['city'] = $this->getRequest()->getPost('city');
            $deliverydata['state'] = $this->getRequest()->getPost('state');
            $deliverydata['country'] = $this->getRequest()->getPost('country');
            $deliverydata['address'] = $this->getRequest()->getPost('address');
            $deliverydata['status'] = $this->getRequest()->getPost('status');
            if ($delguyid) {
                $result = $deliveryGuysModel->updateDeliveryGuydetails($delguyid, $deliverydata);
                if ($result) {
                    $this->redirect('/admin/delivery-guys-details');
                }
            }
        }

        if ($delguyid) {
            $deliveryguydetails = $deliveryGuysModel->getDeliveryGuyById($delguyid);
            if ($deliveryguydetails) {
                $this->view->deliveryguydetails = $deliveryguydetails;
            }
        }
    }

//added by sowmya 5 april 2016
    public function deliveryGuyOrdersAction() {
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();

        $delguyid = $this->getRequest()->getParam('delguy-id');

        if ($delguyid) {
            $result = $deliveryGuysModel->getDeliveryGuyOrders($delguyid);
            if ($result) {
                $pickupArr = $deliveredArr = $transitArr = array();
                foreach ($result as $key => $value) {
                    if ($value['status_type'] == 1) {
                        $pickupArr[] = $value;
                    } else if ($value['status_type'] == 2) {
                        $transitArr[] = $value;
                    } else if ($value['status_type'] == 3) {
                        $deliveredArr[] = $value;
                    }
                }
                $this->view->pickup = $pickupArr;
                $this->view->transit = $transitArr;
                $this->view->delivered = $deliveredArr;
            } else {
                echo 'controller error occured';
            }
            $this->view->deliveryguysorderdetails = $result;
        }
    }

//added by sowmya 5 april 2016
    public function deliveryGuyOrderLogsAction() {
        $DeliveryStatusLogModel = Admin_Model_DeliveryStatusLog::getInstance();
        $result = $DeliveryStatusLogModel->getAllOrderStatus();
        if ($result) {
            $pickupArr = $deliveredArr = $transitArr = array();
            foreach ($result as $key => $value) {
                if ($value['status_type'] == 1) {
                    $pickupArr[] = $value;
                } else if ($value['status_type'] == 2) {
                    $transitArr[] = $value;
                } else if ($value['status_type'] == 3) {
                    $deliveredArr[] = $value;
                }
            }
            $this->view->pickup = $pickupArr;
            $this->view->transit = $transitArr;
            $this->view->delivered = $deliveredArr;
        } else {
            echo 'controller error occured';
        }
        $this->view->deliveryStatusLog = $result;
    }

//added by sowmya 8/4/2016
    public function viewDeliveryguyDetailsAction() {

        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        $delguyid = $this->getRequest()->getParam('delguyid');      
        if ($delguyid) {
            $deliveryguydetails = $deliveryGuysModel->getDeliveryGuyById($delguyid);
            if ($deliveryguydetails) {
                $this->view->deliveryguydetails = $deliveryguydetails;
               
            }
        }
    }
}
