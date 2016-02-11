<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Web_OrderController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function orderAjaxHandlerAction() {
        $this->_helper->_layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $method = $this->getRequest()->getParam('ajaxmethod');

        switch ($method) {
            case 'CodPayment':
                $data['pay_type'] = $this->getRequest()->getParam('cod');
                $data['order_id'] = $this->getRequest()->getParam('orderid');
                $data['pay_status'] = 3;
                $data['order_status'] = 1;
                $data['delivery_status'] = 0;
                $url = $this->_appSetting->apiLink . '/order-process?method=updateuserorderdetails';
                $Respo6 = $objCurlHandler->curlUsingPost($url, $data);
                if ($Respo6->code == 200) {
                    $arr['code'] = 200;
                    $arr['message'] = "order is successfull";
                    echo json_encode($arr, true);
                    die();
                } else {
                    $arr['code'] = 198;
                    $arr['message'] = "order Failed";
                    echo json_encode($arr, true);
                    die();
                }

                break;
            default :
                break;
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: TO process the order toward confirmation
     * Date : 19/1/2016
     */

    public function orderConfirmationAction() {
        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        if (isset($this->view->session->storage->user_id)) {
            $user_id = $this->view->session->storage->user_id;
        }

        $hotel_id = $this->getRequest()->getParam('hotel_id');
        $request = $this->getRequest()->getParams('order_id');
        $a1 = explode("=", $request['details']);

        if (!empty($a1[1])) {
            $this->view->orderid = $a1[1];
        }

        if ($hotel_id) {

            $loc['hotel_id'] = $hotel_id;
            $this->view->hotelId = $hotel_id;
            /*             * **** Display of restaurant  details***** */
            $url = $this->_appSetting->apiLink . '/restaurant-info-card?method=gethotelinfo';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $loc);
            if ($curlResponse->code == 200) {
                $this->view->hoteldata = $curlResponse->data;
            }
            /// display cookies products display page
            //
            ////////// cart products display of logged user
            if (isset($_COOKIE['user_cartitems_cookie'])) {
                $cartitems = $_COOKIE['user_cartitems_cookie'];
                $cartitems = stripslashes($cartitems);
                $saved_cart_items = json_decode($cartitems, true);

                $ar['cookies_values'] = json_encode($saved_cart_items, true);
                $ar['hotel_id'] = $hotel_id;
                $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getproductsByCookie';
                $Respo = $objCurlHandler->curlUsingPost($url, $ar);

                if ($Respo->code == 200) {
                    $data['subtotal'] = 0;
                    foreach ($Respo->data as $value) {
                        $data['subtotal']+= $value['cost'];
                    }

                    $this->view->addtocartproducts = $Respo->data;
                    $this->view->total = $data['subtotal'];
                }
            }
        }

        if ($this->getRequest()->isPost()) {
            
            //THEME OF ORDER CONFIRMATION//

            /* 1.user will enter all details like delivery details, and order messages etc
             * 
             * 2.first orders will get insert creating order id and 
             * 
             * 3. second cart prdocts will get insert
             *  
             * 4.Now the orderid and cart ids will get insert in order_product table
             * 
             * 5.while inserting products in order_products table need to check if product has any discout (amount or percentsge) that 
             *   discount will be added and final product cost will be inserted in pay_amount field in order_products table including discount details 
             * 
             * 6.now delivery details will get insert of the particular orderid
             * 
             * 
             * 7.if coupon code exists then that coupon amount will get deducted from SUM(pay_amount) in order_product table
             * and that final amount will get stored in order table 
             */





            ///////// insert order details ///////////
            $orderdata['delivery_type'] = $this->getRequest()->getPost('delivery_type');
            $orderdata['user_message'] = $this->getRequest()->getPost('user_message');
            if (isset($this->view->session->storage->user_id)) {
               
                $user_id = $this->view->session->storage->user_id;
            
                $orderdata['user_id'] = $user_id;

                $orderdata['order_date'] = date('Y-m-d H-i-s');
                $orderdata['delivery_status'] = 0;

                $orderset['orderdata'] = json_encode($orderdata, true);

                $url = $this->_appSetting->apiLink . '/order-process?method=insertwebuserorders';
                $Respo1 = $objCurlHandler->curlUsingPost($url, $orderset);

                if ($Respo1->code == 200) {
                    $order_id = $Respo1->data['order_id'];
                    if ($order_id) {

                        /////// insert cart details ///////////

                        if (isset($_COOKIE['user_cartitems_cookie'])) {
                            $cartitems = $_COOKIE['user_cartitems_cookie'];
                            $cartitems = stripslashes($cartitems);
                            $saved_cart_items = json_decode($cartitems, true);
                            $j = 0;
                            foreach ($saved_cart_items as $value) {
                                $saved_cart_items[$j]['user_id'] = $user_id;
                                $j++;
                            }

                            $bagitems['bagitems'] = json_encode($saved_cart_items, true);

                            $url = $this->_appSetting->apiLink . '/order-process?method=insertwebusercarts';
                            $Respo2 = $objCurlHandler->curlUsingPost($url, $bagitems);

                            if ($Respo2->code == 200) {
                                $cartids = $Respo2->data['cart_ids'];
                                //////// /////// insert order_product details ///////////


                                $k = 0;

                                foreach ($cartids as $value) {
                                    $cartarray[$k] = $value;
                                    $k++;
                                }

                                $bagitems['bagitems'] = json_encode($cartarray, true);

                                $url = $this->_appSetting->apiLink . '/order-process?method=getproductinfoofcarts';
                                $Respo3 = $objCurlHandler->curlUsingPost($url, $bagitems);


                                if ($Respo3->code == 200) {
                                    $finalcost = 0;
                                    $w = 0;
                                    foreach ($Respo3->data as $value) {
                                        $orderproducts[$w]['order_id'] = $order_id;
                                        $orderproducts[$w]['ordered_cart_id'] = $value['id'];
                                        $orderproducts[$w]['product_cost'] = $value['cost'];
                                        $orderproducts[$w]['product_discount'] = $value['product_discount'];
                                        if ($value['product_discount']) {
                                            if ($value['product_discount_type'] = 1) {
                                                $orderproducts[$w]['pay_amount'] = (($value['cost']) * ($value['product_discount'])) / 100;
                                            } else if ($value['product_discount_type'] = 2) {
                                                $orderproducts[$w]['pay_amount'] = $value['cost'] - $value['product_discount'];
                                            } else {
                                                $orderproducts[$w]['pay_amount'] = $value['cost'];
                                            }
                                        } else {

                                            $orderproducts[$w]['pay_amount'] = $value['cost'];
                                        }
                                        if (isset($finalcost)) {
                                            $finalcost+=$orderproducts[$w]['pay_amount'];
                                        } else {

                                            $finalcost+=$orderproducts[$w]['pay_amount'];
                                        }
                                        $orderproducts[$w]['quantity'] = $value['quantity'];
                                        //$orderproducts['coupon_id'] = $value['coupon_id'];
                                        $orderproducts[$w]['hotel_id'] = $value['hotel_id'];
                                        $w++;
                                    }

                                    if ($orderproducts) {
                                        $orproducts['order_products'] = json_encode($orderproducts, true);

                                        $url = $this->_appSetting->apiLink . '/order-process?method=insertuserorderproducts';
                                        $Respo4 = $objCurlHandler->curlUsingPost($url, $orproducts);
                                    }
                                }
                            }
                        }
                        /////// insert delivery details ///////////

                        $delivery['first_name'] = $this->getRequest()->getPost('first_name');
                        $delivery['last_name'] = $this->getRequest()->getPost('last_name');
                        $delivery['Contact_no'] = $this->getRequest()->getPost('Contact_no');
                        $delivery['Contact_email'] = $this->getRequest()->getPost('Contact_email');
                        $delivery['Contact_address'] = $this->getRequest()->getPost('Contact_address');
                        $delivery['city'] = $this->getRequest()->getPost('city');
                        $deliveryaddress['house-no/name'] = $this->getRequest()->getPost('house-no/name');
                        $deliveryaddress['localityaddress'] = $this->getRequest()->getPost('localityaddress');
                        $deliveryaddress['nearby'] = $this->getRequest()->getPost('nearby');
                        $delivery['delivery_addr'] = json_encode($deliveryaddress);
                        $delivery['order_id'] = $order_id;


                        $deliver['deliver'] = json_encode($delivery, true);


                        $url = $this->_appSetting->apiLink . '/order-process?method=insertuserdeliverydetails';
                        $Respo5 = $objCurlHandler->curlUsingPost($url, $deliver);



                        ///////////coupon details and calculation , updating in order table ///////////////
                        $couponcode = $this->getRequest()->getPost('coupon_code');
                        // checking couponcode  with code in coupon table and insert that id in orders table///
                        //deducting the coupon code amount with the total cost of all products in order and  inserting it in total amount in order table//
                        ////updating finalorder amount///////
                        $orderamount['total_amount'] = $finalcost;
                        $orderamount['order_id'] = $order_id;
                        $url = $this->_appSetting->apiLink . '/order-process?method=updateuserorderdetails';
                        $Respo6 = $objCurlHandler->curlUsingPost($url, $orderamount);

                        if ($Respo6->code == 200) {

                            $this->_redirect('/order-confirmation/' . $hotel_id . '/-for-the-restaurant-Chanakya Restrurent-way-to-make-payment&order_id=' . $order_id . '');
                        } else {

                            $this->view->message = 'your order is failed';
                        }
                    } else {
                        $this->view->message = 'your order is failed';
                        // do something if order_id is not present  
                    }
                } else {
                    $this->view->message = 'your order is failed';
                    // do something if order is not get inserted
                }
            }
        }
    }

}
