<?php

require_once 'Zend/Controller/Action.php';

class Admin_GroceryDetailsController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * DEV: sowmya
     * Date : 7/4/2016
     * Desc :edit agent Details
     * 
     */

    public function editGroceryDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $groceryDetailsModel = Admin_Model_GroceryDetails::getInstance();
        $agentid = $this->view->session->storage->user_id;
        $grocery_id = $this->getRequest()->getParam('groceryId');
        $dt['grocery_id'] = $grocery_id;
        if ($this->getRequest()->isPost()) {
            $data['grocery_id'] = $grocery_id;
            $data['grocery_contact_number'] = $this->getRequest()->getPost('primary_phone');
            $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
            $data['Grocery_name'] = $this->getRequest()->getPost('grocery_name');
            $data['Open_time'] = $this->getRequest()->getPost('open_time');
            $data['Closing_time'] = $this->getRequest()->getPost('closing_time');
            $data['Notice'] = $this->getRequest()->getPost('notice');
            $data['grocery_status'] = $this->getRequest()->getPost('grocery_status');
            $data['Address'] = $this->getRequest()->getPost('address');
            $data['Deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
            $data['Minorder'] = $this->getRequest()->getPost('minorder');
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
                        $result1 = $groceryDetailsModel->updateGroceryDetails($grocery_id, $data);

                        if ($result1) {
                            $this->redirect('/admin/grocery-details');
                        }
                    } else {
                        $this->view->errormessage = 'grocery details not updated properly';
                    }
                }
            } else {
                $result1 = $groceryDetailsModel->updateGroceryDetails($grocery_id, $data);
                if ($result1) {
                    $this->redirect('/admin/grocery-details');
                }
            }
        }
        $result = $groceryDetailsModel->getGroceryDetailsByID($grocery_id);

        if ($result) {
            $this->view->allgrocerydetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV: sowmya
     * Date : 8/4/2016
     * Desc :add grocery details
     * 
     */

    public function addGroceryDetailsAction() {

//       $groceryDetailsModel = Admin_Model_GroceryDetails::getInstance();
//
//
//        $locationsModel = Admin_Model_Location::getInstance();
//
//        $countrys = $locationsModel->getCountrys();
//        if ($countrys) {
//
//            $this->view->countriesdetails = $countrys;
//        }   
// 
//        if ($this->getRequest()->isPost()) {
//            $data['select_country'] = $this->getRequest()->getPost('selectcountry');
//            $data['select_state'] = $this->getRequest()->getPost('selectstate');
//            $data['select_city'] = $this->getRequest()->getPost('selectcity');
//            $data['primary_phone'] = $this->getRequest()->getPost('primary_phone');
//            $data['secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
//            $data['grocery_name'] = $this->getRequest()->getPost('grocery_name');
//            $data['open_time'] = $this->getRequest()->getPost('open_time');
//            $data['closing_time'] = $this->getRequest()->getPost('closing_time');
//            $data['notice'] = $this->getRequest()->getPost('notice');
//            $data['grocery_status'] = $this->getRequest()->getPost('grocery_status');
//            $data['address'] = $this->getRequest()->getPost('address');
//            $data['deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
//            $data['minorder'] = $this->getRequest()->getPost('minorder');
//            if ($data) {
//
//              
//                }
//            }
//        
    }

    /*
     * DEV:sowmya
     * Date : 20/4/2016
     * Desc :grocery details
     * 
     */

    public function groceryDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $groceryDetailsModel = Admin_Model_GroceryDetails::getInstance();
        $result = $groceryDetailsModel->selectAllGrocery();

        if ($result) {
            $this->view->grocerydetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV :sowmya
     * Desc :groceryDetails handler action 
     * Date : 20/4/2016
     */

    public function groceryDetailsAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $groceryDetailsModel = Admin_Model_GroceryDetails::getInstance();

        if ($this->getRequest()->isPost()) {
            $method = $this->getRequest()->getParam('method');

            switch ($method) {
                case 'groceryactive':
                    $state = $this->getRequest()->getParam('groceryid');
                    $ok = $groceryDetailsModel->getstatustodeactivate($state);

                    if ($ok) {
                        echo $state;
                    } else {
                        echo "Error";
                    }
                    break;
                case 'grocerydelete':
                    $id = $this->getRequest()->getParam('groceryid');
                    $result = $groceryDetailsModel->grocerydelete($id);
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
     * Desc :view grocery Details
     * 
     */

    public function viewGroceryDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $groceryDetailsModel = Admin_Model_GroceryDetails::getInstance();
        $grocery_id = $this->getRequest()->getParam('groceryId');
        $dt['grocery_id'] = $grocery_id;
        $result = $groceryDetailsModel->getGroceryDetailsByID($grocery_id);
        if ($result) {
            $this->view->allgrocerydetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

}
