<?php

/**
 * Agent_ProfileController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Agent_ProfileController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * DEV :sowmya
     * Desc : to edit agent profile
     * Date : 5/5/2016
     */

    public function editProfileAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;
        if ($this->getRequest()->isPost()) {
            $data['agent_id'] = $agent_id;
            $data['loginname'] = $this->getRequest()->getPost('loginname');
            $data['first_name'] = $this->getRequest()->getPost('first_name');
            $data['last_name'] = $this->getRequest()->getPost('last_name');
            $data['email'] = $this->getRequest()->getPost('email');
            $data['city'] = $this->getRequest()->getPost('city');
            $data['agent_status'] = 1;
            $data['addresss'] = $this->getRequest()->getPost('addresss');
            $data['membership'] = 1;
            $data['role'] = 4;
            $data['phone'] = $this->getRequest()->getPost('phone');
            $data['contact_country_code'] = $this->getRequest()->getPost('contact_country_code');
            $coverphoto = $_FILES["fileToUpload"]["name"];

            $dirpath = getcwd() . "/assets/agentimages/$agent_id/";
            if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
            }
            if (!empty($coverphoto)) {
                $imagepath = $dirpath . $coverphoto;
                $savepath = "/assets/agentimages/$agent_id/$coverphoto";
                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                    if ($imagemoveResult) {
                        $link = $this->_appSetting->hostLink;
                        $data['profilepic_url'] = $link . $savepath;
                        $url = $this->_appSetting->apiLink . '/agent-authentication?method=updateagentdetails';
                        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                        if ($curlResponse->code == 200) {
                            $this->redirect('/agent/edit-profile');
                        }
                    } else {
                        echo "DIE HERE";
                        die;
                    }
                }
            } else {
                $url = $this->_appSetting->apiLink . '/agent-authentication?method=updateagentdetails';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                if ($curlResponse->code == 200) {
                    $this->redirect('/agent/edit-profile');
                }
            }
        }

        $url = $this->_appSetting->apiLink . '/agent-authentication?method=agentdetails';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
        if ($curlResponse->code == 200) {
            $this->view->agentdetails = $curlResponse->data;
        }

        $url = $this->_appSetting->apiLink . '/get-locations?method=countryCodeDetails';
        $curlResponse2 = $objCurlHandler->curlUsingGet($url);
        if ($curlResponse2->code == 200) {
            $this->view->countryCodeDetails = $curlResponse2->data;
        }
    }

    /*
     * DEV :sowmya
     * Desc : to cahnge agent password
     * Date : 5/5/2016
     */

    public function changePasswordAction() {
        $this->_helper->_layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $agent_id = $this->view->session->storage->agent_id;
        $this->_appSetting = $objCore->getAppSetting();
        if ($this->getRequest()->isPost()) {
            $data['agent_id'] = $agent_id;
            $data['password'] = $this->getRequest()->getPost('password');
            $data['password1'] = $this->getRequest()->getPost('password1');
            $data['password2'] = $this->getRequest()->getPost('password2');

            $url = $this->_appSetting->apiLink . '/agent-authentication?method=changepassword';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
            if ($curlResponse) {
                $this->redirect('/agent/edit-profile');
            }
        }
    }

    /*
     * DEV :sowmya
     * Desc : to get and add country
     * Date : 5/5/2016
     */

    public function countryAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();


        if ($this->getRequest()->isPost()) {
            $data['name'] = $this->getRequest()->getPost('name');
            $data['location_status'] = $this->getRequest()->getPost('location_status');
            $data['location_type'] = 0;
            $data['parent_id'] = 0;

            $url = $this->_appSetting->apiLink . '/settingdetails?method=addcountry';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
            if ($curlResponse) {
                $this->redirect('/agent/country-details');
            }
        }

        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountry';
        $curlResponse = $objCurlHandler->curlUsingGet($url);

        if ($curlResponse->code == 200) {
            $this->view->countrydetails = $curlResponse->data;
        }
    }

    /*
     * DEV :sowmya
     * Desc : to get and add state
     * Date : 5/5/2016
     */

    public function stateAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($this->getRequest()->isPost()) {
            $data['name'] = $this->getRequest()->getPost('name');
            $data['location_status'] = $this->getRequest()->getPost('location_status');
            $data['location_type'] = 1;
            $data['parent_id'] = $this->getRequest()->getPost('parent_id');


            $url = $this->_appSetting->apiLink . '/settingdetails?method=addcountry';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
            if ($curlResponse) {
                $this->redirect('/agent/state-details');
            }
        }



        $url = $this->_appSetting->apiLink . '/get-locations?method=getstates';
        $curlResponse = $objCurlHandler->curlUsingGet($url);

        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse2 = $objCurlHandler->curlUsingGet($url);

        if ($curlResponse->code == 200) {
            $this->view->statedetails = $curlResponse->data;
            $this->view->countrylist = $curlResponse2->data;
        }
    }

    /*
     * DEV :sowmya
     * Desc : to get and add city
     * Date : 5/5/2016
     */

    public function cityAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($this->getRequest()->isPost()) {
            $data['name'] = $this->getRequest()->getPost('name');
            $data['location_status'] = $this->getRequest()->getPost('location_status');
            $data['location_type'] = 2;
            $data['parent_id'] = $this->getRequest()->getPost('parent_id');


            $url = $this->_appSetting->apiLink . '/settingdetails?method=addcountry';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);


            if ($curlResponse) {
                $this->redirect('/agent/city-details');
            }
        }


        $url = $this->_appSetting->apiLink . '/get-locations?method=getcities';
        $curlResponse = $objCurlHandler->curlUsingGet($url);

        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse2 = $objCurlHandler->curlUsingGet($url);

        if ($curlResponse->code == 200) {
            $this->view->citydetails = $curlResponse->data;
            $this->view->countrylist = $curlResponse2->data;
        }
    }

    /*
     * DEV :sowmya
     * Desc : to get and add location
     * Date : 5/5/2016
     */

    public function locationAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($this->getRequest()->isPost()) {
            $data['name'] = $this->getRequest()->getPost('name');
            $data['location_status'] = $this->getRequest()->getPost('location_status');
            $data['location_type'] = 3;
            $data['parent_id'] = $this->getRequest()->getPost('parent_id');


            $url = $this->_appSetting->apiLink . '/settingdetails?method=addcountry';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
            if ($curlResponse) {
                $this->redirect('/agent/location-details');
            }
        }

        $url = $this->_appSetting->apiLink . '/get-locations?method=getlocation';

        $curlResponse = $objCurlHandler->curlUsingGet($url);
        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse2 = $objCurlHandler->curlUsingGet($url);


        if ($curlResponse->code == 200) {
            $this->view->locationdetails = $curlResponse->data;
            $this->view->countrylist = $curlResponse2->data;
        }
    }

    /*
     * DEV :sowmya
     * Desc : to edit location
     * Date : 5/5/2016
     */

    public function editLocationAction() {
        $this->_helper->_layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();



        if ($this->getRequest()->isPost()) {
            $data['name'] = $this->getRequest()->getPost('location');
            $data['location_id'] = $this->getRequest()->getPost('location_id');
            $locationname = $this->getRequest()->getPost('locationbtn');

            $url = $this->_appSetting->apiLink . '/settingdetails?method=editcountry';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
            if ($locationname == 'country') {
                if ($curlResponse) {
                    $this->redirect('/agent/country-details');
                } else {
                    $this->redirect('/agent/country-details');
                }
            } else if ($locationname == 'state') {
                if ($curlResponse) {
                    $this->redirect('/agent/state-details');
                } else {
                    $this->redirect('/agent/state-details');
                }
            } else if ($locationname == 'city') {
                if ($curlResponse) {
                    $this->redirect('/agent/city-details');
                } else {
                    $this->redirect('/agent/city-details');
                }
            } else if ($locationname == 'location') {
                if ($curlResponse) {
                    $this->redirect('/agent/location-details');
                } else {
                    $this->redirect('/agent/location-details');
                }
            } else {
                $this->redirect('/agent/country-details');
            }
        }
    }

    /*
     * DEV :sowmya
     * Desc : to  add and get hotel cuisines
     * Date : 5/5/2016
     */

    public function hotelCuisinesAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($this->getRequest()->isPost()) {
            $data['Cuisine_name'] = $this->getRequest()->getPost('cuisinename');
            $data['cuisine_status'] = $this->getRequest()->getPost('cuisine_status');
//            $cuisine_id = $cuisinesModel->addCuisines($data);
            $url = $this->_appSetting->apiLink . '/settingdetails?method=addCuisinesDetails';
            $cuisine_id = $objCurlHandler->curlUsingPost($url, $data);
            $cuisine_id = $cuisine_id->data;
            $hotelcuisinesdata['cuisine_id'] = $cuisine_id;
            $hotelcuisinesdata['hotel_id'] = $this->getRequest()->getPost('hotels');
//            $result = $hotelcuisinesModel->addCuisinesDetails($hotelcuisinesdata);
            $url = $this->_appSetting->apiLink . '/settingdetails?method=addhotelcuisines';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $hotelcuisinesdata);

            if ($curlResponse) {
                $this->redirect('/agent/hotel-cuisine');
            } else {
                $this->redirect('/agent/hotel-cuisine');
            }
        }


        $url = $this->_appSetting->apiLink . '/settingdetails?method=getCuisines';
        $curlResponse = $objCurlHandler->curlUsingGet($url);
        if ($curlResponse->code == 200) {
            $this->view->cuisinedetails = $curlResponse->data;
        }
    }

    /*
     * DEV :sowmya
     * Desc : toadd and get hotel category
     * Date : 5/5/2016
     */

    public function hotelCategoryAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($this->getRequest()->isPost()) {
            $data['categoryname'] = $this->getRequest()->getPost('categoryname');
            $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
            $data['cat_status'] = $this->getRequest()->getPost('cat_status');
            $url = $this->_appSetting->apiLink . '/settingdetails?method=addhotelcategory';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

            if ($curlResponse) {
                $this->redirect('/agent/hotel-category');
            } else {
                $this->redirect('/agent/hotel-category');
            }
        }


        $url = $this->_appSetting->apiLink . '/settingdetails?method=getCategories';
        $curlResponse = $objCurlHandler->curlUsingGet($url);

        if ($curlResponse->code == 200) {
            $this->view->categorydetails = $curlResponse->data;
        }
    }

    /*
     * DEV :sowmya
     * Desc : to add and get store category
     * Date : 5/5/2016
     */

    public function storeCategoryAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($this->getRequest()->isPost()) {
            $data['cat_name'] = $this->getRequest()->getPost('categoryname');
            $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
            $data['cat_status'] = $this->getRequest()->getPost('cat_status');
            $url = $this->_appSetting->apiLink . '/storedetails?method=addStoreCategory';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
            if ($curlResponse) {
                $this->redirect('/agent/store-category');
            }
        }
        $url1 = $this->_appSetting->apiLink . '/storedetails?method=storeCategory';
        $curlResponse1 = $objCurlHandler->curlUsingGet($url1);
        if ($curlResponse1->code == 200) {
            $this->view->categorydetails = $curlResponse1->data;
        }
    }

    /*
     * Dev: sowmya
     * Desc: edit category
     * date : 2/4/2016
     * modified by sreekanth
     * date: 5-5-2016
     */

    public function editStoreCategoryAction() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        if ($this->getRequest()->isPost()) {
            $data['categoryname'] = $this->getRequest()->getPost('category');
            $data['category_id'] = $this->getRequest()->getPost('category_id');
            $data['cat_desc'] = $this->getRequest()->getPost('catdesc');
            $url = $this->_appSetting->apiLink . '/storedetails?method=updateStoreCategory';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
            if ($curlResponse) {
                $this->redirect('/agent/store-category');
            }
        }
    }

    /*
     * DEV :sowmya
     * Desc : to edit hotel category
     * Date : 5/5/2016
     */

    public function editHotelCategoryAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($this->getRequest()->isPost()) {
            $data['categoryname'] = $this->getRequest()->getPost('category');
            $data['category_id'] = $this->getRequest()->getPost('category_id');
            $data['cat_desc'] = $this->getRequest()->getPost('catdesc');

            $url = $this->_appSetting->apiLink . '/settingdetails?method=editcategory';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

            if ($curlResponse) {
                $this->redirect('/agent/hotel-category');
            } else {
                $this->redirect('/agent/hotel-category');
            }
        }


        $url = $this->_appSetting->apiLink . '/settingdetails?method=getCategories';
        $curlResponse = $objCurlHandler->curlUsingGet($url);

        if ($curlResponse->code == 200) {
            $this->view->categorydetails = $curlResponse->data;
        }
    }

//Dev: sreekanth
//Date: 5-5-2016
    // to edit hotel cuisines
    public function editHotelCuisinesAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();


        if ($this->getRequest()->isPost()) {

            $data['Cuisine_name'] = $this->getRequest()->getPost('cuisine');
            $data['cuisine_id'] = $this->getRequest()->getPost('cuisine_id');
            $url = $this->_appSetting->apiLink . '/settingdetails?method=edithotelcuisines';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

            if ($curlResponse) {
                $this->redirect('/agent/hotel-cuisine');
            } else {
                $this->redirect('/agent/hotel-cuisine');
            }
        }

        $url = $this->_appSetting->apiLink . '/settingdetails?method=getCategories';
        $curlResponse = $objCurlHandler->curlUsingGet($url);

        if ($curlResponse->code == 200) {
            $this->view->categorydetails = $curlResponse->data;
        }
    }

}
