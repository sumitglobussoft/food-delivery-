<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_PaymentController extends Zend_Controller_Action {

    public function init() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
    }

}
