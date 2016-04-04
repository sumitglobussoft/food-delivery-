<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Web_AuthenticationController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * Dev : Priyanka Varanasi
     * Desc:  Ziingo signup Action
     * Date : 11/1/2016
     * 
     */
    /*
     * Dev : Sibani Mishra
     * Desc: Modified  signup Action
     * Date : 15/3/2016
     * 
     */

    public function signupAction() {
        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        if ($this->view->auth->hasIdentity()) {
            $this->_redirect('/');
        }
        if ($this->getRequest()->isPost()) {

            $username = $this->getRequest()->getPost('name');
            $email = $this->getRequest()->getPost('email');
            $password = $this->getRequest()->getPost('password');
            $confirmpassword = $this->getRequest()->getPost('ConfirmPassword');
            $agreeterms = $this->getRequest()->getPost('agreeterms');

            if ($agreeterms == 'on') {

                if (isset($username) && isset($email) && isset($password) && isset($confirmpassword)) {

                    $data = array(
                        'name' => $username,
                        'password' => sha1(md5($password)),
                        'email' => $email,
                        'reg_date' => date('Y-m-d H-i-s'),
                        'role' => 1,
                    );

//                    $agentdata['userdata'] = json_encode($data);

                    $url = $this->_appSetting->apiLink . '/web-authentication?method=usersignup';

                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        $this->view->success = "Registration Successful,Please Check your email to Activate your Account";

                        $authStatus = $objSecurity->authenticate($email, sha1(md5($password)));

                        if ($authStatus) {
                            $this->_redirect('/');
                        } else {
                            $this->view->success = $curlResponse->message;
                        }


//////////////////SEND EMAIL /////////////////////////////
//                        $authStatus = $objSecurity->authenticate($email, sha1(md5($password)));
//                    }
//                    if ($authStatus) {
//                        $this->_redirect('/');
//                        if ($authStatus->code === 200) {
//                            if (isset($_COOKIE['user_cartitems_cookie'])) {
//                                $cartitems = $_COOKIE['user_cartitems_cookie'];
//                                $cartitems = stripslashes($cartitems);
//                                $tempcookie = (array) json_decode($cartitems, TRUE);
//                                $url = $this->_appSetting->apiLink . '/addto-cart?method=BulkInsertOrdersToCart';
//                                if ($tempcookie) {
//                                    $i = 0;
//                                    foreach ($tempcookie as $value) {
//                                        $tempcookie[$i]['user_id'] = $curlResponse->data;
//                                        $i++;
//                                    }
//                                    $cart['cart_items'] = json_encode($tempcookie, true);
//
//                                    $cResponse = $objCurlHandler->curlUsingPost($url, $cart);
//                                    if ($cResponse->code == 200) {
//                                        $this->_redirect('/cart');
//                                    } else {
//                                        $this->_redirect('/');
//                                    }
//                                } else {
//                                    $this->_redirect('/');
//                                }
//                            } else {
//                                $this->_redirect('/');
//                            }
//                        } else {
//
//                            $this->_redirect('/');
//                        }
                    }
                }
            }
        }
    }

    /*
     * Dev : Sibani Mishra
     * Desc: Activation Email
     * Date : 15/3/2016
     * 
     */

    public function activateAccountAction() {

        $token = $this->getRequest()->getParam('token');

        if ($token) {
            $data = array('ActivationToken' => $token);

            $mailer = Engine_Mailer_Mailer::getInstance();
            $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
            $response = new stdClass();
            $objCore = Engine_Core_Core::getInstance();

            $this->_appSetting = $objCore->getAppSetting();
            $url = $this->_appSetting->apiLink . '/web-authentication?method=userSignupActivationLink';

            $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
            if ($curlResponse->code == 200) {
                $this->view->successMsg = "Account Activation Successful...!!!";
            } else if ($curlResponse->code == 100) {
                $this->view->errorMsg = $curlResponse->message;
            } else {
                $this->_redirect('/'); //REDIRECT THIS TO 404 PAGE
            }
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Desc: Ziingo login Action
     * Date : 11/1/2016
     * 
     */

    /*
     * Dev : Sibani Mishra
     * Desc: Modified   login Action for Facebook And Twitter
     * Date : 4/3/2016
     * 
     */

    public function ziingoLoginAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $mailer = Engine_Mailer_Mailer::getInstance();

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $facebookClass = Engine_Facebook_Facebookclass::getInstance();
        $fbloginUrl = $facebookClass->getLoginUrl();
        $this->_appSetting = $objCore->getAppSetting();
        $method = $this->getRequest()->getPost('methodtype');

        if ($method == 'ziingologin') {

            $loginData = $this->getRequest()->getPost('loginname');
            $password = $this->getRequest()->getPost('password');

            if (isset($loginData) && isset($password)) {
                $data['logindata'] = $loginData;
                $data['password'] = $password;

                $url = $this->_appSetting->apiLink . '/web-authentication?method=userlogin';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                if ($curlResponse->code == 200) {
                    $authStatus = $objSecurity->authenticate($loginData, sha1(md5($password)));

                    if ($authStatus) {
                        $array = array('code' => 200,
                            'messsage' => 'Success');
                        echo json_encode($array);
                    }
                } else {
                    $array = array('code' => 198,
                        'messsage' => 'Failed Authentication');
                    echo json_encode($array);
                }
            }
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Desc: ajax handler functions will be carried 
     * Date : 15/1/2016
     * 
     */

    public function ajaxHandlerAuthAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $mailer = Engine_Mailer_Mailer::getInstance();

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();

        $this->_appSetting = $objCore->getAppSetting();
        $method = $this->getRequest()->getParam('ajaxMethod');
        if ($method) {
            switch ($method) {
                case'validateUsername':
                    $data['uname'] = $this->getRequest()->getParam('name');

                    $url = $this->_appSetting->apiLink . '/web-authentication?method=validateusername';

                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse->code === 200) {
                        echo json_encode(true);
                    } else {
                        $arr = array("Username already exists");
                        echo json_encode($arr);
                    }
                    die();
                    break;
                case'validateEmail':
                    $data['email'] = $this->getRequest()->getParam('email');
                    $url = $this->_appSetting->apiLink . '/web-authentication?method=validateemail';
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code === 200) {
                        echo json_encode(true);
                    } else {
                        $arr = array("Email already exists");
                        echo json_encode($arr, true);
                    }
                    die();
                    break;
            }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = 'No Method';

            echo json_encode($response, true);
            die();
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Desc: session destroy logout action
     * Date : 10/12/2015
     * 
     */

    public function logoutAction() {
        $this->_helper->layout->disableLayout();
        if ($this->view->auth->hasIdentity()) {

            $this->view->auth->clearIdentity();

            Zend_Session::destroy(true);

            $this->_redirect('/');
        }
    }

    /*
     * Dev : Sibani Mishra
     * Desc: Forgot password
     * Date : 10/3/2016
     * 
     */

    public function authenticationAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $mailer = Engine_Mailer_MandrillApp_Mailer::getInstance();
//        $current = time();

        $objCore = Engine_Core_Core::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();

        $method = $this->getRequest()->getPost('method');

        if ($method) {

            switch ($method) {

                case "forgotpw":

                    $fpwemail = $this->getRequest()->getPost('EmailID');

                    $data['EmailId'] = $fpwemail;

                    $data['method'] = "EnterEmailId";

                    $url = $this->_appSetting->apiLink . '/forgot-password?method=EnterEmailId';

                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                    if ($curlResponse->code == 200) {
                        echo json_encode($curlResponse);
                    } else {
                        echo json_encode($curlResponse->message);
                    }

                    break;

                case "verifyResetCode":

                    if ($this->getRequest()->getPost()) {

                        $fpwemail = $this->getRequest()->getPost('EmailID');
                        $resetcode = $this->getRequest()->getPost('resetcode');

                        $data['EmailId'] = $fpwemail;
                        $data['resetcode'] = $resetcode;
                        $data['method'] = "verifyResetCode";
                        $url = $this->_appSetting->apiLink . '/forgot-password?method=verifyResetCode';

                        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                        if ($curlResponse->code == 200) {
                            echo json_encode($curlResponse);
                        } else {
                            echo json_encode($curlResponse->message);
                        }
                    }
                    break;

                case "resetPassword":

                    if ($this->getRequest()->getPost()) {
                        $fpwemail = $this->getRequest()->getPost('EmailID');
                        $resetcode = $this->getRequest()->getPost('resetcode');
                        $password = $this->getRequest()->getPost('Password');
                        $re_password = $this->getRequest()->getPost('rePassword');

                        $data['EmailId'] = $fpwemail;
                        $data['resetcode'] = $resetcode;
                        $data['Password'] = $password;
                        $data['rePassword'] = $re_password;
                        $data['method'] = "resetPassword";
                        
                        $url = $this->_appSetting->apiLink . '/forgot-password?method=resetPassword';

                        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
  
                        if ($curlResponse->code == 200) {
                            echo json_encode($curlResponse);
                        } else {
                            echo json_encode($curlResponse->message);
                        }
                    }
                    break;
                default :
                    break;
            }
        }
    }

   
}

?>
