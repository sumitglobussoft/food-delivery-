<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Web_HomeController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * Dev: Priyanka Varanasi
     * Date : 13/1/2016
     * Desc: Home page funtionlity such as search..
     */

    public function indexAction() {
        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        $url = $this->_appSetting->apiLink . '/get-locations?method=getcitys';
        $curlResponse = $objCurlHandler->curlUsingGet($url);
        if ($curlResponse->code === 200) {
            setcookie('citys', json_encode($curlResponse->data, true));
            $this->view->cityslist = $curlResponse->data;
        }
        if (isset($this->view->session->storage->user_id)) {
            $user_id = $this->view->session->storage->user_id;

            $url = $this->_appSetting->apiLink . '/logged-user-cart?method=userscart';
            $loc['user_id'] = $user_id;
            $curlResponse = $objCurlHandler->curlUsingPost($url, $loc);
            if ($curlResponse->code == 200) {
                $i = 0;
                $count = count($curlResponse->data);
                $this->view->session->storage->cartcount = $count;
            }
        }
    }

    /*
     * Dev: Priyanka Varanasi
     * Date : 12/1/2016
     * Desc: ajax handler funtionalitys
     */

    public function homeAjaxHandlerAction() {

        $this->_helper->_layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        if (isset($this->view->session->storage->user_id)) {
            $user_id = $this->view->session->storage->user_id;
        }

        $method = $this->getRequest()->getParam('methodtype');

        switch ($method) {

            case 'getlocations':
                $locationid = $this->getRequest()->getParam('locationid');
                $url = $this->_appSetting->apiLink . '/get-locations?method=getlocations';
                $data['location_id'] = $locationid;
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                if ($curlResponse->code == 200) {
                    $array = array('code' => 200,
                        'data' => $curlResponse->data);
                    echo json_encode($array, true);
                    die;
                } else {
                    $array = array('code' => 198,
                        'message' => 'No location for the city');
                    echo json_encode($array, true);
                    die;
                }
                break;

            //////// adding product item to cookie ////////////
            case 'AddtoCartCookie':
                $productid = $this->getRequest()->getParam('productid');
                $hotelid = $this->getRequest()->getParam('hotelid');
                $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getproductbyproductId';
                $dat['product_id'] = $productid;
                $curlResponse = $objCurlHandler->curlUsingPost($url, $dat);
                if ($curlResponse->code == 200) {
                    $arr['data'] = $curlResponse->data;
                }
                if (isset($_COOKIE['user_cartitems_cookie']) && !empty($_COOKIE['user_cartitems_cookie'])) {
                    $cookie = $_COOKIE['user_cartitems_cookie'];
                    $cookie = stripslashes($cookie);
                    $tempcookie = (array) json_decode($cookie, TRUE);
                    if ($tempcookie) {
                        foreach ($tempcookie as $value) {
                            if (isset($value['product_id']) && $value['product_id'] == $productid) {
                                $arr['code'] = 197;
                                $arr['message'] = 'Product already existed in cart';
                                echo json_encode($arr, true);
                                die();
                            }
                        }

                        $newarray['product_id'] = $productid;
                        $newarray['hotel_id'] = $hotelid;
                        $newarray['quantity'] = 1;
                        array_push($tempcookie, $newarray);
                        $json = json_encode($tempcookie, true);
                        setcookie('user_cartitems_cookie', $json);
                        $arr['quantity'] = 1;
                        $arr['code'] = 200;
                        $arr['message'] = 'Product successfully added  to cart';
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $cart_items = array();
                        $cart_items[0]['product_id'] = $productid;
                        $cart_items[0]['hotel_id'] = $hotelid;
                        $cart_items[0]['quantity'] = 1;
                        $json = json_encode($cart_items, true);
                        setcookie('user_cartitems_cookie', $json);
                        $arr['quantity'] = 1;
                        $arr['code'] = 200;
                        $arr['message'] = 'Product successfully added  to cart';
                        echo json_encode($arr, true);
                        die();
                    }
                } else {

                    $cart_items = array();
                    $cart_items[0]['product_id'] = $productid;
                    $cart_items[0]['hotel_id'] = $hotelid;
                    $cart_items[0]['quantity'] = 1;
                    $json = json_encode($cart_items, true);
                    setcookie('user_cartitems_cookie', $json);
                    $arr['code'] = 200;
                    $arr['message'] = 'Product successfully added  to cart';
                    echo json_encode($arr, true);
                    die();
                }

                break;

            /////adding product item to db///////
//            case 'AddtoCartDb':
//                break;
//                
            default :
                break;
        }
    }

    /*
     * Dev: Priyanka Varanasi
     * Date : 14/1/2016
     * Desc: restaurents list display based on restaurents search
     */

    public function restaurentsListAction() {
        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        if (isset($this->view->session->storage->user_id)) {
            $user_id = $this->view->session->storage->user_id;
            $url = $this->_appSetting->apiLink . '/logged-user-cart?method=userscart';
            $loc['user_id'] = $user_id;
            $curlResponse = $objCurlHandler->curlUsingPost($url, $loc);

            if ($curlResponse->code == 200) {
                $i = 0;
                $count = count($curlResponse->data);
                $this->view->session->storage->cartcount = $count;
            }
        }
        $citylocation_id = $this->getRequest()->getParam('city');
        $location_id = $this->getRequest()->getParam('location_id');

        ///////////for fetching name of the city in which the restaurents located//////////////

        $loc['city_id'] = $citylocation_id;
        $url = $this->_appSetting->apiLink . '/get-restaurants-list?method=getcityname';
        $Response = $objCurlHandler->curlUsingPost($url, $loc);
        if ($Response->code == 200) {
            $this->view->cityname = $Response->data['name'];
        }
        ///////////////////code ends ///////
        if ($location_id) {
            $info['location_id'] = $location_id;
            $info['city_id'] = $citylocation_id;

            $curlResponse = $objCurlHandler->curlUsingPost($url, $info);
            $url = $this->_appSetting->apiLink . '/get-restaurants-list?method=bylocationid';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $info);
            if ($curlResponse->code == 200) {
                $this->view->restaurantslist = $curlResponse->data;
            } else {
                $info['location_id'] = $citylocation_id;
                $url = $this->_appSetting->apiLink . '/get-restaurants-list?method=bycityid';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $info);

                if ($curlResponse->code === 200) {
                    $this->view->restaurantslist = $curlResponse->data;
                }
            }
        } else {

            $inf['location_id'] = $citylocation_id;
            $url = $this->_appSetting->apiLink . '/get-restaurants-list?method=bycityid';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $inf);

            if ($curlResponse->code === 200) {
                $this->view->restaurantslist = $curlResponse->data;
            }
        }
    }

    /*
     * Dev: Priyanka Varanasi
     * Date : 14/1/2016
     * Desc: restaurents details display
     */

    public function restaurantDetailsAction() {

        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();

        $response = new stdClass();
        $method = $this->getrequest()->getParam('method');

        $this->_appSetting = $objCore->getAppSetting();
        if (isset($this->view->session->storage->user_id)) {
            $user_id = $this->view->session->storage->user_id;
        }

        $hotel_id = $this->getRequest()->getParam('id');
        if ($hotel_id) {
            $loc['hotel_id'] = $hotel_id;
            $this->view->hotelId = $hotel_id;
            /*             * **** Display of restaurant  details***** */
            $url = $this->_appSetting->apiLink . '/restaurant-info-card?method=gethotelinfo';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $loc);
            if ($curlResponse->code == 200) {
                $this->view->hoteldata = $curlResponse->data;
            }
            /****** Display of restaurant menu details and products***** */
            $url = $this->_appSetting->apiLink . '/restaurant-info-card?method=getmenulist';
            $Response = $objCurlHandler->curlUsingPost($url, $loc);

            if ($Response->code == 200) {
                $this->view->hotelmenu = $Response->data;
            }

            ////////// add to cart products display of logged user
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
    }

}
