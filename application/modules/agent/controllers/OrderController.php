<?php

/**
 * AgentController
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
            /*
             * DEV :sowmya
             * Desc : to activate hotel status
             * Date : 5/5/2016
             */
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
            /*
             * DEV :sowmya
             * Desc : to deactivate hotel status
             * Date : 5/5/2016
             */
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
            /*
             * DEV :sowmya
             * Desc : to delete hotel
             * Date : 5/5/2016
             */
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
            /*
             * DEV :sowmya
             * Desc : to activate product staus
             * Date : 5/5/2016
             */
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
            /*
             * DEV :sowmya
             * Desc : to deactivate product status
             * Date : 5/5/2016
             */
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
            /*
             * DEV :sowmya
             * Desc : to delete product
             * Date : 5/5/2016
             */
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
            /*
             * DEV :sowmya
             * Desc : tofind states
             * Date : 5/5/2016
             */
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
            /*
             * DEV :sowmya
             * Desc : to find citys
             * Date : 5/5/2016
             */
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
            /*
             * DEV :sowmya
             * Desc : to find location
             * Date : 5/5/2016
             */
            case 'findlocations':
                $locationid = $this->getRequest()->getParam('locationid');
                if ($locationid) {
                    $url = $this->_appSetting->apiLink . '/get-locations?method=getlocation';
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
            /*
             * DEV :sowmya
             * Desc : to get hotel cuisines
             * Date : 5/5/2016
             */
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
            /*
             * DEV :sowmya
             * Desc : to get hotel categories
             * Date : 5/5/2016
             */
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

            ////////////////store ACTIONS  by sowmya 26//4/2016 //////////////////////////////
            /*
             * DEV :sowmya
             * Desc : to activate store status
             * Date : 5/5/2016
             */
            case 'storeactive':

                $storeid = $this->getRequest()->getParam('storeid');
                if ($storeid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=changestorestatus';
                    $data['store_id'] = $storeid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array['code'] = 200;
                        $array['data'] = $curlResponse->data['store_id'];
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
            /*
             * DEV :sowmya
             * Desc : to deactivate store status
             * Date : 5/5/2016
             */
            case 'storedeactive':

                $storeid = $this->getRequest()->getParam('storeid');
                if ($storeid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=changestorestatus';
                    $data['store_id'] = $storeid;

                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['store_id']);

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
            /*
             * DEV :sowmya
             * Desc : to delete store status
             * Date : 5/5/2016
             */
            case 'storedelete':
                $storeid = $this->getRequest()->getParam('storeid');
                if ($storeid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=storedelete';
                    $data['store_id'] = $storeid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['store_id']);
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

            ////////////////reviews ACTIONS  by sowmya 26//4/2016 //////////////////////////////
            /*
             * DEV :sowmya
             * Desc : to activate review status
             * Date : 5/5/2016
             */
            case 'reviewactive':

                $reviewid = $this->getRequest()->getParam('reviewid');
                if ($reviewid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=changereviewstatus';
                    $data['review_id'] = $reviewid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array['code'] = 200;
                        $array['data'] = $curlResponse->data['review_id'];
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
            /*
             * DEV :sowmya
             * Desc : to deactivate review status
             * Date : 5/5/2016
             */
            case 'reviewdeactive':

                $reviewid = $this->getRequest()->getParam('reviewid');
                if ($reviewid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=changereviewstatus';
                    $data['review_id'] = $reviewid;

                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['review_id']);

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
            /*
             * DEV :sowmya
             * Desc : to delete review
             * Date : 5/5/2016
             */
            case 'reviewdelete':
                $reviewid = $this->getRequest()->getParam('reviewid');
                if ($reviewid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=reviewdelete';
                    $data['review_id'] = $reviewid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['review_id']);
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
///////////////////////////////////////// stores category 3/5/2016 ////////////////////////////////////
            /*
             * DEV :sowmya
             * Desc : to get store category
             * Date : 5/5/2016
             */
            case 'getstorecategory':
                $categoryid = $this->getRequest()->getParam('categoryid');
                if ($categoryid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=getstorecategoryById';
                    $data['category_id'] = $categoryid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['category_id']);
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
            /*
             * DEV :sowmya
             * Desc : to delete store category
             * Date : 5/5/2016
             */
            case 'storecategorydelete':

                $categoryid = $this->getRequest()->getParam('categoryid');
                if ($categoryid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=storecategorydelete';
                    $data['categoryid'] = $categoryid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['category_id']);
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
            ////////////////////////////////////////////// ends here////////////////////////
            /////////// setting module  //////////////////////////
            /*
             * DEV :sowmya
             * Desc : to activate location status
             * Date : 5/5/2016
             */
            case 'locationactive':

                $locationid = $this->getRequest()->getParam('locationid');
                if ($locationid) {
                    $url = $this->_appSetting->apiLink . '/settingdetails?method=locationactive';
                    $data['locationid'] = $locationid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array = $curlResponse->data;
                        echo $array;
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
            /*
             * DEV :sowmya
             * Desc : to get location
             * Date : 5/5/2016
             */
            case 'getlocation':

                $locationid = $this->getRequest()->getParam('locationid');
                if ($locationid) {
                    $url = $this->_appSetting->apiLink . '/settingdetails?method=getlocation';
                    $data['locationid'] = $locationid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $arr['code'] = 200;
                        $arr['data'] = $curlResponse->data;
                        echo json_encode($arr, true);
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
            /*
             * DEV :sowmya
             * Desc : to delete country
             * Date : 5/5/2016
             */
            case 'countrydelete':

                $locationid = $this->getRequest()->getParam('deleteid');
                if ($locationid) {
                    $url = $this->_appSetting->apiLink . '/settingdetails?method=countrydelete';
                    $data['locationid'] = $locationid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {

                        echo $curlResponse->data;
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
            /*
             * DEV :sowmya
             * Desc : to activate store category
             * Date : 5/5/2016
             */
            case 'storecategoryactive':

                $categoryid = $this->getRequest()->getParam('categoryid');
                if ($categoryid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=changestorecategorystatus';
                    $data['categoryid'] = $categoryid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array['code'] = 200;
                        $array['data'] = $curlResponse->data['categoryid'];
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
            /*
             * DEV :sowmya
             * Desc : to deactivate store category
             * Date : 5/5/2016
             */
            case 'storecategorydeactive':

                $categoryid = $this->getRequest()->getParam('categoryid');
                if ($categoryid) {
                    $url = $this->_appSetting->apiLink . '/storedetails?method=changestorecategorystatus';
                    $data['categoryid'] = $categoryid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['categoryid']);

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


            /*
             * DEV :sowmya
             * Desc : to activatehotel category
             * Date : 5/5/2016
             */

            case 'hotelcategoryactive':

                $hotelid = $this->getRequest()->getParam('hotelid');

                if ($hotelid) {
                    $url = $this->_appSetting->apiLink . '/hoteldetails?method=changehotelcategorystatus';
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
            /*
             * DEV :sowmya
             * Desc : to deactivate hotel category
             * Date : 5/5/2016
             */
            case 'hotelcategorydeactive':

                $hotelid = $this->getRequest()->getParam('hotelid');
                if ($hotelid) {
                    $url = $this->_appSetting->apiLink . '/hoteldetails?method=changehotelcategorystatus';
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
            /*
             * DEV :sowmya
             * Desc : to activate hotel cuisine status
             * Date : 5/5/2016
             */
            case 'changeHotelCuisineStatus':

                $cuisineid = $this->getRequest()->getParam('cuisineid');
                if ($cuisineid) {
                    $url = $this->_appSetting->apiLink . '/hoteldetails?method=changeHotelCuisineStatus';
                    $data['cuisineid'] = $cuisineid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $array = array('code' => 200,
                            'data' => $curlResponse->data['cuisineid']);

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

            /*
             * DEV :sowmya
             * Desc : to delete hotel category
             * Date : 5/5/2016
             */

            case 'hotelcategorydelete':

                $categoryid = $this->getRequest()->getParam('deleteid');
                if ($categoryid) {
                    $url = $this->_appSetting->apiLink . '/settingdetails?method=hotelcategorydelete';
                    $data['categoryid'] = $categoryid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {

                        echo $curlResponse->data;
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
            /*
             * DEV :sowmya
             * Desc : to delete hotel cuisines
             * Date : 5/5/2016
             */
            case 'hotelcuisinedelete':

                $cuisine_id = $this->getRequest()->getParam('deleteid');
                if ($cuisine_id) {
                    $url = $this->_appSetting->apiLink . '/settingdetails?method=hotelcuisinedelete';
                    $data['cuisine_id'] = $cuisine_id;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {

                        echo $curlResponse->data;
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
            /*
             * DEV :sowmya
             * Desc : to get hotel category by categoyry id
             * Date : 5/5/2016
             */
            case 'getcategoriesByCategoryId':

                $categoryid = $this->getRequest()->getParam('categoryid');
                if ($categoryid) {
                    $url = $this->_appSetting->apiLink . '/settingdetails?method=getcategoriesByCategoryId';
                    $data['categoryid'] = $categoryid;
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $arr['code'] = 200;
                        $arr['data'] = $curlResponse->data;
                        echo json_encode($arr, true);
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
                 /*
             * DEV :sowmya
             * Desc : to delete payement in agent panel
             * Date : 5/5/2016
             */

            case 'payementdelete':

                $deleteid = $this->getRequest()->getParam('deleteid');
                if ($deleteid) {
                    $url = $this->_appSetting->apiLink . '/agent-transaction-process?method=payementdelete';
                    $data['deleteid'] = $deleteid;
                 
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {

                        echo $curlResponse->data;
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
            default :
                break;
        }
    }

    /*
     * DEV :sowmya
     * Desc : to get hotel order
     * Date : 5/5/2016
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
        if ($curlResponse->code == 200) {

            $this->view->orderdetails = $curlResponse->data;
        }
    }

}
