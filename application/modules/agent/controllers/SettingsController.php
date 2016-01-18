<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Agent_SettingsController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * Dev: Priyanka Varanasi
     * Date : 17/12/2015
     * Desc: To get all hotel details regarding logged agent
     * 
     */

    public function agentHotelDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/hoteldetails?method=getHotelDetailsByAgentId';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse->code == 200) {

            $this->view->hoteldetails = $curlResponse->data;
        }
    }

    /*
     * Dev: Priyanka Varanasi
     * Date : 18/12/2015
     * Desc: To view and edit hotel details of agent 
     * 
     */

    public function editHotelDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agentid = $this->view->session->storage->agent_id;
        $hotel_id = $this->getRequest()->getParam('hotelid');
        if ($this->getRequest()->isPost()) {

            $data['id'] = $hotel_id;
            $data['owner_fname'] = $this->getRequest()->getPost('first_name');
            $data['owner_lname'] = $this->getRequest()->getPost('last_name');
            $data['city'] = $this->getRequest()->getPost('city');
            $data['state'] = $this->getRequest()->getPost('state');
            $data['country'] = $this->getRequest()->getPost('country');
            $data['primary_phone'] = $this->getRequest()->getPost('prphone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secphone');
            $data['hotel_name'] = $this->getRequest()->getPost('hotelname');
            $data['open_time'] = $this->getRequest()->getPost('opentime');
            $data['closing_time'] = $this->getRequest()->getPost('closetime');
            $data['notice'] = $this->getRequest()->getPost('notice');
            $data['hotel_status'] = $this->getRequest()->getPost('status');

            $coverphoto = $_FILES["fileToUpload"]["name"];

            $dirpath = getcwd()."/themes/agent/skin/hotelimages/$agentid/$hotel_id/";
            
             if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
                 }
            if (!empty($coverphoto)) {
               $imagepath = $dirpath.$coverphoto;
               $savepath = "/themes/agent/skin/hotelimages/$agentid/$hotel_id/$coverphoto";
               $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
               $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$imagepath));
                     if ($imagemoveResult) {
                    $data['hotel_image'] = $savepath;
                    $url = $this->_appSetting->apiLink . '/hoteldetails?method=updatehoteldetails';
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    
                    if ($curlResponse->code == 200) {
                        $this->redirect('/agent/hotel-details');
                    }
                }else{
                    
                    echo "DIE HERE" ;die;
                }
                }
            } else {
                $url = $this->_appSetting->apiLink . '/hoteldetails?method=updatehoteldetails';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                if ($curlResponse->code == 200) {
                    $this->redirect('/agent/hotel-details');
                }
            }
        }

        $url = $this->_appSetting->apiLink . '/hoteldetails?method=getHotelDetailsByHotelId';
        $data['hotel_id'] = $hotel_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse->code == 200) {
            $this->view->hoteldetails = $curlResponse->data;
        }
    }

    /*
     * Dev: Priyanka Varanasi
     * Date : 18/12/2015
     * Desc: To add hotel details 
     * 
     */

    public function addHotelDetailsAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agentid = $this->view->session->storage->agent_id;
        if ($this->getRequest()->isPost()) {
            $data['owner_fname'] = $this->getRequest()->getPost('first_name');
             $data['agent_id'] = $agentid;
            $data['owner_lname'] = $this->getRequest()->getPost('last_name');
            $data['city'] = $this->getRequest()->getPost('city');
            $data['state'] = $this->getRequest()->getPost('state');
            $data['country'] = $this->getRequest()->getPost('country');
            $data['primary_phone'] = $this->getRequest()->getPost('prphone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secphone');
            $data['hotel_name'] = $this->getRequest()->getPost('hotelname');
            $data['open_time'] = $this->getRequest()->getPost('opentime');
            $data['closing_time'] = $this->getRequest()->getPost('closetime');
            $data['notice'] = $this->getRequest()->getPost('notice');
            $data['hotel_status'] = $this->getRequest()->getPost('status');
            
          $url = $this->_appSetting->apiLink . '/hoteldetails?method=addhoteldetails';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
           if ($curlResponse->code == 200) {
            $coverphoto = $_FILES["fileToUpload"]["name"];
            $hotel_id = $curlResponse->data['hotel_id'];
            $dirpath = getcwd()."/themes/agent/skin/hotelimages/$agentid/$hotel_id/";
              if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
                 }
            if (!empty($coverphoto)) {
               $imagepath = $dirpath.$coverphoto;
               $savepath = "/themes/agent/skin/hotelimages/$agentid/$hotel_id/$coverphoto";
               $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
               $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$imagepath));      
                    if ($imagemoveResult) {
                    $data['hotel_image'] = $savepath;
                    $data['id'] = $hotel_id;
                    $url = $this->_appSetting->apiLink . '/hoteldetails?method=updatehoteldetails';
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        $this->redirect('/agent/hotel-details');
                    }
           }
    }
              }
           }
        }
    }
}
