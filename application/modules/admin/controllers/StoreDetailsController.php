<?php

require_once 'Zend/Controller/Action.php';

class Admin_StoreDetailsController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * DEV: sowmya
     * Date : 7/4/2016
     * Desc :edit agent Details
     * 
     */

    public function editStoreDetailsAction() {
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $adminModel = Admin_Model_Users::getInstance();
        $locationsModel = Admin_Model_Location::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $storeDetailsModel = Admin_Model_StoreDetails::getInstance();
        $agentid = $this->view->session->storage->user_id;
        $store_id = $this->getRequest()->getParam('storeId');
        $dt['store_id'] = $store_id;
        if ($this->getRequest()->isPost()) {
            $data['store_id'] = $store_id;
            $data['store_contact_number'] = $this->getRequest()->getPost('primary_phone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
            $data['Store_name'] = $this->getRequest()->getPost('store_name');
            $data['Open_time'] = $this->getRequest()->getPost('open_time');
            $data['Closing_time'] = $this->getRequest()->getPost('closing_time');
            $data['Notice'] = $this->getRequest()->getPost('notice');
            $data['store_status'] = $this->getRequest()->getPost('store_status');
            $data['store_address'] = $this->getRequest()->getPost('address');
            $data['Deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
            $data['store_location'] = $this->getRequest()->getPost('selectlocation');
            $data['category_id'] = json_encode($this->getRequest()->getPost('category_id'));
//            $data['Minorder'] = $this->getRequest()->getPost('minorder');
            $storelocation = $this->getRequest()->getPost('selectlocation');
            //to add new location while editing hotel details
            if (empty($storelocation)) {
                $data1['select_city'] = $this->getRequest()->getPost('selectcity');
                $location['name'] = $this->getRequest()->getPost('location_name');
                if ($data1['select_city']) {
                    $location['parent_id'] = $data1['select_city'];
                    $location['location_status'] = 1;
                    $location['location_type'] = 3;
                    $countryid = $this->getRequest()->getPost('selectcountry');
                    $stateid = $this->getRequest()->getPost('selectstate');
                    if ($countryid && $stateid && $location['parent_id']) {
                        $storelocation = $locationsModel->addLocationByParentIds($location, $stateid, $countryid);
//                            print_r($location_id);die;
                        if ($storelocation) {
                            $this->view->errormessage = 'Successfull';
                        } else {
                            $this->view->errormessage = 'Could not Serve the Response1';
                        }
                    } else {
                        $this->view->errormessage = 'Parametre missing';
                    }
                } else {
                    $this->view->errormessage = 'Could not Serve the Response';
                }
            }

            if (!empty($storelocation)) {

                $data['store_location'] = $storelocation;

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
                        print_r("Something went wrong image upload");
                        die;
                    } else {
                        $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));

                        if ($imagemoveResult) {
                            $link = $this->_appSetting->hostLink;
                            $data['store_image'] = $link . $savepath;
                            $result1 = $storeDetailsModel->updateStoreDetails($store_id, $data);

                            if ($result1) {
                                $this->redirect('/admin/store-details');
                            }
                        } else {
                            $this->view->errormessage = 'store details not updated properly';
                            print_r("Something went wrong image upload");
                            die;
                        }
                    }
                } else {
                    $result1 = $storeDetailsModel->updateStoreDetails($store_id, $data);
                    if ($result1) {
                        $this->redirect('/admin/store-details');
                    }
                }
            }
        }
        $result = $storeDetailsModel->getStoreDetailsByID($store_id);
        $storecategoryModel = Admin_Model_StoreCategory::getInstance();

        $store_id = $this->getRequest()->getParam('storeId');
        $dt['store_id'] = $store_id;
        $result = $storeDetailsModel->getStoreDetailsByID($store_id);
        $categoryID = json_decode($result['category_id'], true);
        $i = 0;
        foreach ($categoryID as $categoryid) {
            $cat_id[$i] = $categoryid;
            $categoryname = $storecategoryModel->getCategoryById($categoryid);
            $categorynames[$i] = $categoryname['cat_name'];

            $i++;
        }

        $countrys = $locationsModel->getCountrys();
        if ($result) {
            $this->view->allstoredetails = $result;
            $this->view->countrylist = $countrys;
            $this->view->allStoreCategorynames = $categorynames;
            $this->view->categoryid = $cat_id;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV: sowmya
     * Date : 8/4/2016
     * Desc :add store details
     * 
     */

    public function addStoreDetailsAction() {
        
    }

    /*
     * DEV:sowmya
     * Date : 20/4/2016
     * Desc :store details
     * 
     */

    public function storeDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $storeDetailsModel = Admin_Model_StoreDetails::getInstance();
        $result = $storeDetailsModel->selectAllStore();
        if ($result) {
            $this->view->storedetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV :sowmya
     * Desc :storeDetails handler action 
     * Date : 20/4/2016
     */

    public function storeDetailsAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $storeDetailsModel = Admin_Model_StoreDetails::getInstance();

        if ($this->getRequest()->isPost()) {
            $method = $this->getRequest()->getParam('method');

            switch ($method) {
                case 'storeactive':
                    $state = $this->getRequest()->getParam('storeid');
                    $ok = $storeDetailsModel->getstatustodeactivate($state);

                    if ($ok) {
                        echo $state;
                    } else {
                        echo "Error";
                    }
                    break;
                case 'storedelete':
                    $id = $this->getRequest()->getParam('storeid');
                    $result = $storeDetailsModel->storedelete($id);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
            }
        }
    }

    /*
     * DEV: sowmya
     * Date :20/4/2016
     * Desc :view store Details
     * 
     */

    public function viewStoreDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $storeDetailsModel = Admin_Model_StoreDetails::getInstance();
        $storecategoryModel = Admin_Model_StoreCategory::getInstance();

        $store_id = $this->getRequest()->getParam('storeId');
        $dt['store_id'] = $store_id;
        $result = $storeDetailsModel->getStoreDetailsByID($store_id);
        $categoryID = json_decode($result['category_id'], true);
        $i = 0;
        foreach ($categoryID as $categoryname) {
            $categoryname = $storecategoryModel->getCategoryById($categoryname);
            $categorynames[$i] = $categoryname['cat_name'];
            $i++;
        }

        if ($result) {
            $this->view->allstoredetails = $result;
            $this->view->allStoreCategorynames = $categorynames;
        } else {
            echo 'controller error occured';
        }
    }

}
