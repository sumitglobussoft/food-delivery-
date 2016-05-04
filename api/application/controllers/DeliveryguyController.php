<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class DeliveryguyController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
        
    }

    public function deliveryGuyAuthenticationAction() {

        $deliveryguy = Application_Model_DeliveryGuy::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($method) {

            switch ($method) {

                case 'Login':

                    if ($this->getRequest()->isPost()) {

                        $email = $this->getRequest()->getPost('email');
                        $password = $this->getRequest()->getPost('password');

                        if (!empty($email)) {

                            $userData = $deliveryguy->authenticateByEmail($email, md5($password));

                            if ($userData) {
                                $response->message = 'Authentication successful';
                                $response->code = 200;
                                $response->data['deliveryGuy_id'] = $userData['del_guy_id'];
                                $response->data['deliveryGuyName'] = $userData['login_name'];
                                $response->data['email'] = $userData['email'];
                            } else {
                                $response->message = 'Please check your Email or Password.It is Incorrect';
                                $response->code = 197;
                            }
                        } else {
                            $response->message = 'Email cannot be blank';
                            $response->code = 198;
                        }

                        echo json_encode($response, true);
                        die;
                        break;
                    }
            }
        }
    }

    public function deliveryGuyOrderlistAction() {

        $deliveryguy = Application_Model_DeliveryGuy::getInstance();
        $ordersModel = Application_Model_Orders::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($method) {

            switch ($method) {

                case 'FetchOrderList':

                    if ($this->getRequest()->isPost()) {

                        $deliveryguyid = $this->getRequest()->getPost('deliveryGuy_id');

                        $fetchorderlist = $deliveryguy->fetchorderlist($deliveryguyid);

                        if (!empty($fetchorderlist)) {
                            $response->message = 'Successfully Selected All values';
                            $response->code = 200;
                            $response->data = $fetchorderlist;
                        } else {
                            $response->message = 'Request could not be fetched';
                            $response->code = 197;
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "invalid Request";
                    }
                    echo json_encode($response, true);
                    die;
                    break;
                case 'FetchOrderDetails':
                    if ($this->getRequest()->isPost()) {

                        $orderid = $this->getRequest()->getPost('order_id');

                        $getorderdetails = $deliveryguy->getorderDetails($orderid);

                        if (!empty($getorderdetails)) {

                            $response->message = 'Successful';
                            $response->code = 200;
                            $response->data = $getorderdetails;
                        } else {
                            $response->message = 'Request could not be fetched';
                            $response->code = 197;
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "invalid Request";
                    }
                    echo json_encode($response, true);
                    die;
                    break;
                case 'OrderHistory':

                    if ($this->getRequest()->isPost()) {

                        $deliveryguyid = $this->getRequest()->getPost('del_guy_id');
                        $offset = $this->getRequest()->getPost('offset');
                        $limit = $this->getRequest()->getPost('limit');

                        if (!empty($deliveryguyid)) {

                            $fetchorderhistory = $deliveryguy->selecthistoryorder($deliveryguyid, $offset, $limit);

                            if (!empty($fetchorderhistory)) {

                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $fetchorderhistory;
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } else {
                            $response->message = 'UserID Should not be blank';
                            $response->code = 401;
                            $response->data = NULL;
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = Null;
                    }

                    echo json_encode($response, true);
                    die;
                    break;
                case 'UpdateDeliveryStatus':

                    if ($this->getRequest()->isPost()) {

                        $deliverystatus = $this->getRequest()->getPost('order_status');

                        $orderid = $this->getRequest()->getPost('order_id');

                        $deliveryguyid = $this->getRequest()->getPost('deliveryguy_id');

                        if ($deliveryguyid && $orderid) {

                            $update = $ordersModel->updateDeliveryStatus($deliveryguyid, $orderid, $deliverystatus);
                            if ($update) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $update;
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 401;
                            $response->data = NULL;
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = Null;
                    }
                    echo json_encode($response, true);
                    die();
                    break;
            }
        }
    }

}

?>