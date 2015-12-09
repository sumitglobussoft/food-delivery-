<?php
/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Agent_AuthenticationController extends Zend_Controller_Action {

    public function init() {
             
               
    }
 
    public function indexAction() {
        if (isset($this->view->session->storage->role)):
            if ($this->view->session->storage->role == '2'):
                $this->_redirect('admin/dashboard');
            endif;
        endif;

        $objSecurity = Engine_Vault_Security::getInstance();

        if ($this->_request->isPost()):
            $username = $this->getRequest()->getPost('username');
            $password = ($this->getRequest()->getPost('password'));
            if (isset($username) && isset($password)):
                $authStatus = $objSecurity->authenticate($username, md5($password));
//            echo"<pre>";print_r($authStatus);die;
                if ($authStatus->code == 200):
                    if ($this->view->session->storage->role == '2'):
                        $this->_redirect('admin/dashboard');
                    endif;
                elseif ($authStatus->code == 198):
                    $this->view->errormgs = "Invalid credentials";
                endif;
            endif;
        endif;
    }

    public function dashboardAction() {
//            die('test');
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
