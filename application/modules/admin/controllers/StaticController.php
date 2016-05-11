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
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        $result = $deliveryGuysModel->getAllDeliveryGuys();
        if ($result) {
            $this->view->deliveryguysdetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    public function storeDeliveryGuysDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
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
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }


        $locationsModel = Admin_Model_Location::getInstance();
        $locations = $locationsModel->getLocations();
        if ($locations) {
            $this->view->locationdetails = $locations;
        }

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
            $deliverydata['hotel_store'] = $this->getRequest()->getPost('hotel_store');
            if ($deliverydata['hotel_store'] == 1) {
                $deliverydata['hotel_id'] = json_encode($this->getRequest()->getPost('hotel_id'));
                $deliverydata['location'] = $this->getRequest()->getPost('location');
            } else if ($deliverydata['hotel_store'] == 2) {
                $deliverydata['store_id'] = json_encode($this->getRequest()->getPost('store_id'));
                $deliverydata['location'] = $this->getRequest()->getPost('location1');
            }
            $deliverydata['reg_date'] = date('Y-m-d H-i-s');

            $result = $deliveryGuysModel->addDeliveryGuydetails($deliverydata);
            if ($result) {
                $this->redirect('/admin/add-delivery-guy');
            }
        }
    }

//alter by sowmya 18 march 2016
    public function editDeliveryguyDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $locationsModel = Admin_Model_Location::getInstance();
        $locations = $locationsModel->getLocations();
        if ($locations) {
            $this->view->locationdetails = $locations;
        }
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
            $deliverydata['hotel_store'] = 1;
            $deliverydata['country'] = $this->getRequest()->getPost('country');
            $deliverydata['address'] = $this->getRequest()->getPost('address');
            $deliverydata['status'] = $this->getRequest()->getPost('status');
            $deliverydata['location'] = $this->getRequest()->getPost('location');
            $deliverydata['hotel_id'] = json_encode($this->getRequest()->getPost('hotel_id'));
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
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();

        $delguyid = $this->getRequest()->getParam('delguy-id');

        if ($delguyid) {
            $result = $deliveryGuysModel->getDeliveryGuyOrders($delguyid);
            if ($result) {
                $pickupArr = $deliveredArr = $ProcessingArr = $OutforDeliveryArr = array();
                foreach ($result as $key => $value) {
                    if ($value['order_status'] == 2) {
                        $ProcessingArr[] = $value;
                    } else if ($value['order_status'] == 3) {
                        $pickupArr[] = $value;
                    } else if ($value['order_status'] == 4) {
                        $OutforDeliveryArr[] = $value;
                    } else if ($value['order_status'] == 5) {
                        $deliveredArr[] = $value;
                    }
                }
                $this->view->processing = $ProcessingArr;
                $this->view->pickup = $pickupArr;
                $this->view->outfordelivery = $OutforDeliveryArr;
                $this->view->delivered = $deliveredArr;
            } else {
                echo 'controller error occured';
            }
            $this->view->deliveryguysorderdetails = $result;
        }
    }

//added by sowmya 5 april 2016
    public function deliveryGuyOrderLogsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        $result = $deliveryGuysModel->getDeliveryGuyOrderLogs();
        if ($result) {
            $pickupArr = $deliveredArr = $ProcessingArr = $OutforDeliveryArr = array();
            foreach ($result as $key => $value) {
                if ($value['order_status'] == 2) {
                    $ProcessingArr[] = $value;
                } else if ($value['order_status'] == 3) {
                    $pickupArr[] = $value;
                } else if ($value['order_status'] == 4) {
                    $OutforDeliveryArr[] = $value;
                } else if ($value['order_status'] == 5) {
                    $deliveredArr[] = $value;
                }
            }
            $this->view->processing = $ProcessingArr;
            $this->view->pickup = $pickupArr;
            $this->view->outfordelivery = $OutforDeliveryArr;
            $this->view->delivered = $deliveredArr;
        } else {
            echo 'controller error occured';
        }
        $this->view->deliveryStatusLog = $result;
    }

//added by sowmya 8/4/2016
    public function viewDeliveryguyDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        $delguyid = $this->getRequest()->getParam('delguyid');
        if ($delguyid) {
            $deliveryguydetails = $deliveryGuysModel->getDeliveryGuyById($delguyid);
            if ($deliveryguydetails) {
                $this->view->deliveryguydetails = $deliveryguydetails;
            }
        }
    }

//added by sowmya 8/4/2016
    public function viewStoreDeliveryguyDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        $delguyid = $this->getRequest()->getParam('delguyid');
        if ($delguyid) {
            $deliveryguydetails = $deliveryGuysModel->getDeliveryGuyById($delguyid);
            if ($deliveryguydetails) {
                $this->view->deliveryguydetails = $deliveryguydetails;
            }
        }
    }

    //added by sowmya 5 april 2016
    public function storeDeliveryGuyOrdersAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();

        $delguyid = $this->getRequest()->getParam('delguy-id');

        if ($delguyid) {
            $result = $deliveryGuysModel->getStoreDeliveryGuyOrders($delguyid);
            if ($result) {
                $pickupArr = $deliveredArr = $ProcessingArr = $OutforDeliveryArr = array();
                foreach ($result as $key => $value) {
                    if ($value['order_status'] == 2) {
                        $ProcessingArr[] = $value;
                    } else if ($value['order_status'] == 3) {
                        $pickupArr[] = $value;
                    } else if ($value['order_status'] == 4) {
                        $OutforDeliveryArr[] = $value;
                    } else if ($value['order_status'] == 5) {
                        $deliveredArr[] = $value;
                    }
                }
                $this->view->processing = $ProcessingArr;
                $this->view->pickup = $pickupArr;
                $this->view->outfordelivery = $OutforDeliveryArr;
                $this->view->delivered = $deliveredArr;
            } else {
                echo 'controller error occured';
            }
            $this->view->deliveryguysorderdetails = $result;
        }
    }

    //added by sowmya 5 april 2016
    public function storeDeliveryGuyOrderLogsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $deliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        $result = $deliveryGuysModel->getStoreDeliveryGuyOrderLogs();
        if ($result) {
            $pickupArr = $deliveredArr = $ProcessingArr = $OutforDeliveryArr = array();
            foreach ($result as $key => $value) {
                if ($value['order_status'] == 2) {
                    $ProcessingArr[] = $value;
                } else if ($value['order_status'] == 3) {
                    $pickupArr[] = $value;
                } else if ($value['order_status'] == 4) {
                    $OutforDeliveryArr[] = $value;
                } else if ($value['order_status'] == 5) {
                    $deliveredArr[] = $value;
                }
            }
            $this->view->processing = $ProcessingArr;
            $this->view->pickup = $pickupArr;
            $this->view->outfordelivery = $OutforDeliveryArr;
            $this->view->delivered = $deliveredArr;
        } else {
            echo 'controller error occured';
        }
        $this->view->deliveryStatusLog = $result;
    }

    public function editStoreDeliveryguyDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $locationsModel = Admin_Model_Location::getInstance();
        $locations = $locationsModel->getLocations();
        if ($locations) {
            $this->view->locationdetails = $locations;
        }
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
            $deliverydata['hotel_store'] = 2;
            $deliverydata['country'] = $this->getRequest()->getPost('country');
            $deliverydata['address'] = $this->getRequest()->getPost('address');
            $deliverydata['status'] = $this->getRequest()->getPost('status');
            $deliverydata['location'] = $this->getRequest()->getPost('location');
            $deliverydata['store_id'] = json_encode($this->getRequest()->getPost('store_id'));
            if ($delguyid) {
                $result = $deliveryGuysModel->updateDeliveryGuydetails($delguyid, $deliverydata);
                if ($result) {
                    $this->redirect('/admin/store-delivery-guys-details');
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

}
