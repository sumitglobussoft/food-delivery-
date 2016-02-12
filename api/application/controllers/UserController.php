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

    public function userSettingsAction() {
        
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 3/12/2015
     * Desc: User transactions Action
     */

    public function transactionProcessAction() {

        $usertransactionModal = Application_Model_UserTransactions::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {

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

                        $transactionId = $usertransactionModal->insertUseTransactions($data);
                        if ($transactionId) {
                            $response->message = 'successfull';
                            $response->code = 200;
                            $response->data['transaction_id'] = $transactionId;
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
                        $bag = (array)json_decode($carts, true);
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
                            $result = $ordersModel->updateOrderDetails($data,$order_id);
                            if ($result) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data =$order_id ;
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
                            $result = $ordersModel->updateOrderDetails($order,$order_id);
                            if ($result) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data =$order_id ;
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