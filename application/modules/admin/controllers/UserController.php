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
//            $usermetadata['address'] = $this->getRequest()->getPost('address');

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
        $agentsModal = Admin_Model_Agents::getInstance();
        $delguyModal = Admin_Model_DeliveryGuys::getInstance();
        $userTransModal = Admin_Model_UserTransactions::getInstance();
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
                case 'userdelete':
                    $userid = $this->getRequest()->getParam('userid');
                    $result = $userModel->userdelete($userid);
                    if ($result) {
                        echo $result;
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
                case 'agentdelete':
                    $agentid = $this->getRequest()->getParam('agentid');
                    $result = $agentsModal->agentdelete($agentid);
                    if ($result) {
                        echo $result;
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
            }
        }
    }

}
