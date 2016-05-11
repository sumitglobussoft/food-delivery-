<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_AdminController extends Zend_Controller_Action {

    public function init() {
        
    }

//added by sowmya 8/4/2016
    public function indexAction() {
        /*
         * temporary usage for user not to redirect to admin panel dashboard
         */
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        if ($this->view->auth->hasIdentity()) {
            $this->view->auth->clearIdentity();

            Zend_Session::destroy(true);

            $this->_redirect('/admin/dashboard');
        }
        /////////////////code ends ////////////////

        $objSecurity = Engine_Vault_Security::getInstance();

        if ($this->_request->isPost()) {
            $username = $this->getRequest()->getPost('username');
            $password = sha1(md5($this->getRequest()->getPost('password')));

            if (isset($username) && isset($password)):

                $authStatus = $objSecurity->authenticate($username, $password);

                if ($authStatus->code == 200):
                    if ($this->view->session->storage->role == '2'):
                        $this->_redirect('admin/dashboard');
                    endif;
                elseif ($authStatus->code == 198):
                    $this->view->error = "Invalid credentials";
                endif;
            endif;
        }
    }

    /*
     * developer: sowmya 
     * date : 28/3/2016
     * details :function to get all count on dashboard */

    public function dashboardAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $userModel = Admin_Model_Users::getInstance();
        $result = $userModel->getUserdetails();
        if ($result) {
            $this->view->userdetails = count($result);
        }

        $usertransactionModel = Admin_Model_UserTransactions::getInstance();
        $result1 = $usertransactionModel->getAllUsertransaction();
        if ($result1) {
            $this->view->usertransaction = count($result1);
        }

        $ordersModel = Admin_Model_Orders::getInstance();
        $result2 = $ordersModel->getAllHotelOrder();
        if ($result2) {
            $this->view->orderdetails = count($result2);
        }
        $ordersModel1 = Admin_Model_Orders::getInstance();
        $result21 = $ordersModel->getAllStoreOrder();
        if ($result21) {
            $this->view->storeorderdetails = count($result21);
        }
        $productsModel = Admin_Model_Products::getInstance();
        $result3 = $productsModel->getProductsdetails();
        if ($result3) {
            $this->view->productsdetails = count($result3);
        }
        $productsModel1 = Admin_Model_Products::getInstance();
        $result31 = $productsModel1->getAllStoreProductdetails();
        if ($result31) {
            $this->view->productsdetails = count($result31);
        }
        $agentsModel = Admin_Model_Agents::getInstance();
        $result4 = $agentsModel->getAgentsDetails();
        if ($result4) {
            $this->view->agentsdetails = count($result4);
        }
        $storeDetailsModel = Admin_Model_StoreDetails::getInstance();
        $result5 = $storeDetailsModel->getAllStore();
        if ($result5) {
            $this->view->storedetails = count($result5);
        }
        $hotelDetailsModel = Admin_Model_HotelDetails::getInstance();
        $result6 = $hotelDetailsModel->getAllHotels();
        if ($result6) {
            $this->view->hoteldetails = count($result6);
        }
        $agenttransactionModel = Admin_Model_AgentTransactions::getInstance();
        $result7 = $agenttransactionModel->getAllAgenttransaction();
        if ($result7) {
            $this->view->agenttransaction = count($result7);
        }

        $producttransactionModel = Admin_Model_ProductTransactions::getInstance();
        $result8 = $producttransactionModel->getAllProducttransaction();
        if ($result8) {
            $this->view->producttransaction = count($result8);
        }
        $storeCategoryDetailsModel = Admin_Model_StoreCategory::getInstance();
        $result9 = $storeCategoryDetailsModel->selectAllCategorys();
        if ($result9) {
            $this->view->storecategorydetails = count($result9);
        }
        $DeliveryGuysModel = Admin_Model_DeliveryGuys::getInstance();
        $result10 = $DeliveryGuysModel->getAllDeliveryGuys();
        if ($result10) {
            $this->view->DeliveryGuys = count($result10);
        }
        $NotificationModel = Admin_Model_Notification::getInstance();
        $result11 = $NotificationModel->getNotificationDetail();
        if ($result11) {
            $this->view->Notification = count($result11);
        }
        $ReviewsModel = Admin_Model_Reviews::getInstance();
        $result12 = $ReviewsModel->getAllHotelReviews();
        if ($result12) {
            $this->view->HotelReviews = count($result12);
        }
        $ReviewModel = Admin_Model_Reviews::getInstance();
        $result13 = $ReviewModel->getAllStoreReviews();
        if ($result13) {
            $this->view->StoreReviews = count($result13);
        }
        $locationsModel1 = Admin_Model_Location::getInstance();
        $result14 = $locationsModel1->getCountrys();
        if ($result14) {
            $this->view->CountryDetails = count($result14);
        }
        $locationsModel2 = Admin_Model_Location::getInstance();
        $result15 = $locationsModel2->getStates();
        if ($result15) {
            $this->view->StateDetails = count($result15);
        }
        $locationsModel3 = Admin_Model_Location::getInstance();
        $result16 = $locationsModel3->getCitys();
        if ($result16) {
            $this->view->CityDetails = count($result16);
        }
        $locationsModel4 = Admin_Model_Location::getInstance();
        $result17 = $locationsModel4->getLocations();
        if ($result17) {
            $this->view->LocationDetails = count($result17);
        }
        $cuisinesModel = Admin_Model_FamousCuisines::getInstance();
        $result18 = $cuisinesModel->getCuisines();
        if ($result18) {
            $this->view->CuisineDetails = count($result18);
        }
        $categoryModel = Admin_Model_MenuCategory::getInstance();
        $result19 = $categoryModel->selectAllCategorys();
        if ($result19) {
            $this->view->CategoryDetails = count($result19);
        }
        $objModelCoupons = Admin_Model_Coupons::getInstance();
        $allCoupons = $objModelCoupons->getCoupons();
        if ($allCoupons) {
            $this->view->allcoupons = count($allCoupons);
        }
        $objModelCouponUsers = Admin_Model_CouponUsers::getInstance();
        $couponsLog = $objModelCouponUsers->getCouponsLog();
        if ($couponsLog) {
            $this->view->couponsLog = count($couponsLog);
        }
    }

    public function logoutAction() {
        $this->_helper->layout->disableLayout();
        if ($this->view->auth->hasIdentity()) {

            $this->view->auth->clearIdentity();

            Zend_Session::destroy(true);

            $this->_redirect('/admin');
        }
    }

}
