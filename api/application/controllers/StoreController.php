<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class StoreController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function storeSummaryAction() {
        $storesummaryModel = Application_Model_StoreDetails::getInstance();
        $ReviewsModel = Application_Model_Reviews::getInstance();
        $storecategoryModel = Application_Model_StoreCategory::getInstance();
        $locationsmodal = Application_Model_Location::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {


######################################  START SERVICES   ############################################

                /* DEV : sowmya
                 * Desc : services to  get store list by location
                 * Date : 5/5/2016
                 */

                /* DEV : Sibani Mishra
                 * Desc : Did Modification
                 * Date : 6/5/2016
                 */
                case 'getStoreListByLocations':
                    if ($this->getRequest()->isPost()) {

                        $countryid = $this->getRequest()->getPost('country_id');

                        $stateid = $this->getRequest()->getPost('state_id');

                        $cityid = $this->getRequest()->getPost('city_id');

                        $locationid = $this->getRequest()->getPost('location_id');

                        if ($countryid && $stateid && $cityid && $locationid) {

                            $StoreList = $locationsmodal->getStoreByLocationsIds($countryid, $stateid, $cityid, $locationid);

                            foreach ($StoreList as $key => $val) {
                                unset($val['category_id']);
                                $StoreList[$key] = $val;
                            }

                            if ($StoreList) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $StoreList;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        } else {
                            $response->message = 'Parameter missing';
                            $response->code = 197;
                            $response->data = NUll;
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
                /* DEV :sowmya
                 * Desc :services to  get store list by storename
                 * Date : 5/5/2016
                 */
                case 'storename':

                    if ($this->getRequest()->isPost()) {

                        $name = $this->getRequest()->getPost('name');

                        if ($name) {
                            $StoreList = $storesummaryModel->searchByNames($name);
                            if ($StoreList) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $StoreList;
                            } else {
                                $response->message = 'No Data Found';
                                $response->code = 197;
                                $response->data = Null;
                            }
                        } else {
                            $response->message = 'parameter doesnot pass';
                            $response->code = 198;
                            $response->data = Null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;
                    break;
                /* DEV :sowmya
                 * Desc :services to  get store  categorylist
                 * Date : 5/5/2016
                 */

                /* DEV :Sibani Mishra
                 * Desc :Modified Service
                 * Date : 5/6/2016
                 */
                case 'GetCategory':
                    if ($this->getRequest()->isPost()) {

                        $store_id = $this->getRequest()->getPost('store_id');

                        if ($store_id) {

                            $cats = $storesummaryModel->getcategoriesByStoreId($store_id);

                            foreach ($cats as $key => $val) {

                                unset($val['store_id']);

                                $cats[$key] = $val;
                            }

                            if ($cats) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $cats;
                            } else {
                                $response->message = 'Something went wrong';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        } else {
                            $response->message = 'Store id is not correct';
                            $response->code = 197;
                            $response->data = NUll;
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }
                    echo json_encode($response, true);
                    die();
                    break;
                /*
                 * DEV :sowmya
                 * Desc : service used for sorting store based by reviews and ratings
                 * Date : 5/5/2016
                 */
                case 'selectReviewsAndRatings':

                    if ($this->getRequest()->isPost()) {

                        $store_location = $this->getRequest()->getPost('store_location');

                        if (!empty($store_location)) {

                            $storenames = $storesummaryModel->getstorenamebasedReviewandratings($store_location);

                            if ($storenames) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $storenames;
                            } else {
                                $response->message = 'No Data Found';
                                $response->code = 197;
                                $response->data = Null;
                            }
                        } else {
                            $response->message = 'store Location Shouldnot be blank';
                            $response->code = 198;
                            $response->data = Null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;
                    break;
                /*
                 * Dev ; Sibani Mishra
                 * Desc : List of category based on LocationId
                 * Date : 6th may 2016 
                 */
                case 'getCategoryListbyLocationID':

                    if ($this->getRequest()->isPost()) {

                        $store_location = $this->getRequest()->getPost('store_location');

                        if ($store_location) {

                            $categorydetails = $storesummaryModel->getCategory($store_location);

                            foreach ($categorydetails as $key => $val) {

                                unset($val['store_location']);

                                $categorydetails[$key] = $val;
                            }
                            if (!empty($categorydetails)) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $categorydetails;
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 197;
                            $response->data = null;
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die;
                    break;
                /*
                 * Dev : Sibani Mishra
                 * Desc : List of products based on category
                 * Date : 6th may 2016
                 */
                case 'getProductListByCategoryId':

                    if ($this->getRequest()->isPost()) {
                        $category_id = $this->getRequest()->getPost('category_id');

                        if ($category_id) {
                            $result = $storecategoryModel->fetchListofProducts($category_id);
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
                            $response->message = 'Invalid Request';
                            $response->code = 401;
                            $response->data = Null;
                        }
                    }
                    echo json_encode($response, true);
                    die;
                    break;
                /*
                 * Dev : Sibani Mishra
                 * Desc : List of Stores_Details based on category
                 * Date : 7th may 2016
                 */
                case 'fetchingStoresDetailsBasedOnCategory':
                    if ($this->getRequest()->isPost()) {


                        $store_location = $this->getRequest()->getPost('store_location');
                        $store_category_id = $this->getRequest()->getPost('store_category_id');
                        $store_category_id = json_decode($store_category_id);

                        if (!empty($store_location) && !empty($store_category_id)) {

                            $storesnames = $storesummaryModel->getstoresname($store_location, $store_category_id);

                            if ($storesnames) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $storesnames;
                            } else {
                                $response->message = 'No Data Found';
                                $response->code = 197;
                                $response->data = Null;
                            }
                        } else {
                            $response->message = 'parameter Shouldnot be blank';
                            $response->code = 198;
                            $response->data = Null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;
                    break;
                /*
                 * Dev : Sibani Mishra
                 * Desc : Inser/Update OrdersToCart Based on Stock_Quantity
                 * Date : 10th may 2016
                 */
                case 'UpdateInsertStoresOrdersToCartOnQuantityBasis':
                    if ($this->getRequest()->isPost()) {
                        $user_id = $this->getRequest()->getPost('userid');
                        $store_id = $this->getRequest()->getPost('storeid');
                        $product_id = $this->getRequest()->getPost('productid');
                        $product_id = json_decode($product_id);
                        $quantity = $this->getRequest()->getPost('quantity');
                        $quantity = json_decode($quantity);

                        if ($user_id && $store_id && !empty($product_id) && !empty($quantity)) {

                            if (sizeof($product_id) == sizeof($quantity)) { // Match Array Length
                                $availableOrNot = $objProducts->seperateTheProductsByQuantityAvailablity($product_id, $quantity);

                                if (is_array($availableOrNot) && !empty($availableOrNot)) {

                                    if (array_key_exists('success', $availableOrNot)) {

                                        $updatedAndInsertedProduct = $Addtocart->insertUpdateStoreProductsInCart($user_id, $store_id, $availableOrNot['success'], $availableOrNot['quantity']);

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
                /*
                 * Dev : Sibani Mishra
                 * Desc : Get OrdersToCart 
                 * Date : 10th may 2016
                 */
                case 'getStoreOrderToCart':

                    if ($this->getRequest()->isPost()) {
                        $user_id = $this->getRequest()->getPost('user_id');
                        $store_id = $this->getRequest()->getPost('store_id');

                        if ($user_id && $store_id) {
                            $getaddtocartdetails = $Addtocart->getStoresOrdertocart($user_id, $store_id);

                            if ($getaddtocartdetails) {

                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $getaddtocartdetails;
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
                /*
                 * Dev : Sibani Mishra
                 * Desc : Remove OrdersToCart 
                 * Date : 10th may 2016
                 */
                case 'RemoveStoreOrderToCart':
                    if ($this->getRequest()->isPost()) {

                        $addtocartSerialNo = $this->getRequest()->getPost('cart_id');
                        $user_id = $this->getRequest()->getPost('user_id');

                        if ($addtocartSerialNo && $user_id) {
                            $cartdetails = $Addtocart->RemoveStoreOrderFromAddtoCart($addtocartSerialNo, $user_id);

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

######################################  END SERVICES   ############################################

/////////////////////////////////////////// method for agent panel only ///////////////////////////
///////////////////////////// store details module//////////////////////////////////////////////
                /*
                 * DEV :sowmya
                 * Desc : get all stores
                 * Date : 5/5/2016
                 */
                case'allstore':
                    $storedetails = $storesummaryModel->selectAllStoresLocations();

                    if ($storedetails) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $storedetails;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
                /*
                 * DEV :sowmya
                 * Desc : get all stores by agent id
                 * Date : 5/5/2016
                 */
                case'getStoreDetailsByAgentId':
                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agentstoredetails = $storesummaryModel->getStoredetails($agent_id);
                            if ($agentstoredetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentstoredetails;
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
                 * DEV :sowmya
                 * Desc : to change  stores status
                 * Date : 5/5/2016
                 */
                case'changestorestatus':
                    if ($this->getRequest()->isPost()) {

                        $store_id = $this->getRequest()->getPost('store_id');

                        if ($store_id) {
                            $updatestatus = $storesummaryModel->getstatusChangeOfStore($store_id);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['store_id'] = $store_id;
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
                 * DEV :sowmya
                 * Desc : to delete stores
                 * Date : 5/5/2016
                 */
                case'storedelete':
                    if ($this->getRequest()->isPost()) {

                        $store_id = $this->getRequest()->getPost('store_id');

                        if ($store_id) {
                            $updatestatus = $storesummaryModel->storeDelete($store_id);

                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['store_id'] = $store_id;
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
                 * DEV :sowmya
                 * Desc : get all stores by store id
                 * Date : 5/5/2016
                 */
                case'getStoreDetailsByStoreId':
                    if ($this->getRequest()->isPost()) {

                        $store_id = $this->getRequest()->getPost('store_id');

                        if ($store_id) {
                            $storedetails = $storesummaryModel->getStoredetailsByStoreId($store_id);
                            if ($storedetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $storedetails;
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
                 * DEV :sowmya
                 * Desc : update all stores details by store id
                 * Date : 5/5/2016
                 */
                case'updatestoredetails':
                    if ($this->getRequest()->isPost()) {
                        $store_id = $this->getRequest()->getPost('store_id');
                        $primary_phone = $this->getRequest()->getPost('primary_phone');
                        if (!empty($primary_phone)) {
                            $data['store_contact_number'] = $primary_phone;
                        }
                        $selectlocation = $this->getRequest()->getPost('selectlocation');
                        if (!empty($selectlocation)) {
                            $data['store_location'] = $selectlocation;
                        }


                        $secondary_phone = $this->getRequest()->getPost('secondary_phone');
                        if (!empty($secondary_phone)) {
                            $data['Secondary_phone'] = $secondary_phone;
                        }

                        $store_name = $this->getRequest()->getPost('store_name');
                        if (!empty($store_name)) {
                            $data['store_name'] = $store_name;
                        }
                        $open_time = $this->getRequest()->getPost('open_time');
                        if (!empty($open_time)) {
                            $data['Open_time'] = $open_time;
                        }

                        $store_status = $this->getRequest()->getPost('store_status');
                        if (!empty($store_status)) {
                            $data['store_status'] = $store_status;
                        }

                        $closing_time = $this->getRequest()->getPost('closing_time');
                        if (!empty($closing_time)) {
                            $data['Closing_time'] = $closing_time;
                        }
                        $notice = $this->getRequest()->getPost('notice');
                        if (!empty($notice)) {
                            $data['Notice'] = $notice;
                        }
                        $store_image = $this->getRequest()->getPost('Store_image');
                        if (!empty($store_image)) {
                            $data['store_image'] = $store_image;
                        }

                        $deliverycharge = $this->getRequest()->getPost('deliverycharge');
                        if (!empty($deliverycharge)) {
                            $data['Deliverycharge'] = $deliverycharge;
                        }

                        $cat_name = $this->getRequest()->getPost('cat_name');
                        if (!empty($cat_name)) {
                            $data['category_id'] = $cat_name;
                        }
                        $address = $this->getRequest()->getPost('address');
                        if (!empty($address)) {
                            $data['store_address'] = $address;
                        }

                        if ($store_id) {

                            $updatestatus = $storesummaryModel->updateStoreDetails($store_id, $data);
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
                /*
                 * DEV :sowmya
                 * Desc : add new stores
                 * Date : 5/5/2016
                 */
                case'addstoredetails':
                    if ($this->getRequest()->isPost()) {
                        $data['store_contact_number'] = $this->getRequest()->getPost('primary_phone');
                        $data['Secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
                        $data['store_name'] = $this->getRequest()->getPost('store_name');
                        $data['Open_time'] = $this->getRequest()->getPost('open_time');
                        $data['Closing_time'] = $this->getRequest()->getPost('closing_time');
                        $data['Notice'] = $this->getRequest()->getPost('notice');
                        $data['store_address'] = $this->getRequest()->getPost('address');
                        $data['category_id'] = $this->getRequest()->getPost('cat_name');
                        $data['Deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
                        $data['store_status'] = $this->getRequest()->getPost('store_status');
                        $data['store_location'] = $this->getRequest()->getPost('store_location');
                        $data['agent_id'] = $this->getRequest()->getPost('agent_id');
                        if ($data['agent_id']) {
                            $updatestatus = $storesummaryModel->insertStoreDetails($data);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['store_id'] = $updatestatus;
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
                ////////////////////////////////// store module end here //////////////////////////////////////
                /////////////////////// review module///////////////////////
                /*
                 * DEV :sowmya
                 * Desc : get all hotel reviews by agent id
                 * Date : 5/5/2016
                 */
                case'getHotelReviewsByAgentId':
                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agentstoredetails = $ReviewsModel->getAllHotelReviews($agent_id);
                            if ($agentstoredetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentstoredetails;
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
                 * DEV :sowmya
                 * Desc : to get  stores reviews by agent id
                 * Date : 5/5/2016
                 */
                case'getStoreReviewsByAgentId':
                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agentstoredetails = $ReviewsModel->getAllStoreReviews($agent_id);
                            if ($agentstoredetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentstoredetails;
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
                 * DEV :sowmya
                 * Desc :to change review status of both store and hotel
                 * Date : 5/5/2016
                 */
                case'changereviewstatus':
                    if ($this->getRequest()->isPost()) {

                        $review_id = $this->getRequest()->getPost('review_id');

                        if ($review_id) {
                            $updatestatus = $ReviewsModel->getstatustodeactivate($review_id);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['review_id'] = $review_id;
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
                 * DEV :sowmya
                 * Desc : to delete reviews of both store and hotel
                 * Date : 5/5/2016
                 */
                case'reviewdelete':
                    if ($this->getRequest()->isPost()) {

                        $review_id = $this->getRequest()->getPost('review_id');

                        if ($review_id) {
                            $updatestatus = $ReviewsModel->deleteReviews($review_id);

                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['review_id'] = $review_id;
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
                ///////////////////////////////// review module end here///////////////////////////
                ///////////////////////////////// store category ///////////////////////////////
                /*
                 * DEV :sowmya
                 * Desc : get all stores category details
                 * Date : 5/5/2016
                 */
                case'storeCategory':
                    $storedetails = $storecategoryModel->selectAllCategorys();

                    if ($storedetails) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $storedetails;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
                /*
                 * DEV :sowmya
                 * Desc : add stores category
                 * Date : 5/5/2016
                 */
                case'addStoreCategory':
                    if ($this->getRequest()->isPost()) {
                        $data['cat_name'] = $this->getRequest()->getPost('cat_name');
                        $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
                        $data['cat_status'] = $this->getRequest()->getPost('cat_status');

                        $updatestatus = $storecategoryModel->addCategory($data);
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

                    echo json_encode($response, true);
                    die;
                    break;
                    break;
                /*
                 * DEV :sowmya
                 * Desc : get all stores category by category id
                 * Date : 5/5/2016
                 */
                case'getstorecategoryById':
                    if ($this->getRequest()->isPost()) {
                        $categoryid = $this->getRequest()->getParam('categoryid');
                        $updatestatus = $storecategoryModel->getCategoryById($categoryid);
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

                    echo json_encode($response, true);
                    die;
                    break;
                /*
                 * DEV :sowmya
                 * Desc : to delete stores category
                 * Date : 5/5/2016
                 */
                case'storecategorydelete':
                    if ($this->getRequest()->isPost()) {

                        $categoryid = $this->getRequest()->getParam('categoryid');
                        if ($categoryid) {
                            $updatestatus = $storecategoryModel->categorydelete($categoryid);

                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['category_id'] = $categoryid;
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
//Dev:sreekanth
//Date: 5-5-2016
//Desc: change store category status


                case'changestorecategorystatus':
                    if ($this->getRequest()->isPost()) {

                        $categoryid = $this->getRequest()->getPost('categoryid');

                        if ($categoryid) {
                            $updatestatus = $storecategoryModel->changeCategoryStatus($categoryid);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['categoryid'] = $categoryid;
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
                 * DEV :sowmya
                 * Desc : to update  stores category
                 * Date : 5/5/2016
                 */
                case'updateStoreCategory':
                    if ($this->getRequest()->isPost()) {
                        $data['cat_name'] = $this->getRequest()->getPost('categoryname');
                        $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
                        $category_id = $this->getRequest()->getPost('category_id');
                        $categoryname = $this->getRequest()->getPost('categorybtn');

                        if ($category_id) {
                            $result = $storecategoryModel->updateCategory($data, $category_id);
                            if ($categoryname == 'cat_name') {

                                if ($result) {
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
                        //////////////////////////////////// store category end here//////////////////////////
                    } else {

                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = "No Method Passed";
                        echo json_encode($response, true);
                    }
            }
        }
    }

}
