<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class OrdersController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 3/12/2015
     * Desc: User delivery address settings insert and update
     */

    public function userDeliverySettingsAction() {
        $userdeliveryaddrmodal = Application_Model_UserDeliveryAddr::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {
            switch ($method) {

                case'insertdeliveryaddress':

                    if ($this->getRequest()->isPost()) {

                        $data['user_id'] = $this->getRequest()->getPost('userid');
                        $data['city'] = $this->getRequest()->getPost('city');
                        $data['state'] = $this->getRequest()->getPost('state');
                        $data['country'] = $this->getRequest()->getPost('country');
                        $data['landmark'] = $this->getRequest()->getPost('landmark');
                        $data['delivery_addr'] = $this->getRequest()->getPost('address');
                        $data['order_id'] = $this->getRequest()->getPost('order_id');
                        $data['delivery_time'] = $this->getRequest()->getPost('deliverytime');
                        if ([$data['user_id']]) {

                            $userdelid = $userdeliveryaddrmodal->insertUserDeliveryAddress($data);
                            if ($userdelid) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $userdelid;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        } else {
                            $response->message = 'Invalid Request';
                            $response->code = 401;
                            $response->data = NUll;
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die();
                    break;


                case'updatedeliveryaddress':

                    if ($this->getRequest()->isPost()) {


                        $landmark = $this->getRequest()->getPost('landmark');
                        if (!empty($landmark)) {
                            $data['landmark'] = $landmark;
                        }

                        $orderid = $this->getRequest()->getPost('order_id');
                        if (!empty($orderid)) {
                            $data['order_id'] = $orderid;
                        }

                        $deliverytime = $this->getRequest()->getPost('deliverytime');
                        if (!empty($deliverytime)) {
                            $data['delivery_time'] = $deliverytime;
                        }

                        $city = $this->getRequest()->getPost('city');
                        if (!empty($city)) {
                            $data['city'] = $city;
                        }

                        $state = $this->getRequest()->getPost('state');
                        if (!empty($state)) {
                            $data['state'] = $state;
                        }

                        $country = $this->getRequest()->getPost('country');
                        if (!empty($country)) {
                            $data['country'] = $country;
                        }

                        $address = $this->getRequest()->getPost('address');
                        if (!empty($address)) {
                            $data['delivery_addr'] = $address;
                        }
                        $addressid = $this->getRequest()->getPost('addressid');
                        $userid = $this->getRequest()->getPost('userid');
                        if ($userid && $addressid) {
                            $update = $userdeliveryaddrmodal->updateUserDeliveryAddress($userid, $addressid, $data);
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
                    die;
                    break;
            }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = 'No Method';

            echo json_encode($response);
            die();
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 10/12/2015
     * Desc: fetch all products from db
     */

    public function productsSummaryAction() {
        $productsummaryModel = Application_Model_Products::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {

            switch ($method) {

                case'allproducts':

                    $productdetails = $productsummaryModel->selectAllProducts();
                    if ($productdetails) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $productdetails;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'getagentproducts':

                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agentproducts = $productsummaryModel->getALLAgentProducts($agent_id);
                            if ($agentproducts) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentproducts;
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
                    die;
                    break;


                case'getProductsByHotelId':

                    if ($this->getRequest()->isPost()) {

                        $hotelid = $this->getRequest()->getPost('hotel_id');

                        if ($hotelid) {
                            $agentproducts = $productsummaryModel->getProductsByHotelId($hotelid);
                            if ($agentproducts) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentproducts;
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
                    die;
                    break;


                case'changeproductstatus':
                    if ($this->getRequest()->isPost()) {

                        $product_id = $this->getRequest()->getPost('product_id');

                        if ($product_id) {
                            $updatestatus = $productsummaryModel->getstatusChangeOfProduct($product_id);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['product_id'] = $product_id;
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
                    die;

                    break;

                case'productdelete':
                    if ($this->getRequest()->isPost()) {

                        $product_id = $this->getRequest()->getPost('product_id');

                        if ($product_id) {
                            $updatestatus = $productsummaryModel->productDelete($product_id);

                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['product_id'] = $product_id;
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
                    die;

                    break;
            }
        } else {

            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = "No Method Passed";
            echo json_encode($response, true);
            die();
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 10/12/2015
     * Desc: Insert all orders in db
     * Modified Date: 22/1/2016
     * Desc : Modified insert order service including delivery address and order products 
     */

    public function ordersAction() {
        $ordersModel = Application_Model_Orders::getInstance();
        $userdeliveryaddrmodal = Application_Model_UserDeliveryAddr::getInstance();
        $orderproductsmodal = Application_Model_OrderProducts::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {

            switch ($method) {
                case'insertorders':
                    if ($this->getRequest()->isPost()) {
                        $data['user_id'] = $this->getRequest()->getPost('userid');
                        $totalamount = $this->getRequest()->getPost('totalamount');
                        if ($totalamount) {
                            $data['total_amount'] = $this->getRequest()->getPost('totalamount');
                        }
                        $data['pay_status'] = 0;
                        $data['order_status'] = 4;
                        $data['order_date'] = date('Y-m-d H-i-s');
                        if ($data['user_id']) {
                            $insertedorderid = $ordersModel->insertOrders($data);
                            if ($insertedorderid) {

                                $dat['fullname'] = $this->getRequest()->getPost('fullname');
                                $dat['phone_no'] = $this->getRequest()->getPost('phonenum');
                                $dat['address'] = $this->getRequest()->getPost('address');
                                $dat['cityname'] = $this->getRequest()->getPost('cityname');
                                $dat['statename'] = $this->getRequest()->getPost('statename');
                                $dat['countryname'] = $this->getRequest()->getPost('countryname');
                                $dat['landMark'] = $this->getRequest()->getPost('landMark');
                                $info['ordered_user_id'] = $this->getRequest()->getPost('userid');
                                $info['order_id'] = $insertedorderid;
                                $info['delivery_addr'] = json_encode($dat, true);

                                $userdelid = $userdeliveryaddrmodal->insertUserDeliveryAddress($info);
                                if ($userdelid) {
                                    $cartids = $this->getRequest()->getPost('cartids');
                                    if ($cartids) {
                                        $carts = json_decode($cartids, true);
                                        $i = 0;
                                        foreach ($carts as $val) {
                                            $da[$i]['order_id'] = $insertedorderid;
                                            $da[$i]['ordered_cart_id'] = $val;
                                            $i++;
                                        }
                                        $arrayofIds = $orderproductsmodal->insertOrderedCartProducts($da);
                                        if ($arrayofIds) {

                                            $response->message = 'successfull';
                                            $response->code = 200;
                                            $response->data['order_id'] = $insertedorderid;
                                            $response->data['delivery_id'] = $userdelid;
                                            $response->data['ordered_product_ids'] = $arrayofIds;
                                        } else {
                                            $response->message = 'successfull, but issues with the  cart products';
                                            $response->code = 400;
                                            $response->data['order_id'] = $insertedorderid;
                                            $response->data['delivery_id'] = $userdelid;
                                        }
                                    } else {
                                        $response->message = 'successfull,carts ids null given';
                                        $response->code = 400;
                                        $response->data['order_id'] = $insertedorderid;
                                        $response->data['delivery_id'] = $userdelid;
                                    }
                                } else {
                                    $response->message = 'order successfully get inserted, but issues with delivery address';
                                    $response->code = 400;
                                    $response->data['order_id'] = $insertedorderid;
                                }
                            } else {
                                $response->message = 'Failed order';
                                $response->code = 197;
                                $response->data['order_id'] = null;
                            }
                        } else {
                            $response->message = 'Could Not Serve The Request,user id is required';
                            $response->code = 198;
                            $response->data = null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;
                    break;
            }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = "No Method Passed";
            echo json_encode($response, true);
            die();
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 10/12/2015
     * Desc: fetch all hotel details from db
     */

    public function hotelsSummaryAction() {
        $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
        $deliverystatusmodal = Application_Model_DeliveryStatusLog::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {

            switch ($method) {

                case'allhotels':

//         $hoteldetails = $hotelssummaryModel->selectAllHotels(); 
                    $hoteldetails = $hotelssummaryModel->selectAllHotelsLocations();
                    if ($hoteldetails) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $hoteldetails;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;


                case'getorderstatus':
                    if ($this->getRequest()->isPost()) {

                        $order_id = $this->getRequest()->getPost('order_id');

                        if ($order_id) {
                            $statusdetails = $deliverystatusmodal->getOrderStatus($order_id);
                            if ($statusdetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $statusdetails;
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
                    die;

                    break;


                case'getHotelDetailsByAgentId':
                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agenthoteldetails = $hotelssummaryModel->getHoteldetails($agent_id);
                            if ($agenthoteldetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agenthoteldetails;
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
                    die;

                    break;

                case'changehotelstatus':
                    if ($this->getRequest()->isPost()) {

                        $hotel_id = $this->getRequest()->getPost('hotel_id');

                        if ($hotel_id) {
                            $updatestatus = $hotelssummaryModel->getstatusChangeOfHotel($hotel_id);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['hotel_id'] = $hotel_id;
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
                    die;

                    break;

                case'hoteldelete':
                    if ($this->getRequest()->isPost()) {

                        $hotel_id = $this->getRequest()->getPost('hotel_id');

                        if ($hotel_id) {
                            $updatestatus = $hotelssummaryModel->hotelDelete($hotel_id);

                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['hotel_id'] = $hotel_id;
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
                    die;

                    break;
                case'getHotelDetailsByHotelId':
                    if ($this->getRequest()->isPost()) {

                        $hotel_id = $this->getRequest()->getPost('hotel_id');

                        if ($hotel_id) {
                            $hoteldetails = $hotelssummaryModel->getHoteldetailsByHotelId($hotel_id);
                            if ($hoteldetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $hoteldetails;
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
                    die;

                    break;

                case'updatehoteldetails':
                    if ($this->getRequest()->isPost()) {


                        $hotel_id = $this->getRequest()->getPost('id');
                        $ownername = $this->getRequest()->getPost('owner_fname');
                        if (!empty($ownername)) {
                            $data['owner_fname'] = $ownername;
                        }

                        $ownerlname = $this->getRequest()->getPost('owner_lname');
                        if (!empty($ownelname)) {
                            $data['owner_lname'] = $ownerlname;
                        }
                        $primary_phone = $this->getRequest()->getPost('primary_phone');
                        if (!empty($primary_phone)) {
                            $data['primary_phone'] = $primary_phone;
                        }

                        $secondary_phone = $this->getRequest()->getPost('secondary_phone');
                        if (!empty($secondary_phone)) {
                            $data['secondary_phone'] = $secondary_phone;
                        }

                        $hotel_name = $this->getRequest()->getPost('hotel_name');
                        if (!empty($hotel_name)) {
                            $data['hotel_name'] = $hotel_name;
                        }
                        $open_time = $this->getRequest()->getPost('open_time');
                        if (!empty($open_time)) {
                            $data['open_time'] = $open_time;
                        }

                        $hotel_status = $this->getRequest()->getPost('hotel_status');
                        if (!empty($hotel_status)) {
                            $data['hotel_status'] = $hotel_status;
                        }

                        $closing_time = $this->getRequest()->getPost('closing_time');
                        if (!empty($closing_time)) {
                            $data['closing_time'] = $closing_time;
                        }
                        $notice = $this->getRequest()->getPost('notice');
                        if (!empty($notice)) {
                            $data['notice'] = $notice;
                        }
                        $hotel_image = $this->getRequest()->getPost('hotel_image');
                        if (!empty($hotel_image)) {
                            $data['hotel_image'] = $hotel_image;
                        }

                        if ($hotel_id) {
                            $updatestatus = $hotelssummaryModel->updateHotelDetails($hotel_id, $data);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $updatestatus;
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
                    die;

                    break;

                case'addhoteldetails':
                    if ($this->getRequest()->isPost()) {

                        $data['primary_phone'] = $this->getRequest()->getPost('primary_phone');
                        $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
                        $data['hotel_name'] = $this->getRequest()->getPost('hotel_name');
                        $data['open_time'] = $this->getRequest()->getPost('open_time');
                        $data['closing_time'] = $this->getRequest()->getPost('closing_time');
                        $data['notice'] = $this->getRequest()->getPost('notice');
                        $data['address'] = $this->getRequest()->getPost('address');
                        $data['minorder'] = $this->getRequest()->getPost('minorder');
                        $data['deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
                        $data['hotel_status'] = $this->getRequest()->getPost('hotel_status');
                        $data['hotel_location'] = $this->getRequest()->getPost('hotel_location');
                        $data['agent_id'] = $this->getRequest()->getPost('agent_id');
                        if ($data['agent_id']) {
                            $updatestatus = $hotelssummaryModel->insertHotelDetails($data);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['hotel_id'] = $updatestatus;
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
                    die;
                    break;
            }
        } else {

            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = "No Method Passed";
            echo json_encode($response, true);
            die();
        }
    }

    /*
     * Dev:Sibani Mishra
     * Date:12/01/2016
     * Desc:Insert all orders details in addtocart table
     */

    public function addtoCartSummaryAction() {

        $Addtocart = Application_Model_Addtocart::getInstance();
        $objProducts = Application_Model_Products::getInstance();


        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {
            switch ($method) {
                case 'InsertOrdersToCart':
                    if ($this->getRequest()->isPost()) {
                        $data['user_id'] = $this->getRequest()->getPost('userid');
                        $data['product_id'] = $this->getrequest()->getPost('productid');
                        $data['hotel_id'] = $this->getRequest()->getPost('hotelid');
                        $data['quantity'] = $this->getRequest()->getPost('quantity');

                        if ($data['user_id'] && $data['hotel_id']) {
                            $productexists = $Addtocart->checkProductifExists($data['user_id'], $data['product_id'], $data['hotel_id']);
                            if ($productexists) {
                                $array = array('product_id' => $data['product_id'],
                                    'hotel_id' => $data['hotel_id']);
                                $response->message = 'Product Already Exists';
                                $response->code = 198;
                                $response->data = $array;
                            } else {
                                $result = $Addtocart->insertCartProducts($data);
                                if ($result) {
                                    if (!is_null($result)) {
                                        $response->message = 'successfull';
                                        $response->code = 200;
                                        $response->data['cart_id'] = $result['cart_id'];
                                        $response->data['total'] = $result['total'];
                                    }
                                } else {
                                    $response->message = 'Could Not Serve The Request';
                                    $response->code = 197;
                                    $response->data = null;
                                }
                            }
                        } else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 401;
                            $response->data = NULL;
                        }
                        echo json_encode($response, true);
                        die;
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = Null;
                        echo json_encode($response, true);
                        die;
                    }
                    break;
                /*
                 * Dev : Nitin Kumar Gupta
                 * Desc : To insert the new cart product in table and update the existing cart product in table.
                 * Date : 19 FEB 2016
                 */
                case 'InsertUpdateAllOrdersToCart':
                    if ($this->getRequest()->isPost()) {
                        $user_id = $this->getRequest()->getPost('userid');
                        $hotel_id = $this->getRequest()->getPost('hotelid');
                        $product_id = (array) json_decode($this->getrequest()->getPost('productid'), true);
                        $quantity = (array) json_decode($this->getrequest()->getPost('quantity'), true);

                        if ($user_id && $hotel_id && !empty($product_id) && !empty($quantity)) {

                            if (sizeof($product_id) == sizeof($quantity)) {

                                $availableOrNot = $objProducts->seperateTheProductsByQuantityAvailablity($product_id, $quantity);

                                if (is_array($availableOrNot) && !empty($availableOrNot)) {

                                    if (array_key_exists('success', $availableOrNot)) {

                                        $updatedAndInsertedProduct = $Addtocart->insertUpdateProductInCart($user_id, $hotel_id, $availableOrNot['success'], $availableOrNot['quantity']);

                                        if (is_array($updatedAndInsertedProduct) && !empty($updatedAndInsertedProduct)) {

                                            $availableOrNot['success'] = $updatedAndInsertedProduct;
                                            unset($availableOrNot['quantity']);

                                            $response->message = 'Successfully inserted or updated the product in cart.';
                                            $response->code = 200;
                                            $response->data = $availableOrNot;
                                        } else {
                                            $response->message = $updatedAndInsertedProduct;
                                            $response->code = 198;
                                            $response->data = Null;
                                        }
                                    } else {

                                        $response->message = 'All requested product has been out of stocks.';
                                        $response->code = 200;
                                        $response->data = $availableOrNot;
                                    }
                                } else {
                                    $response->message = $availableOrNot;
                                    $response->code = 198;
                                    $response->data = Null;
                                }
                            } else {
                                $response->message = 'The number of product and quantity in array should be same.';
                                $response->code = 195;
                                $response->data = NULL;
                            }
                        } else {
                            $response->message = 'You should enter all params.';
                            $response->code = 195;
                            $response->data = NULL;
                        }
                    } else {
                        $response->message = 'You should use the post method';
                        $response->code = 195;
                        $response->data = Null;
                    }

                    echo json_encode($response, true);
                    die;
                    break;


                case 'BulkInsertOrdersToCart':
                    if ($this->getRequest()->isPost()) {

                        $carts = $this->getRequest()->getPost('cart_items');
                        $cartitems = (array) json_decode($carts, true);
                        if ($cartitems) {
                            foreach ($cartitems as $value) {
                                $result = $Addtocart->insertCartProducts($value);
                                if ($result) {
                                    if (!is_null($result)) {
                                        $arr[] = $result;
                                        $response->message = 'successfull';
                                        $response->code = 200;
                                        $response->data['cart_id'] = $arr;
                                    }
                                } else {
                                    $response->message = 'Could Not Serve The Request';
                                    $response->code = 197;
                                    $response->data = null;
                                }
                            }
                        } else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 197;
                            $response->data = null;
                        }
                        echo json_encode($response, true);
                        die;
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = Null;
                        echo json_encode($response, true);
                        die;
                    }
                    break;
                /*
                * Modyfied By : Nitin Kumar Gupta
                * Modyfied Date : 20 FEB 2016
                */
                case 'getOrderToCart':

                    if ($this->getRequest()->isPost()) {
                        $user_id = $this->getRequest()->getPost('user_id');
                        $hotel_id = $this->getRequest()->getPost('hotel_id');
                        
                        if ($user_id && $hotel_id) {
                            $getaddtocartdetails = $Addtocart->getaddtocart($user_id, $hotel_id);

                            if ($getaddtocartdetails) {

                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $getaddtocartdetails;
                                echo json_encode($response, true);
                                die;
                            } else {
                                $response->message = 'No Products available';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } else {
                            $response->message = 'parametre not passed';
                            $response->code = 197;
                            $response->data = null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;
                    break;

                case'getCartProductsByIds';

                    if ($this->getRequest()->isPost()) {
                        $user_id = $this->getRequest()->getPost('user_id');
                        $hotel_id = $this->getRequest()->getPost('hotel_id');
                        if ($user_id && $hotel_id) {
                            $getaddtocartdetails = $Addtocart->getCartProductsByHotelIds($user_id, $hotel_id);
                            if ($getaddtocartdetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $getaddtocartdetails;
                                echo json_encode($response, true);
                                die;
                            } else {
                                $response->message = 'Could Not Serve The Request completely';
                                $response->code = 197;
                                $response->data = null;
                            }
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
                    echo json_encode($response, true);
                    die;
                    break;

                case 'RemoveOrderToCart':
                    if ($this->getRequest()->isPost()) {

                        $addtocartSerialNo = $this->getRequest()->getPost('cart_id');
                        $user_id = $this->getRequest()->getPost('user_id');

                        if ($addtocartSerialNo && $user_id) {
                            $cartdetails = $Addtocart->RemoveAddtocartorder($addtocartSerialNo, $user_id);

                            if ($cartdetails) {

                                $response->message = 'successfully Deleted';
                                $response->code = 200;
                                $response->data = $cartdetails;
                                echo json_encode($response, true);
                                die();
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
                    die;
                    break;
                /*
                 * Dev : Priyanka Varanasi
                 * Date: 18/1/2016
                 * Desc: update cart
                 */
                case 'updateuserscart':

                    if ($this->getRequest()->isPost()) {
                        $productid = $this->getRequest()->getPost('productid');
                        $hotelid = $this->getRequest()->getPost('hotelid');
                        $inf['quantity'] = $this->getRequest()->getPost('quantity');
                        $userid = $this->getRequest()->getPost('userid');
                        $cost = $this->getRequest()->getPost('cost');
                        if ($productid && $userid && $cost && $hotelid) {
                            $respo = $Addtocart->updateCart($userid, $productid, $inf, $cost, $hotelid);
                            if ($respo) {
                                if (!is_null($respo)) {
                                    $response->message = 'successfully updated';
                                    $response->code = 200;
                                    $response->data = $respo;
                                    echo json_encode($response, true);
                                    die();
                                }
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
                    die;
                    break;

                /*
                 * Dev : Priyanka Varanasi
                 * Date: 18/1/2016
                 * Desc: delete cart
                 */
                case 'deleteitem':

                    if ($this->getRequest()->isPost()) {
                        $productid = $this->getRequest()->getPost('productid');
                        $hotelid = $this->getRequest()->getPost('hotelid');
                        $userid = $this->getRequest()->getPost('userid');
                        if ($productid && $userid && $hotelid) {
                            $res = $Addtocart->deleteItem($userid, $productid, $hotelid);
                            if ($res) {
                                if (!is_null($res)) {
                                    $response->message = 'successfully updated';
                                    $response->code = 200;
                                    $response->data = $res;
                                    echo json_encode($response, true);
                                    die();
                                }
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
                    die;
                    break;
            }
        } else {

            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = "No Method Passed";
            echo json_encode($response, true);
            die();
        }
    }

}

?>
