<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_ReviewsController extends Zend_Controller_Action {

    public function init() {
        
    }

//added by sowmya 20 april 2016
    public function hotelReviewsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $ReviewsModel = Admin_Model_Reviews::getInstance();
        $result = $ReviewsModel->getAllHotelReviews();

        if ($result) {
            $this->view->hotelReviews = $result;
        } else {
            echo 'controller error occured';
        }
    }

//added by sowmya 20 april 2016
    public function groceryReviewsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $ReviewsModel = Admin_Model_Reviews::getInstance();
        $result = $ReviewsModel->getAllGroceryReviews();
        if ($result) {
            $this->view->groceryReviews = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV :sowmya
     * Desc :reviews handler action 
     * Date : 20/4/2016
     */

    public function reviewsAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $ReviewsModel = Admin_Model_Reviews::getInstance();
        if ($this->getRequest()->isPost()) {
            $method = $this->getRequest()->getParam('method');

            switch ($method) {
                case 'reviewactive':
                    $state = $this->getRequest()->getParam('reviewid');
                    $ok = $ReviewsModel->getstatustodeactivate($state);

                    if ($ok) {
                        echo $state;
                    } else {
                        echo "Error";
                    }
                    break;
                case 'reviewdelete':
                    $id = $this->getRequest()->getParam('reviewid');
                    $result = $ReviewsModel->deleteReviews($id);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
            }
        }
    }

}
