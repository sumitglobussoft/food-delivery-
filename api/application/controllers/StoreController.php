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
                /* DEV :sowmya
                 * Desc :services to  get store list by location
                 * Date : 5/5/2016
                 */

                case'getStoreListByLocations':
                    if ($this->getRequest()->isPost()) {

                        $countryid = $this->getRequest()->getPost('country_id');

                        $stateid = $this->getRequest()->getPost('state_id');

                        $cityid = $this->getRequest()->getPost('city_id');

                        $locationid = $this->getRequest()->getPost('location_id');

                        if ($countryid && $stateid && $cityid && $locationid) {

                            $StoreList = $locationsmodal->getStoreByLocationsIds($countryid, $stateid, $cityid, $locationid);

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
                case'storename':

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
                case'GetCategory':
                    if ($this->getRequest()->isPost()) {
                        $store_id = $this->getRequest()->getPost('store_id');
                        if ($store_id) {
                            $cats = $storesummaryModel->getcategoriesByStoreId($store_id);
                            if ($cats) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $cats;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
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
                ///////////////////////////////////////// method for agent panel only //////////////////////////
                /////////////////////////// store details module//////////////////////////////////
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
