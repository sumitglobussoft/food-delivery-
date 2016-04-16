<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Agent_OrderController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function orderAjaxHandlerAction() {
        $this->_helper->_layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $method = $this->getRequest()->getParam('method');

        switch ($method) {
            ////////////////HOTEL ACTIONS //////////////////////////////
            case 'hotelactive':

                $hotelid = $this->getRequest()->getParam('hotelid');
                if ($hotelid) {
                    $url = $this->_appSetting->apiLink . '/hoteldetails?method=changehotelstatus';
                    $data['hotel_id'] = $hotelid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array['code'] = 200;
                        $array['data'] = $curlResponse->data['hotel_id'];
                        echo json_encode($array, true);
                        die();
                    } else {
                        $array['code'] = 198;
                        $array['data'] = null;
                        echo json_encode($array, true);
                        die();
                    }
                } else {

                    $array['code'] = 197;
                    $array['data'] = null;
                    echo json_encode($array, true);
                    die();
                }

                break;

            case 'hoteldeactive':

                $hotelid = $this->getRequest()->getParam('hotelid');
                if ($hotelid) {
                    $url = $this->_appSetting->apiLink . '/hoteldetails?method=changehotelstatus';
                    $data['hotel_id'] = $hotelid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['hotel_id']);

                        echo json_encode($array, true);
                        die();
                    } else {
                        $array = array('code' => 198,
                            'data' => null);
                        echo json_encode($array, true);
                        die();
                    }
                } else {

                    $array = array('code' => 198,
                        'data' => null);
                    echo json_encode($array, true);
                    die();
                }

                break;

            case 'hoteldelete':
                $hotelid = $this->getRequest()->getParam('hotelid');
                if ($hotelid) {
                    $url = $this->_appSetting->apiLink . '/hoteldetails?method=hoteldelete';
                    $data['hotel_id'] = $hotelid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['hotel_id']);
                        echo json_encode($array, true);
                        die();
                    } else {
                        $array = array('code' => 198,
                            'data' => null);
                        echo json_encode($array, true);
                        die();
                    }
                } else {
                    $array = array('code' => 198,
                        'data' => null);
                    echo json_encode($array, true);
                    die();
                }
                break;

            /////////////////////////////// PRODUCT ACTIONS /////////////////////////////         

            case 'productactive':

                $productid = $this->getRequest()->getParam('productid');
                if ($productid) {
                    $url = $this->_appSetting->apiLink . '/getproducts?method=changeproductstatus';
                    $data['product_id'] = $productid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array['code'] = 200;
                        $array['data'] = $curlResponse->data['product_id'];
                        echo json_encode($array, true);
                        die();
                    } else {
                        $array['code'] = 198;
                        $array['data'] = null;
                        echo json_encode($array, true);
                        die();
                    }
                } else {

                    $array['code'] = 197;
                    $array['data'] = null;
                    echo json_encode($array, true);
                    die();
                }

                break;

            case 'productdeactive':

                $productid = $this->getRequest()->getParam('productid');
                if ($productid) {
                    $url = $this->_appSetting->apiLink . '/getproducts?method=changeproductstatus';
                    $data['product_id'] = $productid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['product_id']);

                        echo json_encode($array, true);
                        die();
                    } else {
                        $array = array('code' => 198,
                            'data' => null);
                        echo json_encode($array, true);
                        die();
                    }
                } else {

                    $array = array('code' => 198,
                        'data' => null);
                    echo json_encode($array, true);
                    die();
                }

                break;

            case 'productdelete':
                $productid = $this->getRequest()->getParam('productid');
                if ($productid) {
                    $url = $this->_appSetting->apiLink . '/getproducts?method=productdelete';
                    $data['product_id'] = $productid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['product_id']);
                        echo json_encode($array, true);
                        die();
                    } else {
                        $array = array('code' => 198,
                            'data' => null);
                        echo json_encode($array, true);
                        die();
                    }
                } else {
                    $array = array('code' => 198,
                        'data' => null);
                    echo json_encode($array, true);
                    die();
                }
                break;

            case 'findstates':
                $countryid = $this->getRequest()->getParam('countryid');
                if ($countryid) {
                    $url = $this->_appSetting->apiLink . '/get-locations?method=getStatesByCountrys';
                    $data['country_id'] = $countryid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data);
                        echo json_encode($array, true);
                        die();
                    } else {
                        $array = array('code' => 198,
                            'data' => null);
                        echo json_encode($array, true);
                        die();
                    }
                } else {
                    $array = array('code' => 198,
                        'data' => null);
                    echo json_encode($array, true);
                    die();
                }
                break;
            case 'findcitys':
                $stateid = $this->getRequest()->getParam('stateid');
                if ($stateid) {
                    $url = $this->_appSetting->apiLink . '/get-locations?method=getcitysbystates';
                    $data['state_id'] = $stateid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data);
                        echo json_encode($array, true);
                        die();
                    } else {
                        $array = array('code' => 198,
                            'data' => null);
                        echo json_encode($array, true);
                        die();
                    }
                } else {
                    $array = array('code' => 198,
                        'data' => null);
                    echo json_encode($array, true);
                    die();
                }
                break;
            case 'findlocations':
                $locationid = $this->getRequest()->getParam('locationid');
                if ($locationid) {
                    $url = $this->_appSetting->apiLink . '/get-locations?method=getlocations';
                    $data['location_id'] = $locationid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data);
                        echo json_encode($array, true);
                        die();
                    } else {
                        $array = array('code' => 198,
                            'data' => null);
                        echo json_encode($array, true);
                        die();
                    }
                } else {
                    $array = array('code' => 198,
                        'data' => null);
                    echo json_encode($array, true);
                    die();
                }
                break;
            case 'getcuisines':
                $val = $this->getRequest()->getParam('typevalue');
                if ($val == 2) {
                    $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getcuisines';
                    $curlResponse = $objCurlHandler->curlUsingGet($url);

                    if ($curlResponse->code == 200) {
                        $arr['code'] = 200;
                        $arr['data'] = $curlResponse->data;
                        echo json_encode($arr, true);
                    } else {
                        $arr['code'] = 197;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                    }
                } else {
                    $arr['code'] = 198;
                    $arr['message'] = 'param not passed';
                    echo json_encode($arr, true);
                }

                break;

            case 'getcategories':
                $val = $this->getRequest()->getParam('typevalue');
                if ($val == 1) {
                    $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=GetCategorys';
                    $curlResponse = $objCurlHandler->curlUsingGet($url);
                    if ($curlResponse->code == 200) {
                        $arr['code'] = 200;
                        $arr['data'] = $curlResponse->data;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 197;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                } else {
                    $arr['code'] = 198;
                    $arr['message'] = 'param not passed';
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
     * date: 22/12/2015
     * Desc: To work on restauarent orders 
     * 
     */

    public function restuarentOrdersAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
         $hotel_id = $this->getRequest()->getParam('hotelid');
        $data['hotel_id'] = $hotel_id;
        $url = $this->_appSetting->apiLink . '/order-products'; 
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
        if ($curlResponse->code == 200) {
            $this->view->orderedproducts = $curlResponse->data;
        }
    }

    /*
     * Dev: sowmya
     * date: 21/3/2015
     * Desc: To view all restauarent orders 
     * 
     */

    public function editRestuarentOrdersAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agentid = $this->view->session->storage->agent_id;
        $order_id = $this->getRequest()->getParam('oId');
        $dt['order_id'] = $order_id;
        $url = $this->_appSetting->apiLink . '/edit-order-products';
        $curlResponse = $objCurlHandler->curlUsingPost($url, $dt);

        if ($curlResponse->code == 200) {

            $this->view->orderdetails = $curlResponse->data;
        }
    }

    /*
     * Dev: sowmya
     * date: 21/3/2015
     * Desc: To view all restauarent orders 
     * 
     */

    public function viewRestuarentOrdersAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $order_id = $this->getRequest()->getParam('oId');
        $dt['order_id'] = $order_id;
        $url = $this->_appSetting->apiLink . '/edit-order-products';
        $curlResponse = $objCurlHandler->curlUsingPost($url, $dt);
//        echo '<pre>';print_r($curlResponse);die;
        if ($curlResponse->code == 200) {

            $this->view->orderdetails = $curlResponse->data;
        }
    }

}
