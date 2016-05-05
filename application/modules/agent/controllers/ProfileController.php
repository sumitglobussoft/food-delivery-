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

        $url = $this->_appSetting->apiLink . '/get-locations?method=getlocations';

        $curlResponse = $objCurlHandler->curlUsingGet($url);
        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse2 = $objCurlHandler->curlUsingGet($url);


        if ($curlResponse->code == 200) {
            $this->view->locationdetails = $curlResponse->data;
            $this->view->countrylist = $curlResponse2->data;
        }
    }

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

    public function hotelCuisinesAction() {
        
    }

    public function hotelCategoryAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        $url = $this->_appSetting->apiLink . '/settingdetails?method=getCategories';
        $curlResponse = $objCurlHandler->curlUsingGet($url);

        if ($curlResponse->code == 200) {
            $this->view->categorydetails = $curlResponse->data;
        }
    }

    public function groceryCategoryAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($this->getRequest()->isPost()) {
            $data['cat_name'] = $this->getRequest()->getPost('categoryname');
            $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
            $data['cat_status'] = $this->getRequest()->getPost('cat_status');
            $url = $this->_appSetting->apiLink . '/grocerydetails?method=addGroceryCategory';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
            if ($curlResponse) {
                $this->redirect('/agent/grocery-category');
            }
        }
        $url1 = $this->_appSetting->apiLink . '/grocerydetails?method=groceryCategory';
        $curlResponse1 = $objCurlHandler->curlUsingGet($url1);
        if ($curlResponse1->code == 200) {
            $this->view->categorydetails = $curlResponse1->data;
        }
    }

    /*
     * Dev: sowmya
     * Desc: edit category
     * date : 2/4/2016
     */

    public function editGroceryCategoryAction() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        if ($this->getRequest()->isPost()) {
            $data['cat_name'] = $this->getRequest()->getPost('category');
            $data['cat_desc'] = $this->getRequest()->getPost('catdesc');
            $category_id = $this->getRequest()->getPost('category_id');
            $categoryname = $this->getRequest()->getPost('categorybtn');
            $url = $this->_appSetting->apiLink . '/grocerydetails?method=updateGroceryCategory';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data, $category_id, $categoryname);
            if ($curlResponse) {
                $this->redirect('/agent/grocery-category');
            }
        }
    }

}
