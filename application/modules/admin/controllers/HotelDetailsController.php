<?php

require_once 'Zend/Controller/Action.php';

class Admin_HotelDetailsController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * DEV: sowmya
     * Date : 7/4/2016
     * Desc :edit agent Details
     * 
     */

    public function editHotelDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $hotelDetailsModel = Admin_Model_HotelDetails::getInstance();

        $hotelCuisinesModel = Admin_Model_HotelCuisines::getInstance();
        $agentid = $this->view->session->storage->user_id;
        $hotel_id = $this->getRequest()->getParam('id');
        $dt['hotel_id'] = $hotel_id;
        $cuisinesdDetails = $hotelCuisinesModel->getCuisinesByHotelId($hotel_id);
        $i = 0;
        if ($cuisinesdDetails) {
            foreach ($cuisinesdDetails as $value) {
                $array[$i] = $value['Cuisine_name'];
            } $i++;
            $this->view->cuisinesdDetails = $cuisinesdDetails;
        }
        if ($this->getRequest()->isPost()) {

            $data['id'] = $hotel_id;
            $data['hotel_contact_number'] = $this->getRequest()->getPost('primary_phone');
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
//                        $link = "http://" . $_SERVER["HTTP_HOST"];
                        $link = $this->_appSetting->hostLink;
                        $data['hotel_image'] = $link . $savepath;
//                          print_r($data);die("fbh");
                        $result1 = $hotelDetailsModel->updateHotelDetails($hotel_id, $data);

                        if ($result1) {
                            $this->redirect('/admin/hotel-details');
                        }
                    } else {
                        $this->view->errormessage = 'hotel details not updated properly';
                    }
                }
            } else {
                $result1 = $hotelDetailsModel->updateHotelDetails($hotel_id, $data);
                if ($result1) {
                    $this->redirect('/admin/hotel-details');
                }
            }
        }
        $result = $hotelDetailsModel->getHotelDetailsByID($hotel_id);

        if ($result) {
            $this->view->allhoteldetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV: sowmya
     * Date : 8/4/2016
     * Desc :add hotel details
     * 
     */

    public function addHotelDetailsAction() {

//       $hotelDetailsModel = Admin_Model_HotelDetails::getInstance();
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
//            $data['hotel_name'] = $this->getRequest()->getPost('hotel_name');
//            $data['open_time'] = $this->getRequest()->getPost('open_time');
//            $data['closing_time'] = $this->getRequest()->getPost('closing_time');
//            $data['notice'] = $this->getRequest()->getPost('notice');
//            $data['hotel_status'] = $this->getRequest()->getPost('hotel_status');
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
     * Date : 6/4/2016
     * Desc :hotel details
     * 
     */

    public function hotelDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $hotelDetailsModel = Admin_Model_HotelDetails::getInstance();
        $result = $hotelDetailsModel->selectAllHotels();

        if ($result) {
            $this->view->hoteldetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV :sowmya
     * Desc :hotelDetails handler action 
     * Date : 6/4/2016
     */

    public function hotelDetailsAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $hotelDetailsModel = Admin_Model_HotelDetails::getInstance();
        $hotelCuisinesModel = Admin_Model_HotelCuisines::getInstance();
        $orderModal = Admin_Model_Orders::getInstance();
        $addtocartModel = Admin_Model_Addtocart::getInstance();
        $productsModel = Admin_Model_Products::getInstance();
        if ($this->getRequest()->isPost()) {
            $method = $this->getRequest()->getParam('method');

            switch ($method) {
                case 'hotelactive':
                    $state = $this->getRequest()->getParam('id');
                    $ok = $hotelDetailsModel->getstatustodeactivate($state);

                    if ($ok) {
                        echo $state;
                    } else {
                        echo "Error";
                    }
                    break;
                case 'hoteldelete':
                    $id = $this->getRequest()->getParam('id');
                    $result = $hotelDetailsModel->hoteldelete($id);
                    if ($result) {
                        $result1 = $addtocartModel->addToCartDeleteByHotelId($id);
                        $result2 = $hotelCuisinesModel->deleteCuisinesByHotelId($id);
                        $result3 = $orderModal->deleteOrdersByHotelId($id);
                        $result4 = $productsModel->deleteProductsByHotelId($id);
                        echo $result;
                        '<br>';
                        echo $result1;
                        '<br>';
                        echo $result2;
                        '<br>';
                        echo $result3;
                        '<br>';
                        echo $result4;
                    } else {
                        echo "error";
                    }
                    break;
            }
        }
    }

    /*
     * DEV: sowmya
     * Date : 9/4/2016
     * Desc :view agent Details
     * 
     */

    public function viewHotelDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $hotelDetailsModel = Admin_Model_HotelDetails::getInstance();
        $hotelCuisinesModel = Admin_Model_HotelCuisines::getInstance();
        $hotel_id = $this->getRequest()->getParam('id');
        $dt['hotel_id'] = $hotel_id;
        $cuisinesdDetails = $hotelCuisinesModel->getCuisinesByHotelId($hotel_id);
        $i = 0;
        if ($cuisinesdDetails) {
            foreach ($cuisinesdDetails as $value) {
                $array[$i] = $value['Cuisine_name'];
            } $i++;
            $this->view->cuisinesdDetails = $cuisinesdDetails;
        }
        $result = $hotelDetailsModel->getHotelDetailsByID($hotel_id);
        if ($result) {
            $this->view->allhoteldetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

}
