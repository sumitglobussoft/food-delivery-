<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Agent_GroceryController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * Dev: Priyanka Varanasi
     * Date : 17/12/2015
     * Desc: To get all grocery details regarding logged agent
     * 
     */

    public function groceryDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/grocerydetails?method=getGroceryDetailsByAgentId';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse->code == 200) {

            $this->view->grocerydetails = $curlResponse->data;
        }
    }

    /*
     * Dev: sowmya
     * Date 11/4/2016
     * Desc: To  edit grocery details of agent 
     * 
     */

    public function editGroceryDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agentid = $this->view->session->storage->agent_id;
        $grocery_id = $this->getRequest()->getParam('groceryid');
   
        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse2 = $objCurlHandler->curlUsingGet($url);
        if ($curlResponse2->code == 200) {
            $this->view->countrylist = $curlResponse2->data;
        }

        if ($this->getRequest()->isPost()) {

            $data['grocery_id'] = $grocery_id;
            $data['selectlocation'] = $this->getRequest()->getPost('selectlocation');
            $data['select_state'] = $this->getRequest()->getPost('selectstate');
            $data['select_city'] = $this->getRequest()->getPost('selectcity');
            $data['primary_phone'] = $this->getRequest()->getPost('primary_phone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
            $data['grocery_name'] = $this->getRequest()->getPost('grocery_name');
            $data['open_time'] = $this->getRequest()->getPost('open_time');
            $data['closing_time'] = $this->getRequest()->getPost('closing_time');
            $data['notice'] = $this->getRequest()->getPost('notice');
            $data['grocery_status'] = $this->getRequest()->getPost('grocery_status');
            $data['address'] = $this->getRequest()->getPost('address');
            $data['deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
            $data['minorder'] = $this->getRequest()->getPost('minorder');
            $coverphoto = $_FILES["fileToUpload"]["name"];

            $dirpath = getcwd() . "/themes/agent/skin/groceryimages/$agentid/$grocery_id/";

            if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
            }
            if (!empty($coverphoto)) {
                $imagepath = $dirpath . $coverphoto;
                $savepath = "/themes/agent/skin/groceryimages/$agentid/$grocery_id/$coverphoto";
                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));

                    if ($imagemoveResult) {
                        $link = $this->_appSetting->hostLink;
                        $data['Grocery_image'] = $link . $savepath;
                        $url = $this->_appSetting->apiLink . '/grocerydetails?method=updategrocerydetails';
                        $curlResponse3 = $objCurlHandler->curlUsingPost($url, $data);

                        if ($curlResponse3->code == 200) {
                            $this->redirect('/agent/grocery-details');
                        }
                    } else {

                        echo "DIE HERE";
                    }
                }
            } else {
                $url = $this->_appSetting->apiLink . '/grocerydetails?method=updategrocerydetails';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                if ($curlResponse->code == 200) {
                    $this->redirect('/agent/grocery-details');
                }
            }
        }

        $url = $this->_appSetting->apiLink . '/grocerydetails?method=getGroceryDetailsByGroceryId';
        $data['grocery_id'] = $grocery_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse->code == 200) {
            $this->view->grocerydetails = $curlResponse->data;
        }
    }

    /*
     * Dev: Priyanka Varanasi
     * Date : 18/12/2015
     * Desc: To add grocery details 
     * 
     */

    public function addGroceryDetailsAction() {


        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        $url = $this->_appSetting->apiLink . '/get-locations?method=getcountrys';
        $curlResponse = $objCurlHandler->curlUsingGet($url);
        if ($curlResponse->code == 200) {
            $this->view->countrylist = $curlResponse->data;
        }

        $agentid = $this->view->session->storage->agent_id;
        if ($this->getRequest()->isPost()) {
            $cuisines = array();
            $data['select_country'] = $this->getRequest()->getPost('selectcountry');
            $data['select_state'] = $this->getRequest()->getPost('selectstate');
            $data['select_city'] = $this->getRequest()->getPost('selectcity');
            $data['primary_phone'] = $this->getRequest()->getPost('primary_phone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
            $data['grocery_name'] = $this->getRequest()->getPost('grocery_name');
            $data['open_time'] = $this->getRequest()->getPost('open_time');
            $data['closing_time'] = $this->getRequest()->getPost('closing_time');
            $data['notice'] = $this->getRequest()->getPost('notice');
            $data['address'] = $this->getRequest()->getPost('address');
            $data['minorder'] = $this->getRequest()->getPost('minorder');
            $data['deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
            $data['grocery_status'] = $this->getRequest()->getPost('grocery_status');
            $data['agent_id'] = $agentid;


       

            $grocerylocation = $this->getRequest()->getPost('selectlocation');

            if (!empty($grocerylocation)) {

                $data['grocery_location'] = $grocerylocation;
                $url = $this->_appSetting->apiLink . '/grocerydetails?method=addgrocerydetails';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                if ($curlResponse->code == 200) {
                    $coverphoto = $_FILES["fileToUpload"]["name"];
                    $grocery_id = $curlResponse->data['grocery_id'];
                    $dirpath = getcwd() . "/themes/agent/skin/groceryimages/$agentid/$grocery_id/";
                    if (!file_exists($dirpath)) {
                        mkdir($dirpath, 0777, true);
                    }
                    if (!empty($coverphoto)) {
                        $imagepath = $dirpath . $coverphoto;
                        $savepath = "/themes/agent/skin/groceryimages/$agentid/$grocery_id/$coverphoto";
                        $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                        $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                        if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                            echo json_encode("Something went wrong image upload");
                        } else {
                            $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                            if ($imagemoveResult) {
                                $link = $this->_appSetting->hostLink;
                                $da['Grocery_image'] = $link . $savepath;
                                $da['grocery_id'] = $grocery_id;
                                $url = $this->_appSetting->apiLink . '/grocerydetails?method=updategrocerydetails';
                                $curlResponse = $objCurlHandler->curlUsingPost($url, $da);
                            }
                        }
                    } else {
                        $this->view->errormessage = 'Grocery cover images in not updated ';
                    }
                } else {

                    $this->view->errormessage = 'Grocery details are not inserted properly';
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
                        $data['grocery_location'] = $curlResponse->data;
                        $url = $this->_appSetting->apiLink . '/grocerydetails?method=addgrocerydetails';
                        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                        if ($curlResponse->code == 200) {
                            $coverphoto = $_FILES["fileToUpload"]["name"];
                            $grocery_id = $curlResponse->data['grocery_id'];
                            $dirpath = getcwd() . "/themes/agent/skin/groceryimages/$agentid/$grocery_id/";
                            if (!file_exists($dirpath)) {
                                mkdir($dirpath, 0777, true);
                            }
                            if (!empty($coverphoto)) {
                                $imagepath = $dirpath . $coverphoto;
                                $savepath = "/themes/agent/skin/groceryimages/$agentid/$grocery_id/$coverphoto";
                                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                                    echo json_encode("Something went wrong image upload");
                                } else {
                                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                                    if ($imagemoveResult) {
                                        $link = $this->_appSetting->hostLink;
                                        $dat['Grocery_image'] = $link . $savepath;
                                        $dat['grocery_id'] = $grocery_id;
                                        $url = $this->_appSetting->apiLink . '/grocerydetails?method=updategrocerydetails';
                                        $curlResponse = $objCurlHandler->curlUsingPost($url, $dat);
                                    }
                                }
                            } else {

                                $this->view->errormessage = 'Grocery cover images in not updated ';
                            }
                          
                        } else {
                            $this->view->errormessage = 'Grocery details are not inserted properly';
                        }
                    } else {
                        $this->view->errormessage = 'Grocery location is not inserted properly, please try again';
                    }
                } else {
                    $this->view->errormessage = 'Grocery location is not inserted properly, please try again';
                }
            }
        }
    }

    /*
     * Dev: sowmya
     * Date : 11/4/2016
     * Desc: To view  grocery details of agent 
     * 
     */

    public function viewGroceryDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $grocery_id = $this->getRequest()->getParam('groceryid');
       
        $url = $this->_appSetting->apiLink . '/grocerydetails?method=getGroceryDetailsByGroceryId';
        $data['grocery_id'] = $grocery_id;
        $curlResponse1 = $objCurlHandler->curlUsingPost($url, $data);
        if ($curlResponse1->code == 200) {
            $this->view->grocerydetails = $curlResponse1->data;
        }

        $url = $this->_appSetting->apiLink . '/get-locations?method=getGroceryLocation';
        $data['grocery_id'] = $grocery_id;
        $curlResponse2 = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse2->code == 200) {

            $this->view->grocerylocation = $curlResponse2->data;
        }
    }

}
