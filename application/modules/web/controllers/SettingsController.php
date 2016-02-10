<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Web_SettingsController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function cartAction() {
        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        ////// list of saved products in cookies display for all hotels //////////////////
        if (isset($_COOKIE['user_cartitems_cookie'])) {
            $cartitems = $_COOKIE['user_cartitems_cookie'];

            $cartitems = stripslashes($cartitems);
            $saved_cart_items = json_decode($cartitems, true);

            $ar['cookies_values'] = json_encode($saved_cart_items, true);

            $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getproductsForAllHotels';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $ar);

            if ($curlResponse->code == 200) {

                $i = 0;
                $count = count($curlResponse->data);

                foreach ($curlResponse->data as $value) {
                    $hotel_id = $value['hotel_id'];
                    if ($hotel_id) {
                        $arr[$hotel_id]['hotelname'] = $value['hotel_name'];
                        $arr[$hotel_id]['hotel_id'] = $value['id'];
                        $arr[$hotel_id]['hotel_image'] = $value['hotel_image'];
                        $arr[$hotel_id]['notice'] = $value['notice'];
                        $arr[$hotel_id]['min order'] = $value['min order'];
                        $arr[$hotel_id]['deliverycharge'] = $value['deliverycharge'];
                        if (!isset($arr[$hotel_id]['totalcost'])) {
                            $arr[$hotel_id]['totalcost'] = 0;
                            $arr[$hotel_id]['totalcost']+=$value['product_cost'];
                        } else {
                            $arr[$hotel_id]['totalcost']+=$value['product_cost'];
                        }
                        $arr[$hotel_id]['products'][$i]['product_name'] = $value['name'];
                        $arr[$hotel_id]['products'][$i]['product_id'] = $value['product_id'];
                        $arr[$hotel_id]['products'][$i]['hotel_id'] = $value['hotel_id'];
                        $arr[$hotel_id]['products'][$i]['total_cost'] = $value['product_cost'];
                        $arr[$hotel_id]['products'][$i]['unit_cost'] = $value['cost'];
                        $arr[$hotel_id]['products'][$i]['quantity'] = $value['quantity'];
                        $arr[$hotel_id]['products'][$i]['imagelink'] = $value['imagelink'];
                    }
                    $i++;
                }

                $this->view->cartdata = $arr;
            }
        } else {
            
        }
    }

}
