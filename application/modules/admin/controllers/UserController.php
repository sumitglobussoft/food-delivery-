<?php

require_once 'Zend/Controller/Action.php';

class Admin_UserController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function userdetailsAction() {
        $userModel = Admin_Model_Users::getInstance();
        $result = $userModel->getUserdetails();

        if ($result) {
            $this->view->userdetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV :sowmya
     * Desc : edit User Details action
     * Date : 17/3/2016
     */

    public function editUserDetailsAction() {
        $userModel = Admin_Model_Users::getInstance();
        $userId = $this->getRequest()->getParam("userId");
        $usermetaModel = Admin_Model_Usermeta::getInstance();

        if ($this->_request->isPost()) {
            $userid = $userId;
            $userdata['uname'] = $this->getRequest()->getPost('uname');
            $userdata['email'] = $this->getRequest()->getPost('email');
            $userdata['status'] = $this->getRequest()->getPost('status');
            $usermetadata['first_name'] = $this->getRequest()->getPost('first_name');
            $usermetadata['last_name'] = $this->getRequest()->getPost('last_name');
            $usermetadata['phone'] = $this->getRequest()->getPost('phone');
            $usermetadata['city'] = $this->getRequest()->getPost('city');
            $usermetadata['state'] = $this->getRequest()->getPost('state');
            $usermetadata['country'] = $this->getRequest()->getPost('country');
            $usermetadata['contact_country_code'] = $this->getRequest()->getPost('contact_country_code');
            $result1 = $userModel->updateUserdetails($userid, $userdata);
            $result2 = $usermetaModel->updateUsermetadetails($userid, $usermetadata);
            if ($result1 || $result2) {
                $this->redirect('/admin/userdetails');
            } else {
                $this->view->errormessage = 'user details not updated properly';
            }
        }
        $result = $userModel->getAllUserdetails($userId);

        if ($result) {
            $this->view->alluserdetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV :sowmya
     * Desc : add User Details Action
     * Date : 17/3/2016
     */

    public function addUserDetailsAction() {

        $userModel = Admin_Model_Users::getInstance();
        $usermetaModel = Admin_Model_Usermeta::getInstance();

        if ($this->_request->isPost()) {
            $userdata['uname'] = $this->getRequest()->getPost('uname');
            $userdata['email'] = $this->getRequest()->getPost('email');
            $userdata['status'] = $this->getRequest()->getPost('status');
            $userdata['password'] = $this->getRequest()->getPost('password');
            $userdata['password'] = md5($userdata['password']);
            $userId = $userModel->addUserdetails($userdata);

            $usermetadata['user_id'] = $userId;
            $usermetadata['first_name'] = $this->getRequest()->getPost('first_name');
            $usermetadata['last_name'] = $this->getRequest()->getPost('last_name');
            $usermetadata['phone'] = $this->getRequest()->getPost('phone');
            $usermetadata['city'] = $this->getRequest()->getPost('city');
            $usermetadata['state'] = $this->getRequest()->getPost('state');
            $usermetadata['country'] = $this->getRequest()->getPost('country');
            $usermetadata['contact_country_code'] = $this->getRequest()->getPost('contact_country_code');

            $result2 = $usermetaModel->addUsermetadetails($usermetadata);

            if ($result2) {
                $this->redirect('/admin/userdetails');
            }
        }
    }

    /*
     * DEV :priyanka varanasi
     * Desc : user ajax handler action 
     * Date : 16/12/2015
     */

    public function userAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $userModel = Admin_Model_Users::getInstance();
        $usermetaModel = Admin_Model_Usermeta::getInstance();
        $addtocartModel = Admin_Model_Addtocart::getInstance();
        $userDeliveryAddressModel = Admin_Model_UserDeliveryAddress::getInstance();
        $hotelDetailsModel = Admin_Model_HotelDetails::getInstance();
        $productsModel = Admin_Model_Products::getInstance();
        $agentsModal = Admin_Model_Agents::getInstance();
        $delguyModal = Admin_Model_DeliveryGuys::getInstance();
        $deliveryStatusLogModel = Admin_Model_DeliveryStatusLog::getInstance();
        $userTransModal = Admin_Model_UserTransactions::getInstance();
        $agentTransModal = Admin_Model_AgentTransactions::getInstance();
        $productTransModal = Admin_Model_ProductTransactions::getInstance();
        $orderModal = Admin_Model_Orders::getInstance();
        if ($this->getRequest()->isPost()) {
            $method = $this->getRequest()->getParam('method');

            switch ($method) {
                case 'useractive':
                    $userstate = $this->getRequest()->getParam('userid');
                    $ok = $userModel->getstatustodeactivate($userstate);

                    if ($ok) {
                        echo $userstate;
                    } else {
                        echo "Error";
                    }
                    break;
                // added by sowmya 11/4/2016
                case 'userdelete':
                    $userid = $this->getRequest()->getParam('userid');
                    $result = $userModel->userdelete($userid);
                    if ($result) {
                        $result1 = $usermetaModel->usermetadelete($userid);
                        $result2 = $addtocartModel->addToCartDeleteByUserId($userid);
                        $result3 = $userTransModal->userDeleteByUserId($userid);
                        $result4 = $productTransModal->productDeleteByUserId($userid);
                        $result5 = $orderModal->orderDeleteByUserId($userid);
                        $result6 = $userDeliveryAddressModel->userDeliveryAddressByUserId($userid);
                        echo $result;
                        '<br>';
                        echo $result1;
                        '<br>';
                        echo $result2;
                        '<br>';
                        echo $result3;
                        '<br>';
                        echo $result4;
                        '<br>';
                        echo $result5;
                        '<br>';
                        echo $result6;
                    } else {
                        echo "error";
                    }
                    break;
                case 'agentactive':
                    $userstate = $this->getRequest()->getParam('agentid');
                    $ok = $agentsModal->getstatustodeactivate($userstate);

                    if ($ok) {
                        echo $userstate;
                        return $userstate;
                    } else {
                        echo "Error";
                    }
                    break;
                         // added by sowmya 11/4/2016
                case 'agentdelete':
                    $agentid = $this->getRequest()->getParam('agentid');
                    $result = $agentsModal->agentdelete($agentid);
                    if ($result) {
                        $result1 = $agentTransModal->agentDeleteByAgentId($agentid);
                        $result2 = $hotelDetailsModel->hotelDeleteByAgentId($agentid);
                        $result3 = $productsModel->productDeleteByAgentId($agentid);
                        echo $result;
                        '<br>';
                        echo $result1;
                        '<br>';
                        echo $result2;
                        '<br>';
                        echo $result3;                      
                    } else {
                        echo "error";
                    }
                    break;

                case 'delguystatus':
                    $delguyid = $this->getRequest()->getParam('delguyid');
                    $ok = $delguyModal->getstatustodeactivate($delguyid);

                    if ($ok) {
                        echo $delguyid;
                        return $delguyid;
                    } else {
                        echo "Error";
                    }
                    break;

                case 'delguydelete':
                    $delguyid = $this->getRequest()->getParam('delguyid');
                    $result = $delguyModal->deliveryGuydelete($delguyid);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
                //added by sowmya 30/3/2016
                case 'transdelete':
                    $transid = $this->getRequest()->getParam('transid');
                    $result = $userTransModal->transDelete($transid);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
                //added by sowmya 30/3/2016
                case 'orderdelete':
                    $orderid = $this->getRequest()->getParam('orderid');
                    $result = $orderModal->orderDelete($orderid);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
                //added by sowmya 4/4/2016
                case 'agenttransdelete':
                    $transid = $this->getRequest()->getParam('transid');
                    $result = $agentTransModal->transDelete($transid);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
                //added by sowmya 4/4/2016
                case 'producttransdelete':
                    $transid = $this->getRequest()->getParam('transid');
                    $result = $productTransModal->transDelete($transid);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
                case "OrderStatusChange"://This method is use to change the status of merchant as well as his store.
                    $orderId = $this->_request->getParam('orderId');
                    $orderStatus = $this->_request->getParam('orderStatus');
                    $changed = $orderModal->changeOrderStatus($orderId);
                    if ($changed) {
                        $changed = $orderModal->updateOrderStatus($orderId, $orderStatus);
                        echo 1;
                    } else {
                        echo 0;
                    }
                    break;
            }
        }
    }

    /*
     * DEV :sowmya
     * Desc : edit User Details action
     * Date : 17/3/2016
     */

    public function viewUserDetailsAction() {
        $userModel = Admin_Model_Users::getInstance();
        $userId = $this->getRequest()->getParam("userId");
        $result = $userModel->getAllUserdetails($userId);
        if ($result) {
            $this->view->alluserdetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

}
