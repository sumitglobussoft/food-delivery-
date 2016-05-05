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

    /*
     * Dev : Sibani Mishra
     * Date: 20/3/2016
     * Desc: Modified User delivery address settings insert and update and fetch
     */

    public function userDeliverySettingsAction() {
        $userdeliveryaddrmodal = Application_Model_UserDeliveryAddress::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {

                case'insertdeliveryaddress':

                    if ($this->getRequest()->isPost()) {


                        $userid = $this->getRequest()->getPost('userid');
                        if (!empty($userid)) {
                            $data['ordered_user_id'] = $userid;
                        }

                        $uname = $this->getRequest()->getPost('uname');
                        if (!empty($uname)) {
                            $data['user_name'] = $uname;
                        }

                        $landmark = $this->getRequest()->getPost('landmark');
                        if (!empty($landmark)) {
                            $data['landmark'] = $landmark;
                        }

                        $Location = $this->getRequest()->getPost('location');
                        if (!empty($Location)) {
                            $data['Location'] = $Location;
                        }

                        $contact_country_code = $this->getRequest()->getPost('contactcountrycode');
                        if (!empty($contact_country_code)) {
                            $data['contact_country_code'] = $contact_country_code;
                        }

                        $contact_number = $this->getRequest()->getPost('contactnumber');
                        if (!empty($contact_number)) {
                            $data['user_contact_number'] = $contact_number;
                        }

                        $address_line1 = $this->getRequest()->getPost('address');
                        if (!empty($address_line1)) {
                            $data['address_line1'] = $address_line1;
                        }

                        $data['address_line2'] = $this->getRequest()->getPost('optionaladdress');

                        $district = $this->getRequest()->getPost('district');
                        if (!empty($district)) {
                            $data['district'] = $district;
                        }

                        $state = $this->getRequest()->getPost('state');
                        if (!empty($state)) {
                            $data['state'] = $state;
                        }

                        $country = $this->getRequest()->getPost('country');
                        if (!empty($country)) {
                            $data['country'] = $country;
                        }

                        $pin = $this->getRequest()->getPost('pin');
                        if (!empty($pin)) {
                            $data['pin'] = $pin;
                        }

                        if ($userid) {

                            $select = $userdeliveryaddrmodal->selectuserid($userid);

                            if ($select <= 2) {

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
                                $response->message = 'You cannot Insert for same userid More than 3 Address.U can Edit it';
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


                        $userid = $this->getRequest()->getPost('userid');

                        $addressid = $this->getRequest()->getPost('addressid');

                        $uname = $this->getRequest()->getPost('uname');
                        if (!empty($uname)) {
                            $data['user_name'] = $uname;
                        }

                        $landmark = $this->getRequest()->getPost('landmark');
                        if (!empty($landmark)) {
                            $data['landmark'] = $landmark;
                        }

                        $location = $this->getRequest()->getPost('location');
                        if (!empty($location)) {
                            $data['Location'] = $location;
                        }

                        $contactcountrycode = $this->getRequest()->getPost('contactcountrycode');
                        if (!empty($contactcountrycode)) {
                            $data['contact_country_code'] = $contactcountrycode;
                        }

                        $contactnumber = $this->getRequest()->getPost('contactnumber');
                        if (!empty($contactnumber)) {
                            $data['user_contact_number'] = $contactnumber;
                        }

                        $address = $this->getRequest()->getPost('address');
                        if (!empty($address)) {
                            $data['address_line1'] = $address;
                        }

                        $optionaladdress = $this->getRequest()->getPost('optionaladdress');
                        if (!empty($optionaladdress)) {
                            $data['address_line2'] = $optionaladdress;
                        }

                        $district = $this->getRequest()->getPost('district');
                        if (!empty($district)) {
                            $data['district'] = $district;
                        }

                        $state = $this->getRequest()->getPost('state');
                        if (!empty($state)) {
                            $data['state'] = $state;
                        }

                        $country = $this->getRequest()->getPost('country');
                        if (!empty($country)) {
                            $data['country'] = $country;
                        }

                        $pin = $this->getRequest()->getPost('pin');
                        if (!empty($pin)) {
                            $data['pin'] = $pin;
                        }



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

                case 'fetchdeliveryaddress':
                    if ($this->getRequest()->isPost()) {



                        $userid = $this->getRequest()->getPost('userid');

                        if ($userid) {

                            $update = $userdeliveryaddrmodal->fetchUserDeliveryAddress($userid);

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

                case 'removedeliveryaddress':
                    if ($this->getRequest()->isPost()) {
                        $userid = $this->getRequest()->getPost('userid');
                        $addressid = $this->getRequest()->getPost('addressid');

                        if ($userid && $addressid) {

//                            $removedeliveryaddress = $userdeliveryaddrmodal->removeUserDeliveryAddress($userid, $addressid);
                            $removedeliveryaddress = $userdeliveryaddrmodal->removeUserDeliveryAddress($addressid);

                            if ($removedeliveryaddress) {
                                $response->message = 'Successfully Deleted';
                                $response->code = 200;
                                $response->data = $removedeliveryaddress;
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
     * Dev : Sibani Mishra
     * Desc: Insert/Fetch/Status of all orders 
     * Date: 23/3/2016
     */

    public function ordersAction() {

        $ordersModel = Application_Model_Orders::getInstance();
        $cartiddetailsModel = Application_Model_Addtocart::getInstance();
        $orderaddressModel = Application_Model_OrderAddress::getInstance();
        $userdeliveryaddresssModel = Application_Model_UserDeliveryAddress::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {

                case'insertorders':

                    if ($this->getRequest()->isPost()) {

                        $addressId = $this->getRequest()->getPost('addressid');
                        $cartid = $this->getRequest()->getPost('cartid');
                        $cartid = json_decode($cartid);
//                        $cartid = explode(',', $cartid);

                        $fetchcartiddetails = $cartiddetailsModel->selectcartiddetails($cartid);
                        if (!empty($fetchcartiddetails)) {
                            $productId = array();
                            $quantity = array();
                            foreach ($fetchcartiddetails as $key => $value) {
                                $productId[] = $value['product_id'];
                                $quantity[] = $value['quantity'];
                            }
                            $data['user_id'] = $fetchcartiddetails[0]['user_id'];
                            $data['total_amount'] = $this->getRequest()->getPost('totalamount');
                            $data['hotel_id'] = $fetchcartiddetails[0]['hotel_id'];
                            $data['quantity'] = json_encode($quantity);
                            $data['product_id'] = json_encode($productId);
                            $data['product_amount'] = $this->getRequest()->getPost('productamount');
                            $data['product_amount'] = json_decode($data['product_amount']);
                            $data['product_amount'] = json_encode($data['product_amount']);
                            $data['delivery_charge'] = $this->getRequest()->getPost('deliverycharge');


                            $insertorderid = $ordersModel->insertOrders($data);

                            if ($insertorderid) {

                                $selectuserdeliveryaddress = $userdeliveryaddresssModel->selectUserDeliveryAddress($addressId);

                                unset($selectuserdeliveryaddress['user_delivery_address_id']);
                                unset($selectuserdeliveryaddress['ordered_user_id']);

                                $selectuserdeliveryaddress['order_id'] = $insertorderid;

                                $insertorderaddress = $orderaddressModel->insertorderaddress($selectuserdeliveryaddress);


                                if ($insertorderaddress) {

                                    $response->message = 'successfull';
                                    $response->code = 200;
                                    $response->data['order_id'] = $insertorderid;
//                                    $response->data['order_address_id'] = $insertorderaddress;
                                } else {
                                    $response->message = 'Fail';
                                    $response->code = 197;
                                }
                            } else {
                                $response->message = 'Fail';
                                $response->code = 197;
                            }
                        } else {

                            $response->message = 'CartId Should not be blank.';
                            $response->code = 401;
                            $response->data = Null;
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = Null;
                    }
                    echo json_encode($response, true);
                    die;
                    break;

                case 'historyorders':

                    if ($this->getRequest()->isPost()) {

                        $userid = $this->getRequest()->getPost('user_id');
                        $offset = $this->getRequest()->getPost('offset');
                        $limit = $this->getRequest()->getPost('limit');

                        if (!empty($userid)) {

                            $fetchorderhistory = $ordersModel->selecthistoryorder($userid, $offset, $limit);

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

                case 'orderstatus':

                    if ($this->getRequest()->isPost()) {

                        $orderid = $this->getRequest()->getPost('order_id');
//                        echo '<pre>';
//                        print_r($orderid);
//                        die("Test");
                        if (!empty($orderid)) {

                            $fetchorderstatus = $ordersModel->selectorderstatus($orderid);
//                            echo '<pre>';
//                            print_r($fetchorderstatus);
//                            die("Test");
                            if (!empty($fetchorderstatus)) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $fetchorderstatus[0];
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } else {
                            $response->message = 'UserID or OrderID Should not be blank';
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
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 10/12/2015
     * Desc: Insert all orders in db
     * Modified Date: 22/1/2016
     * Desc : Order's details
     */

//                        $data['user_id'] = $this->getRequest()->getPost('userid');
//                        $totalamount = $this->getRequest()->getPost('totalamount');
//                        if ($totalamount) {
//                            $data['total_amount'] = $this->getRequest()->getPost('totalamount');
//                        }
//                        $data['pay_status'] = 0;
//                        $data['order_status'] = 4;
//                        $data['order_date'] = date('Y-m-d H-i-s');
//                        if ($data['user_id']) {
//                            $insertedorderid = $ordersModel->insertOrders($data);
//                            if ($insertedorderid) {
//
//                                $dat['fullname'] = $this->getRequest()->getPost('fullname');
//                                $dat['phone_no'] = $this->getRequest()->getPost('phonenum');
//                                $dat['address'] = $this->getRequest()->getPost('address');
//                                $dat['cityname'] = $this->getRequest()->getPost('cityname');
//                                $dat['statename'] = $this->getRequest()->getPost('statename');
//                                $dat['countryname'] = $this->getRequest()->getPost('countryname');
//                                $dat['landMark'] = $this->getRequest()->getPost('landMark');
//                                $info['ordered_user_id'] = $this->getRequest()->getPost('userid');
//                                $info['order_id'] = $insertedorderid;
//                                $info['delivery_addr'] = json_encode($dat, true);
//                        $userdelid = $userdeliveryaddrmodal->insertUserDeliveryAddress($info);
//                        if ($userdelid) {
//                            $cartids = $this->getRequest()->getPost('cartids');
//                            if ($cartids) {
//                                $carts = json_decode($cartids, true);
//                                $i = 0;
//                                foreach ($carts as $val) {
//                                    $da[$i]['order_id'] = $insertedorderid;
//                                    $da[$i]['ordered_cart_id'] = $val;
//                                    $i++;
//                                }
//                                $arrayofIds = $orderproductsmodal->insertOrderedCartProducts($da);
//                                if ($arrayofIds) {
//
//                                    $response->message = 'successfull';
//                                    $response->code = 200;
//                                    $response->data['order_id'] = $insertedorderid;
//                                    $response->data['delivery_id'] = $userdelid;
//                                    $response->data['ordered_product_ids'] = $arrayofIds;
//                                } else {
//                                    $response->message = 'successfull, but issues with the  cart products';
//                                    $response->code = 400;
//                                    $response->data['order_id'] = $insertedorderid;
//                                    $response->data['delivery_id'] = $userdelid;
//                                }
//                            } else {
//                                $response->message = 'successfull,carts ids null given';
//                                $response->code = 400;
//                                $response->data['order_id'] = $insertedorderid;
//                                $response->data['delivery_id'] = $userdelid;
//                            }
//                        } else {
//                            $response->message = 'order successfully get inserted, but issues with delivery address';
//                            $response->code = 400;
//                            $response->data['order_id'] = $insertedorderid;
//                        }
//                    } else {
//                        $response->message = 'Failed order';
//                        $response->code = 197;
//                        $response->data['order_id'] = null;
//                    }
//                } else {
//                $response->message = 'Could Not Serve The Request,user id is required';
//                $response->code = 198;
//                $response->data = null;
//            }
//    } else {
//        $response->message = 'Could Not Serve The Request';
//        $response->code = 401;
//        $response->data = NULL;
//    }
//    echo json_encode($response, true);
//    die;
//    break;
//}
//} else {
//    $response->message = 'Invalid Request';
//    $response->code = 401;
//    $response->data = "No Method Passed";
//    echo json_encode($response, true);
//    die();
//}


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
                     
                        $selectlocation = $this->getRequest()->getPost('selectlocation');
                        if (!empty($selectlocation)) {
                            $data['hotel_location'] = $selectlocation;
                        }
                        $primary_phone = $this->getRequest()->getPost('primary_phone');
                        if (!empty($primary_phone)) {
                            $data['hotel_contact_number'] = $primary_phone;
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

                        $deliverycharge = $this->getRequest()->getPost('deliverycharge');
                        if (!empty($deliverycharge)) {
                            $data['deliverycharge'] = $deliverycharge;
                        }

                        $minorder = $this->getRequest()->getPost('minorder');
                        if (!empty($minorder)) {
                            $data['minorder'] = $minorder;
                        }
                        $address = $this->getRequest()->getPost('address');
                        if (!empty($address)) {
                            $data['address'] = $address;
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
                        $data['hotel_contact_number'] = $this->getRequest()->getPost('primary_phone');
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
