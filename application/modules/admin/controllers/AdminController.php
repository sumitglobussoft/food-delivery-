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

    public function indexAction() {
        /*
         * temporary usage for user not to redirect to admin panel dashboard
         */

        if ($this->view->auth->hasIdentity()) {

            $this->view->auth->clearIdentity();

            Zend_Session::destroy(true);

            $this->_redirect('/admin');
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
        $userModel = Admin_Model_Users::getInstance();
        $result = $userModel->getUserdetails();
        if ($result) {
            $this->view->userdetails = count($result);
        }

        $usertransactionModel = Admin_Model_UserTransactions::getInstance();
        $result1 = $usertransactionModel->getAllUsertransaction();
        if ($result1) {
            $this->view->usertransaction = $result1;
        }

        $ordersModel = Admin_Model_Orders::getInstance();
        $result2 = $ordersModel->getAllOrders();
        if ($result2) {
            $this->view->orderdetails =count($result2);
        }

        $productsModel = Admin_Model_Products::getInstance();
        $result3 = $productsModel->getProductsdetails();
        if ($result) {
            $this->view->productsdetails = count($result3);
        }
        $agentsModel = Admin_Model_Agents::getInstance();
        $result4 = $agentsModel->getAgentsDetails();
        if ($result4) {
            $this->view->agentsdetails = count($result4);
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
