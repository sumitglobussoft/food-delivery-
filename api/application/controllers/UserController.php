<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';
require_once 'Engine/twilio/Services/Twilio.php';

class UserController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    /* Dev : Priyanka Varanasi
     * Date: 2/12/2015
     * Desc: Users Profile ans settings action
     */

    public function userSettingsAction() {
        
    }

    /*
     * Dev : Sibani Mishra
     * Date: 4/11/2016
     * Desc: User transactions Action
     */

    public function transactionProcessAction() {

        $usertransactionModal = Application_Model_UserTransactions::getInstance();
        $cartiddetailsModel = Application_Model_Addtocart::getInstance();
        $userdeliveryaddrmodal = Application_Model_UserDeliveryAddress::getInstance();
        $orderaddressmodal = Application_Model_OrderAddress::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        $objCore = Engine_Core_Core::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($method) {

            switch ($method) {

                case'inserttransaction':

                    if ($this->getRequest()->isPost()) {

                        $tranType = $this->getRequest()->getPost('transactiontype');

                        if ($tranType == 1) {

                            $orderid = $this->getRequest()->getPost('order_id');
                            $userid = $this->getRequest()->getPost('userid');
                            $tranAmount = $this->getRequest()->getPost('amount');
                            $tranDate = $this->getRequest()->getPost('date');
                            $tranStatus = $this->getRequest()->getPost('status');

                            $cod_code = mt_rand(100000, 999999);

                            $result = array_merge(['order_id' => $orderid], ['user_id' => $userid], ['tx_amount' => $tranAmount], ['tx_date' => $tranDate], ['tx_status' => $tranStatus], ['tx_type' => $tranType], ['COD_Code' => $cod_code]);

                            $transactionId = $usertransactionModal->insertUseTransactions($result);

                            if ($transactionId) {

                                $account_sid = $this->_appSetting->AccountSID;
                                $auth_token = $this->_appSetting->AuthToken;

                                $client = new Services_Twilio($account_sid, $auth_token);

                                $smsResponse = $client->account->messages->create(array(
//                                    'To' => "+919850014148", [dnyaneshwarshinde]
//                                    'To' => "+918763872632", [SibaniMishra]
//                                    'To' => "+917804896925", [NitinGupta]
                                    'To' => "+919713902664", //[AnuradhaK]
//                                    'To' => "+917415300709", [Bala]
                                    'From' => "+17474002298",
                                    'Body' => $cod_code,
                                ));
                                if ($smsResponse) {
                                    $response->message = 'successfully Inserted,SMS Sent to your corresponding Mobile number.';
                                    $response->code = 200;
                                    $response->data['transaction_id'] = $transactionId;
                                } else {
                                    $response->message = 'Fail to send Message';
                                    $response->code = 197;
                                }
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                            }
                        } else if ($tranType == 2) {

                            $orderid = $this->getRequest()->getPost('order_id');
                            $userid = $this->getRequest()->getPost('userid');
                            $tranAmount = $this->getRequest()->getPost('amount');
                            $tranDate = $this->getRequest()->getPost('date');
                            $tranStatus = $this->getRequest()->getPost('status');
                            $trancode = $this->getRequest()->getPost('transactioncode');

                            $cartid = $this->getRequest()->getPost('cartID');
                            $cartid = json_decode($cartid);

                            $data1 = array_merge(['order_id' => $orderid], ['user_id' => $userid], ['tx_amount' => $tranAmount], ['tx_date' => $tranDate], ['tx_status' => $tranStatus], ['tx_type' => $tranType], ['tx_code' => $trancode]);

                            $transactionId1 = $usertransactionModal->insertUseTransactions($data1);

                            if ($transactionId1) {

                                $fetchorderid = $usertransactionModal->fetchorderdetails($transactionId1);

                                if ($fetchorderid['tx_status'] == 1) {

                                    $deletecartiddetails = $cartiddetailsModel->deletecartiddetails($cartid);

                                    if ($deletecartiddetails) {

                                        $response->message = 'successfully Inserted Transaction Details,Cleared From Cart.';
                                        $response->code = 200;
                                        $response->data['transaction_id'] = $transactionId1;
                                    } else {
                                        $response->message = 'Could Not Serve The Request';
                                        $response->code = 197;
                                    }
                                } else {
                                    $response->message = 'Could Not Serve The Request';
                                    $response->code = 197;
                                }
//                                }
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                            }
                        } else {
                            $response->code = 198;
                            $response->message = "Required parameter not passed";
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'updatetransaction':

                    if ($this->getRequest()->isPost()) {

                        $txstatus = $this->getRequest()->getPost('status');
                        if (!empty($txstatus)) {
                            $data['tx_status'] = $txstatus;
                        }
                        $orderid = $this->getRequest()->getPost('order_id');

                        $userid = $this->getRequest()->getPost('userid');

                        if ($userid && $orderid) {
                            $update = $usertransactionModal->updateTransaction($userid, $orderid, $data);
                            if ($update) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $update;
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                                $response->data = $update;
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

//                case 'insertCod_code':
//
//                    if ($this->getRequest()->isPost()) {
//
//                        $postData = $this->getRequest()->getParams();
//
//                        $orderid = '';
//                        if (isset($postData['order_id'])) {
//                            $orderid = $postData['order_id'];
//                        }
//
//                        if ($orderid != '') {
//
//                            $cod_code = mt_rand(100000, 999999);
//
//                            $exists = $usertransactionModal->checkOrderid($orderid, $cod_code);
//
//                            if (isset($exists)) {
//
////                                $account_sid = 'AC91e39267660f124881c6eb071867b1fc';
////                                $auth_token = 'cd5d73f4fef7d4fcb63a57e0558ca8d7';
//                                $account_sid = $this->_appSetting->AccountSID;
//
//                                $auth_token = $this->_appSetting->AuthToken;
//
//                                $client = new Services_Twilio($account_sid, $auth_token);
//
//                                $smsResponse = $client->account->messages->create(array(
////                                    'To' => "+919850014148",
//                                    'To' => "+919713902664",
//                                    'From' => "+17474002298",
//                                    'Body' => $cod_code,
//                                ));
//
//                                $response->code = 200;
//                                $response->message = "SMS Sent to your corresponding Mobile number.";
//                                $response->data = 1;
//                            } else {
//                                $response->code = 100;
//                                $response->message = "OrderId is not correct.";
//                                $response->data = null;
//                            }
//                        } else {
//                            $response->code = 100;
//                            $response->message = "Orderid Should not be null";
//                            $response->data = null;
//                        }
//                    } else {
//                        $response->code = 401;
//                        $response->message = "Invalid request";
//                        $response->data = null;
//                    }
//                    echo json_encode($response, true);
//                    break;

                case 'varifyCod_code':
                    if ($this->getRequest()->isPost()) {

                        $postData = $this->getRequest()->getParams();

                        $orderid = '';
                        if (isset($postData['order_id'])) {
                            $orderid = $postData['order_id'];
                        }

                        $codcode = '';
                        if (isset($postData['COD_Code'])) {
                            $codcode = $postData['COD_Code'];
                        }

                        $cartid = $this->getRequest()->getPost('cartID');
                        $cartid = json_decode($cartid);

                        if ($orderid != '' && $codcode != '' && $cartid != '') {

                            $exists = $usertransactionModal->verifycodCode($orderid, $codcode);

                            if ($exists) {

                                $fetchorderid = $usertransactionModal->fetchorderdetails($orderid);

                                if ($fetchorderid['tx_status'] == 1) {

                                    $deletecartiddetails = $cartiddetailsModel->deletecartiddetails($cartid);

                                    $response->code = 200;
                                    $response->message = "Code Verify Successfully";
                                    $response->data = $exists;
                                } else {
                                    $response->code = 100;
                                    $response->message = "You missed something";
                                    $response->data = null;
                                }
                            } else {
                                $response->code = 100;
                                $response->message = "Code Didnt Matched, Enter Correct Code.";
                                $response->data = null;
                            }
                        } else {

                            $response->code = 401;
                            $response->message = "Invalid request";
                            $response->data = null;
                        }
                    } else {

                        $response->code = 401;
                        $response->message = "Invalid request";
                        $response->data = null;
                    }
                    echo json_encode($response, true);
                    break;

                case 'verifyPhoneNumber':

                    if ($this->getRequest()->isPost()) {

                        $postData = $this->getRequest()->getParams();


                        $addressid = '';
                        if (isset($postData['addressid'])) {
                            $addressid = $postData['addressid'];
                        }

                        $oldphonenumber = '';
                        if (isset($postData['oldContactNo'])) {
                            $oldphonenumber = $postData['oldContactNo'];
                        }

                        $newphonenumber = '';
                        if (isset($postData['newContactNo'])) {
                            $newphonenumber = $postData['newContactNo'];
                        }

                        $fetchdetailsfromBoth = $userdeliveryaddrmodal->fetchDetails($addressid);
                        $orderaddressid = $fetchdetailsfromBoth['order_address_id'];

                        if ($addressid != '') {

                            $fetchaddressdetails = $userdeliveryaddrmodal->fetchUserDeliveryAddressByAddressID($addressid, $oldphonenumber);

                            if ($fetchaddressdetails) {

                                if ($oldphonenumber != '' && $newphonenumber != '') {

                                    $updateData['user_contact_number'] = $newphonenumber;
                                    $whereForUpdate = 'user_delivery_address_id=' . $addressid;

                                    $updateUserDeliveryAddress = $userdeliveryaddrmodal->updateUserDeliveryAddressWhere($updateData, $whereForUpdate);

                                    if (isset($updateUserDeliveryAddress)) {

                                        $updateData['user_contact_number'] = $newphonenumber;
                                        $whereForUpdate = 'order_address_id=' . $orderaddressid;

                                        $updateorderaddress = $orderaddressmodal->updateorderaddressWhere($updateData, $whereForUpdate);

                                        if (isset($updateorderaddress)) {
                                            $response->code = 200;
                                            $response->message = "Your Phone Number Updated Successfully";
                                            $response->data = 1;
                                        } else {
                                            $response->code = 100;
                                            $response->message = "Something Went wrong";
                                            $response->data = null;
                                        }
                                    } else {
                                        $response->code = 100;
                                        $response->message = "Something Went wrong.";
                                        $response->data = null;
                                    }
                                } else {
                                    $response->code = 100;
                                    $response->message = "Missing Parameter";
                                    $response->data = null;
                                }
                            } else {
                                $response->code = 401;
                                $response->message = "Incorrect Old Phone Number";
                                $response->data = null;
                            }
                        } else {
                            $response->code = 100;
                            $response->message = "AddressID Should not be null";
                            $response->data = null;
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Invalid request";
                        $response->data = null;
                    }
                    echo json_encode($response, true);
                    break;
            }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = Null;
            echo json_encode($response);
            die();
        }
    }

    /*
     * Dev: priyanka varanasi
     * Web user order confirmation  process 
     * Date : 4/2/2015
     */

    public function orderProcessAction() {

        $ordersModel = Application_Model_Orders::getInstance();
        $cartsModel = Application_Model_Addtocart::getInstance();
        $productsModel = Application_Model_Products::getInstance();
        $orderproductsModel = Application_Model_OrderProducts::getInstance();
        $deliveryModal = Application_Model_UserDeliveryAddr::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {

            switch ($method) {

                case'insertwebuserorders':

                    if ($this->getRequest()->isPost()) {

                        $orderdata = $this->getRequest()->getPost('orderdata');
                        $order = (array) json_decode($orderdata, true);
                        $orderId = $ordersModel->insertOrders($order);
                        if ($orderId) {
                            $response->message = 'successfull';
                            $response->code = 200;
                            $response->data['order_id'] = $orderId;
                        } else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 197;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die();
                    break;

                case'insertwebusercarts':

                    if ($this->getRequest()->isPost()) {

                        $cartitems = $this->getRequest()->getPost('bagitems');

                        $bagitems = (array) json_decode($cartitems, true);
                        if ($bagitems) {
                            $cartIds = $cartsModel->insertCartProducts($bagitems);
                            if ($cartIds) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['cart_ids'] = $cartIds;
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

                case'getproductinfoofcarts':

                    if ($this->getRequest()->isPost()) {

                        $carts = $this->getRequest()->getPost('bagitems');
                        $bag = (array) json_decode($carts, true);
                        if ($bag) {
                            $result = $cartsModel->getCartProductsByCartIds($bag);
                            if ($result) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $result;
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
                case'insertuserorderproducts':

                    if ($this->getRequest()->isPost()) {

                        $order_products = $this->getRequest()->getPost('order_products');
                        $order_productsnew = (array) json_decode($order_products, true);
                        if ($order_productsnew) {

                            $result = $orderproductsModel->insertOrderedCartProducts($order_productsnew);
                            if ($result) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $result;
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
                case'insertuserdeliverydetails':

                    if ($this->getRequest()->isPost()) {

                        $delivery = $this->getRequest()->getPost('deliver');
                        $deliverynew = (array) json_decode($delivery, true);
                        if ($deliverynew) {
                            $result = $deliveryModal->insertUserDeliveryAddress($deliverynew);
                            if ($result) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $result;
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
                case'updateuserorderdetails':

                    if ($this->getRequest()->isPost()) {
                        $total_amount = $this->getRequest()->getPost('total_amount');
                        if (!empty($total_amount)) {
                            $data['total_amount'] = $total_amount;
                        }
                        $pay_type = $this->getRequest()->getPost('pay_type');
                        if (!empty($pay_type)) {
                            $data['pay_type'] = $pay_type;
                        }
                        $pay_status = $this->getRequest()->getPost('pay_status');
                        if (!empty($pay_status)) {
                            $data['pay_status'] = $pay_status;
                        }
                        $order_status = $this->getRequest()->getPost('order_status');
                        if (!empty($order_status)) {
                            $data['order_status'] = $order_status;
                        }
                        $delivery_status = $this->getRequest()->getPost('delivery_status');
                        if (!empty($delivery_status)) {
                            $data['delivery_status'] = $delivery_status;
                        }
                        $order_id = $this->getRequest()->getPost('order_id');
                        if ($order_id && $data) {
                            $result = $ordersModel->updateOrderDetails($data, $order_id);
                            if ($result) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $order_id;
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

                case'updatepaymenttypedetails':

                    if ($this->getRequest()->isPost()) {

                        $order['pay_status'] = $this->getRequest()->getPost('pay_status');
                        $order['order_status'] = $this->getRequest()->getPost('order_status');
                        $order['delivery_status'] = $this->getRequest()->getPost('delivery_status');
                        $order['pay_type'] = $this->getRequest()->getPost('pay_type');
                        $order_id = $this->getRequest()->getPost('order_id');
                        if ($order && $order_id) {
                            $result = $ordersModel->updateOrderDetails($order, $order_id);
                            if ($result) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $order_id;
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
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = Null;
            echo json_encode($response);
            die();
        }
    }

}

?>