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
        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';

        $curlResponse = $objCurlHandler->curlUsingGet($url);
       
        if ($curlResponse->code == 200) {
            $this->view->countrydetails = $curlResponse->data;
        }
    }

    public function cityAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $url = $this->_appSetting->apiLink . '/get-locations?method=getcity';

        $curlResponse = $objCurlHandler->curlUsingGet($url);
       
        if ($curlResponse->code == 200) {
            $this->view->countrydetails = $curlResponse->data;
        }
    }

    public function locationAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $url = $this->_appSetting->apiLink . '/get-locations?method=getlocation';

        $curlResponse = $objCurlHandler->curlUsingGet($url);
       
        if ($curlResponse->code == 200) {
            $this->view->countrydetails = $curlResponse->data;
        }
    }

    public function hotelCuisinesAction() {
        
    }

    public function hotelCategoryAction() {
        
    }

    public function groceryCategoryAction() {
        
    }

}
