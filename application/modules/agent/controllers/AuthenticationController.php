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

    /*
     * Dev: priyanka varanasi
     * date :11/12/2015
     * desc: agent login and signup
     * 
     */

    /*
     * Dev: sowmya
     * date :19/3/2016
     * desc: agent login and signup
     * 
     */

    public function indexAction() {

        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        /*
         * temporary usage for user not to redirect to agent panel
         */

        if ($this->view->auth->hasIdentity()) {
            $this->view->auth->clearIdentity();

            Zend_Session::destroy(true);
            $this->_redirect('/agent/dashboard');
        }
        /////////////////code ends ////////////////

        if ($this->getRequest()->isPost()) {
            $methodSelector = $this->getRequest()->getPost('agentform');

            if ($methodSelector == 'agentsignup') {

                $first_name = $this->getRequest()->getPost('first_name');
                $last_name = $this->getRequest()->getPost('last_name');
                $username = $this->getRequest()->getPost('name');
                $email = $this->getRequest()->getPost('email');
                $password = $this->getRequest()->getPost('password');
                $city = $this->getRequest()->getPost('city');



                if (isset($first_name) && isset($last_name) && isset($username) && isset($email) && isset($password) && isset($city)) {

                    $data = array('loginname' => $username,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'password' => md5($password),
                        'email' => $email,
                        'city' => $city,
                        'reg_date' => date('Y-m-d H-i-s'),
                        'role' => 4,
                        'agent_status' => 1, 'membership' => 1
                    );
                    $agentdata['agentdata'] = json_encode($data);

                    $url = $this->_appSetting->apiLink . '/agent-authentication?method=agentsignup';

                    $curlResponse = $objCurlHandler->curlUsingPost($url, $agentdata);

                    if ($curlResponse->code === 200) {
                        //////////////////SEND EMAIL /////////////////////////////

                        $authStatus = $objSecurity->agentAuthenticate($email, md5($password));
                    }
                    if ($authStatus->message == 'Authentication Successful') {
//                                die('fdg');
                        $this->_redirect('/agent/dashboard');
                    }
                }
            } else if ($methodSelector == 'agentlogin') {


                $loginData = $this->getRequest()->getPost('loginname');

                $password = $this->getRequest()->getPost('pwd');

                if (isset($loginData) && isset($password)) {
                    $data['logindata'] = $loginData;
                    $data['password'] = $password;

                    $url = $this->_appSetting->apiLink . '/agent-authentication?method=agentlogin';

                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $authStatus = $objSecurity->agentAuthenticate($loginData, md5($password));

                        if ($authStatus) {
                            $this->_redirect('/agent/dashboard');
                        }
                    } else {
                        $this->view->msg = "Please check your login credentials";
                    }
                }
            }
        }
    }

    /*
     * Dev: sowmya
     * date :9/4/2016
     * desc: show all counts in dashboard
     * 
     */

    public function dashboardAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;
    
        $url = $this->_appSetting->apiLink . '/hoteldetails?method=getHotelDetailsByAgentId';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
        $this->view->hoteldetails = count($curlResponse->data);
    }

    public function logoutAction() {
        $this->_helper->layout->disableLayout();

        if ($this->view->auth->hasIdentity()) {

            $this->view->auth->clearIdentity();

            Zend_Session::destroy(true);

            $this->_redirect('/agent');
        }
    }

}
