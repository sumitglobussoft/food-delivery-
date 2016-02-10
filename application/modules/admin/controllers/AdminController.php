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

        if ($this->_request->isPost()){
            $username = $this->getRequest()->getPost('username');
            $password = sha1(md5($this->getRequest()->getPost('password')));

            if (isset($username) && isset($password)):

                $authStatus = $objSecurity->authenticate($username,$password);

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

        public function dashboardAction() {
         $userModel = Admin_Model_Users::getInstance();
//        $result = $userModel->getUserdetailsDash();
//        if ($result) {
//            $this->view->userdetails = $result;
//        } else {
//            
//        }

        $usertransactionModel = Admin_Model_UserTransactions::getInstance();
        $result = $usertransactionModel->getAllUsertransaction();
        if ($result) {
            $this->view->usertransaction = $result;
        } else {
            
        }

        $ordersModel = Admin_Model_Orders::getInstance();
        $result = $ordersModel->getAllOrders();
        if ($result) {
            $this->view->orderdetails = $result;
        } else {
            
        }

//         $productsModel = Admin_Model_Products::getInstance();
//        $result = $productsModel->getAllproducts();
//        if ($result) {
//            $this->view->productsdetails = $result;
//        } else {
//            
//        }
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
