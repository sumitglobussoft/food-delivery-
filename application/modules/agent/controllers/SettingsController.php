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
     * Dev: sowmya
     * Date 11/4/2016
     * Desc: To  edit hotel details of agent 
     * 
     */

    public function editHotelDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agentid = $this->view->session->storage->agent_id;
        $hotel_id = $this->getRequest()->getParam('hotelid');
        $dt['hotel_id'] = $hotel_id;
        $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getcuisinesofHotel';
        $curlResponse1 = $objCurlHandler->curlUsingPost($url, $dt);
//        print_r($curlResponse1);
        $i = 0;
        if ($curlResponse1->code == 200) {
            foreach ($curlResponse1->data as $value) {
                $array[$i] = $value['Cuisine_name'];
                $i++;
            }
            $this->view->cuisine123 = implode($array, ',');
        }
        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse2 = $objCurlHandler->curlUsingGet($url);
        if ($curlResponse2->code == 200) {
            $this->view->countrylist = $curlResponse2->data;
        }

        if ($this->getRequest()->isPost()) {

            $data['id'] = $hotel_id;
            $data['selectlocation'] = $this->getRequest()->getPost('selectlocation');
            $data['select_state'] = $this->getRequest()->getPost('selectstate');
            $data['select_city'] = $this->getRequest()->getPost('selectcity');
            $data['primary_phone'] = $this->getRequest()->getPost('primary_phone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
            $data['hotel_name'] = $this->getRequest()->getPost('hotel_name');
            $data['open_time'] = $this->getRequest()->getPost('open_time');
            $data['closing_time'] = $this->getRequest()->getPost('closing_time');
            $data['notice'] = $this->getRequest()->getPost('notice');
            $data['hotel_status'] = $this->getRequest()->getPost('hotel_status');
            $data['address'] = $this->getRequest()->getPost('address');
            $data['deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
            $data['minorder'] = $this->getRequest()->getPost('minorder');
            $coverphoto = $_FILES["fileToUpload"]["name"];
           
            $dirpath = getcwd() . "/themes/agent/skin/hotelimages/$agentid/$hotel_id/";

            if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
            }
            if (!empty($coverphoto)) {
                $imagepath = $dirpath . $coverphoto;
                $savepath = "/themes/agent/skin/hotelimages/$agentid/$hotel_id/$coverphoto";
                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));

                    if ($imagemoveResult) {
                        $link = $this->_appSetting->hostLink;
                        $data['hotel_image'] = $link . $savepath;
                        $url = $this->_appSetting->apiLink . '/hoteldetails?method=updatehoteldetails';
                        $curlResponse3 = $objCurlHandler->curlUsingPost($url, $data);

                        if ($curlResponse3->code == 200) {
                            $this->redirect('/agent/hotel-details');
                        }
                    } else {

                        echo "DIE HERE";
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

        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse = $objCurlHandler->curlUsingGet($url);
        if ($curlResponse->code == 200) {
            $this->view->countrylist = $curlResponse->data;
        }

        $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getcuisines';
        $curlResponse = $objCurlHandler->curlUsingGet($url);

        if ($curlResponse->code == 200) {
            $this->view->cuisineslist = $curlResponse->data;
        }


        $agentid = $this->view->session->storage->agent_id;
        if ($this->getRequest()->isPost()) {
            $cuisines = array();
            $data['select_country'] = $this->getRequest()->getPost('selectcountry');
            $data['select_state'] = $this->getRequest()->getPost('selectstate');
            $data['select_city'] = $this->getRequest()->getPost('selectcity');
            $data['primary_phone'] = $this->getRequest()->getPost('primary_phone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
            $data['hotel_name'] = $this->getRequest()->getPost('hotel_name');
            $data['open_time'] = $this->getRequest()->getPost('open_time');
            $data['closing_time'] = $this->getRequest()->getPost('closing_time');
            $data['notice'] = $this->getRequest()->getPost('notice');
            $data['address'] = $this->getRequest()->getPost('address');
            $data['minorder'] = $this->getRequest()->getPost('minorder');
            $data['deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
            $data['hotel_status'] = $this->getRequest()->getPost('hotel_status');
            $data['agent_id'] = $agentid;


            $cuisines = $this->getRequest()->getPost('selectcuisine');

            $hotellocation = $this->getRequest()->getPost('selectlocation');

            if (!empty($hotellocation)) {

                $data['hotel_location'] = $hotellocation;
                $url = $this->_appSetting->apiLink . '/hoteldetails?method=addhoteldetails';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                if ($curlResponse->code == 200) {
                    $coverphoto = $_FILES["fileToUpload"]["name"];
                    $hotel_id = $curlResponse->data['hotel_id'];
                    $dirpath = getcwd() . "/themes/agent/skin/hotelimages/$agentid/$hotel_id/";
                    if (!file_exists($dirpath)) {
                        mkdir($dirpath, 0777, true);
                    }
                    if (!empty($coverphoto)) {
                        $imagepath = $dirpath . $coverphoto;
                        $savepath = "/themes/agent/skin/hotelimages/$agentid/$hotel_id/$coverphoto";
                        $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                        $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                        if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                            echo json_encode("Something went wrong image upload");
                        } else {
                            $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                            if ($imagemoveResult) {
                                $link = $this->_appSetting->hostLink;
                                $da['hotel_image'] = $link . $savepath;
                                $da['id'] = $hotel_id;
                                $url = $this->_appSetting->apiLink . '/hoteldetails?method=updatehoteldetails';
                                $curlResponse = $objCurlHandler->curlUsingPost($url, $da);
                            }
                        }
                    } else {
                        $this->view->errormessage = 'Hotel cover images in not updated ';
                    }
                    if ($cuisines) {

                        $i = 0;
                        foreach ($cuisines as $value) {
                            $array[$i]['cuisine_id'] = $value;
                            $array[$i]['hotel_id'] = $hotel_id;
                            $i++;
                        }

                        $cui['cuisines'] = json_encode($array, true);

                        $url = $this->_appSetting->apiLink . '/search-hotels-by?method=insertCuisines';
                        $curlResponse = $objCurlHandler->curlUsingPost($url, $cui);
                        if ($curlResponse->code = 200) {
                            
                        }
                    } else {
                        $this->view->errormessage = 'Hotel cuisines are not inserted properly';
                    }
                } else {

                    $this->view->errormessage = 'Hotel details are not inserted properly';
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
                        $data['hotel_location'] = $curlResponse->data;
                        $url = $this->_appSetting->apiLink . '/hoteldetails?method=addhoteldetails';
                        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                        if ($curlResponse->code == 200) {
                            $coverphoto = $_FILES["fileToUpload"]["name"];
                            $hotel_id = $curlResponse->data['hotel_id'];
                            $dirpath = getcwd() . "/themes/agent/skin/hotelimages/$agentid/$hotel_id/";
                            if (!file_exists($dirpath)) {
                                mkdir($dirpath, 0777, true);
                            }
                            if (!empty($coverphoto)) {
                                $imagepath = $dirpath . $coverphoto;
                                $savepath = "/themes/agent/skin/hotelimages/$agentid/$hotel_id/$coverphoto";
                                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                                    echo json_encode("Something went wrong image upload");
                                } else {
                                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                                    if ($imagemoveResult) {
                                        $link = $this->_appSetting->hostLink;
                                        $dat['hotel_image'] = $link . $savepath;
                                        $dat['id'] = $hotel_id;
                                        $url = $this->_appSetting->apiLink . '/hoteldetails?method=updatehoteldetails';
                                        $curlResponse = $objCurlHandler->curlUsingPost($url, $dat);
                                    }
                                }
                            } else {

                                $this->view->errormessage = 'Hotel cover images in not updated ';
                            }
                            if ($cuisines) {

                                $i = 0;
                                foreach ($cuisines as $value) {
                                    $array[$i]['cuisine_id'] = $value;
                                    $array[$i]['hotel_id'] = $hotel_id;
                                    $i++;
                                }

                                $cui['cuisines'] = json_encode($array, true);

                                $url = $this->_appSetting->apiLink . '/search-hotels-by?method=insertCuisines';
                                $curlResponse = $objCurlHandler->curlUsingPost($url, $cui);
                                if ($curlResponse->code = 200) {
                                    
                                }
                            } else {
                                $this->view->errormessage = 'Hotel cuisines are not inserted properly';
                            }
                        } else {
                            $this->view->errormessage = 'Hotel details are not inserted properly';
                        }
                    } else {
                        $this->view->errormessage = 'Hotel location is not inserted properly, please try again';
                    }
                } else {
                    $this->view->errormessage = 'Hotel location is not inserted properly, please try again';
                }
            }
        }
    }

    /*
     * Dev: sowmya
     * Date : 11/4/2016
     * Desc: To view  hotel details of agent 
     * 
     */

    public function viewHotelDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $hotel_id = $this->getRequest()->getParam('hotelid');
        $dt['hotel_id'] = $hotel_id;
        $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getcuisinesofHotel';
        $curlResponse = $objCurlHandler->curlUsingPost($url, $dt);
        $i = 0;
        if ($curlResponse->code == 200) {
            foreach ($curlResponse->data as $value) {
                $array[$i] = $value['Cuisine_name'];
                $i++;
            }
            $this->view->cuisine123 = implode($array, ',');
        }

        $url = $this->_appSetting->apiLink . '/hoteldetails?method=getHotelDetailsByHotelId';
        $data['hotel_id'] = $hotel_id;
        $curlResponse1 = $objCurlHandler->curlUsingPost($url, $data);
        if ($curlResponse1->code == 200) {
            $this->view->hoteldetails = $curlResponse1->data;
        }

        $url = $this->_appSetting->apiLink . '/get-locations?method=getHotelLocation';
        $data['hotel_id'] = $hotel_id;
        $curlResponse2 = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse2->code == 200) {

            $this->view->hotellocation = $curlResponse2->data;
        }
    }

}
