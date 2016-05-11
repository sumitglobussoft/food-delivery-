<?php

/**
 * StoreController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Agent_StoreController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * Dev: sowmya
     * Date : 6/5/2016
     * Desc: To get all store details regarding logged agent
     * 
     */

    public function storeDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/storedetails?method=getStoreDetailsByAgentId';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse->code == 200) {

            $this->view->storedetails = $curlResponse->data;
        }
    }

    /*
     * Dev: sowmya
     * Date 11/4/2016
     * Desc: To  edit store details of agent 
     * 
     */

    public function editStoreDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agentid = $this->view->session->storage->agent_id;
        $store_id = $this->getRequest()->getParam('storeid');

        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse2 = $objCurlHandler->curlUsingGet($url);
        if ($curlResponse2->code == 200) {
            $this->view->countrylist = $curlResponse2->data;
        }
        $url1 = $this->_appSetting->apiLink . '/storedetails?method=storeCategory';
        $curlResponse3 = $objCurlHandler->curlUsingGet($url1);
        if ($curlResponse3->code == 200) {
            $this->view->categorylist = $curlResponse3->data;
        }
     
        if ($this->getRequest()->isPost()) {

            $data['store_id'] = $store_id;
            $data['selectlocation'] = $this->getRequest()->getPost('selectlocation');
            $data['select_state'] = $this->getRequest()->getPost('selectstate');
            $data['select_city'] = $this->getRequest()->getPost('selectcity');
            $data['primary_phone'] = $this->getRequest()->getPost('primary_phone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
            $data['store_name'] = $this->getRequest()->getPost('store_name');
            $data['open_time'] = $this->getRequest()->getPost('open_time');
            $data['closing_time'] = $this->getRequest()->getPost('closing_time');
            $data['notice'] = $this->getRequest()->getPost('notice');
            $data['store_status'] = $this->getRequest()->getPost('store_status');
            $data['address'] = $this->getRequest()->getPost('address');
            $data['deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
            $data['cat_name'] = json_encode($this->getRequest()->getPost('cat_name'));
           
            $coverphoto = $_FILES["fileToUpload"]["name"];
            $dirpath = getcwd() . "/themes/agent/skin/groceryimages/$agentid/$store_id/";

            if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
            }
            if (!empty($coverphoto)) {
                $imagepath = $dirpath . $coverphoto;
                $savepath = "/themes/agent/skin/groceryimages/$agentid/$store_id/$coverphoto";
                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));

                    if ($imagemoveResult) {
                        $link = $this->_appSetting->hostLink;
                        $data['store_image'] = $link . $savepath;
                        $url = $this->_appSetting->apiLink . '/storedetails?method=updatestoredetails';
                        $curlResponse3 = $objCurlHandler->curlUsingPost($url, $data);

                        if ($curlResponse3->code == 200) {
                            $this->redirect('/agent/store-details');
                        }
                    } else {

                        echo "DIE HERE";
                    }
                }
            } else {
                $url = $this->_appSetting->apiLink . '/storedetails?method=updatestoredetails';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                if ($curlResponse->code == 200) {
                    $this->redirect('/agent/store-details');
                }
            }
        }

        $url = $this->_appSetting->apiLink . '/storedetails?method=getStoreDetailsByStoreId';
        $data['store_id'] = $store_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
    
        
        if ($curlResponse->code == 200) {
            $this->view->storedetails = $curlResponse->data;
        }
    }

    /*
     * Dev: sowmya
     * Date : 6/5/2016
     * Desc: To add store details 
     * 
     */

    public function addStoreDetailsAction() {


        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse = $objCurlHandler->curlUsingGet($url);
        if ($curlResponse->code == 200) {
            $this->view->countrylist = $curlResponse->data;
        }
        $url1 = $this->_appSetting->apiLink . '/storedetails?method=storeCategory';
        $curlResponse3 = $objCurlHandler->curlUsingGet($url1);
        if ($curlResponse3->code == 200) {
            $this->view->categorylist = $curlResponse3->data;
        }
        $agentid = $this->view->session->storage->agent_id;
        if ($this->getRequest()->isPost()) {
            $cuisines = array();
            $data['select_country'] = $this->getRequest()->getPost('selectcountry');
            $data['select_state'] = $this->getRequest()->getPost('selectstate');
            $data['select_city'] = $this->getRequest()->getPost('selectcity');
            $data['primary_phone'] = $this->getRequest()->getPost('primary_phone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
            $data['store_name'] = $this->getRequest()->getPost('store_name');
            $data['open_time'] = $this->getRequest()->getPost('open_time');
            $data['closing_time'] = $this->getRequest()->getPost('closing_time');
            $data['notice'] = $this->getRequest()->getPost('notice');
            $data['address'] = $this->getRequest()->getPost('address');
            $data['cat_name'] = json_encode($this->getRequest()->getPost('cat_name'));
            $data['deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
            $data['store_status'] = $this->getRequest()->getPost('store_status');
            $data['agent_id'] = $agentid;




            $storelocation = $this->getRequest()->getPost('selectlocation');

            if (!empty($storelocation)) {

                $data['store_location'] = $storelocation;
                $url = $this->_appSetting->apiLink . '/storedetails?method=addstoredetails';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                if ($curlResponse->code == 200) {
                    $coverphoto = $_FILES["fileToUpload"]["name"];
                    $store_id = $curlResponse->data['store_id'];
                    $dirpath = getcwd() . "/themes/agent/skin/groceryimages/$agentid/$store_id/";
                    if (!file_exists($dirpath)) {
                        mkdir($dirpath, 0777, true);
                    }
                    if (!empty($coverphoto)) {
                        $imagepath = $dirpath . $coverphoto;
                        $savepath = "/themes/agent/skin/groceryimages/$agentid/$store_id/$coverphoto";
                        $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                        $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                        if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                            echo json_encode("Something went wrong image upload");
                        } else {
                            $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                            if ($imagemoveResult) {
                                $link = $this->_appSetting->hostLink;
                                $da['Store_image'] = $link . $savepath;
                                $da['store_id'] = $store_id;
                                $url = $this->_appSetting->apiLink . '/storedetails?method=updatestoredetails';
                                $curlResponse = $objCurlHandler->curlUsingPost($url, $da);
                            }
                        }
                    } else {
                        $this->view->errormessage = 'Store cover images in not updated ';
                    }
                } else {

                    $this->view->errormessage = 'Store details are not inserted properly';
                }
            } else {
                $location['name'] = $this->getRequest()->getPost('location_name');
                if ($data['select_city']) {
                    $location['parent_id'] = $data['select_city'];
                    $location['location_status'] = 1;
                    $location['location_type'] = 3;
                    $location['country_id'] = $data['select_country'];
                    $location['state_id'] = $data['select_state'];

                    ///insert new location //  

                    $url = $this->_appSetting->apiLink . '/get-restaurants-list?method=addNewlocation';
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $location);

                    if ($curlResponse->code == 200) {
                        $data['store_location'] = $curlResponse->data;
                        $url = $this->_appSetting->apiLink . '/storedetails?method=addstoredetails';
                        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                        if ($curlResponse->code == 200) {
                            $coverphoto = $_FILES["fileToUpload"]["name"];
                            $store_id = $curlResponse->data['store_id'];
                            $dirpath = getcwd() . "/themes/agent/skin/groceryimages/$agentid/$store_id/";
                            if (!file_exists($dirpath)) {
                                mkdir($dirpath, 0777, true);
                            }
                            if (!empty($coverphoto)) {
                                $imagepath = $dirpath . $coverphoto;
                                $savepath = "/themes/agent/skin/groceryimages/$agentid/$store_id/$coverphoto";
                                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                                    echo json_encode("Something went wrong image upload");
                                } else {
                                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                                    if ($imagemoveResult) {
                                        $link = $this->_appSetting->hostLink;
                                        $dat['Store_image'] = $link . $savepath;
                                        $dat['store_id'] = $store_id;
                                        $url = $this->_appSetting->apiLink . '/storedetails?method=updatestoredetails';
                                        $curlResponse = $objCurlHandler->curlUsingPost($url, $dat);
                                    }
                                }
                            } else {

                                $this->view->errormessage = 'Store cover images in not updated ';
                            }
                        } else {
                            $this->view->errormessage = 'Store details are not inserted properly';
                        }
                    } else {
                        $this->view->errormessage = 'Store location is not inserted properly, please try again';
                    }
                } else {
                    $this->view->errormessage = 'Store location is not inserted properly, please try again';
                }
            }
        }
    }

    /*
     * Dev: sowmya
     * Date : 11/4/2016
     * Desc: To view  store details of agent 
     * 
     */

    public function viewStoreDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $store_id = $this->getRequest()->getParam('storeid');

        $url = $this->_appSetting->apiLink . '/storedetails?method=getStoreDetailsByStoreId';
        $data['store_id'] = $store_id;
        $curlResponse1 = $objCurlHandler->curlUsingPost($url, $data);
        if ($curlResponse1->code == 200) {
            $this->view->storedetails = $curlResponse1->data;
        }
    }

}
