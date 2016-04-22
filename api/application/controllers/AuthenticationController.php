<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class AuthenticationController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
        
    }

    /*
     * Dev : Priyanka Varanasi
     * Date : 2/12/2015
     * Desc : To insert user details while registration and authentication
     * 
     * case 0 : normal signup ,
      case 1 : Facebook  signup
     * case 2 : twitter signup
     */
    /*
     * Dev : Sibani Mishra
     * Date : 3/15/2015
     * Desc : Signup Activation Token

     */

    public function userAuthenticationAction() {

        $users = Application_Model_Users::getInstance();
        $usermeta = Application_Model_Usermeta::getInstance();
        $mailer = Engine_Mailer_MandrillApp_Mailer::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $this->_appSetting = $objCore->getAppSetting();

        if ($method) {

            switch ($method) {

                case 'signup':

                    if ($this->getRequest()->isPost()) {

                        $type = $this->getRequest()->getPost('type');
                        $name = $this->getRequest()->getPost('name');
                        $email = $this->getRequest()->getPost('email');

                        //if type= 1, normal signup

                        if ($type == 1) {

                            $password = $this->getRequest()->getPost('password');

                            $signupTokenStrng = time() . $email;
                            $signupToken = md5($signupTokenStrng);


                            if ($email) {

                                $checkEmail = $users->validateUserEmail($email);

                                if (empty($checkEmail)) {

                                    $insertData['uname'] = $name;
                                    $insertData['email'] = $email;
                                    $insertData['password'] = md5(sha1($password));
                                    $insertData['role'] = 1;
                                    $insertData['reg_date'] = date('Y-m-d H:i:s');
                                    $insertData['ActivationToken'] = $signupToken;

                                    $insertId = $users->insertUser($insertData);


                                    if ($insertId) {

                                        $signupTokenlink = $this->_appSetting->hostLink . '/activate-account/?token=' . $signupToken;

                                        $to = $email;
                                        $subject = 'Activate Your Account';
                                        $template_name = 'Activation User Account';
                                        $username = "Ziingo Support";
                                        $mergevars = array(
                                            array(
                                                'name' => 'UserNickName',
                                                'content' => $name
                                            ),
                                            array(
                                                'name' => 'signuptokenlink',
                                                'content' => $signupTokenlink
                                            ),
                                            array(
                                                'name' => 'userEmail',
                                                'content' => $email
                                            )
                                        );
                                        $result = $mailer->sendtemplate($template_name, $to, $username, $subject, $mergevars);
                                    }

                                    if ($result[0]['status'] == "sent") {
//
//                                        $metaData['userinfo_id'] = $insertId;
//                                        $usermetaid = $usermeta->insertUserMeta($metaData);
//                            
//                                        $return = $insertId;

                                        $response->code = 200;
                                        $response->message = "Successfully Register.Please check your email for Confirm Email";
                                        $response->data['user_id'] = $insertId;
                                    } else {
                                        $response->code = 196;
                                        $response->message = "Error Occured : try again";
                                    }
                                } else {
                                    $response->code = 198;
                                    $response->message = "Email already exist";
                                }
                            } else {
                                $response->code = 201;
                                $response->message = "Email param doesn't exists";
                            }
                        } else if ($type == 2) {

//if type=2 facebook signup

                            $facebookId = $this->getRequest()->getPost('social_id');
                            if (isset($facebookId)) {

                                $checkFb = $users->checkFBUserExist($facebookId);
                                if (empty($checkFb)) {
                                    if ($email) {
                                        $checkEmail = $users->validateUserEmail($email);
                                        if (empty($checkEmail)) {

                                            $insertData['uname'] = $name;
                                            $insertData['email'] = $email;
                                            $insertData['password'] = null;
                                            $insertData['fb_id'] = $facebookId;
                                            $insertData['status'] = 1;
                                            $insertData['role'] = 1;
                                            $insertData['reg_date'] = date('Y-m-d H:i:s');
                                            $insertId = $users->insertUser($insertData);
                                            if ($insertId) {
                                                $metaData['user_id'] = $insertId;
                                                $usermetaid = $usermeta->insertUserMeta($metaData);
                                                $return = $insertId;

                                                $response->code = 200;
                                                $response->message = "signup Success";
                                                $response->data['user_id'] = $return;
                                            } else {
                                                $response->code = 196;
                                                $response->message = "Error Occured : try again";
                                            }
                                        } else {
                                            $response->code = 196;
                                            $response->message = "Email Already Registered";
                                        }
                                    } else {
                                        $response->code = 201;
                                        $response->message = "Email param doesn't exists";
                                    }
                                } else {
                                    $response->code = 198;
                                    $response->message = "facebook id already exist";
                                }
                            } else {
                                $response->code = 198;
                                $response->message = "Request Could Not Processed";
                            }
                        } else if ($type == 3) {


// type=3  twitter signup

                            $twitterId = $this->getRequest()->getPost('social_id');
                            if (isset($twitterId)) {
                                $checkTwt = $users->checkTWTUserExist($twitterId);

                                if (empty($checkTwt)) {
                                    if ($email) {
                                        $checkEmail = $users->validateUserEmail($email);
                                        if (empty($checkEmail)) {

                                            $insertData['uname'] = $name;
                                            $insertData['email'] = $email;
                                            $insertData['password'] = null;
                                            $insertData['twt_id'] = $twitterId;
                                            $insertData['status'] = 1;
                                            $insertData['role'] = 1;
                                            $insertData['reg_date'] = date('Y-m-d H:i:s');
                                            $insertId = $users->insertUser($insertData);

                                            if ($insertId) {
                                                $metaData['user_id'] = $insertId;
                                                $usermetaid = $usermeta->insertUserMeta($metaData);
                                                $return = $insertId;

                                                $response->code = 200;
                                                $response->message = "signup Success";
                                                $response->data['user_id'] = $return['user_id'];
                                            } else {
                                                $response->code = 196;
                                                $response->message = "Error Occured : try again";
                                            }
                                        } else {
                                            $response->code = 196;
                                            $response->message = "email Already Registered";
                                        }
                                    } else {
                                        $response->code = 201;
                                        $response->message = "Email param doesn't exists";
                                    }
                                } else {
                                    $response->code = 200;
                                    $response->message = "twitter id already exist";
                                }
                            } else {
                                $response->code = 198;
                                $response->message = "Request Could Not Processed";
                            }
                        } else {
                            $response->code = 198;
                            $response->message = "Required parameter not passed";
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "invalid Request";
                    }
                    echo json_encode($response, true);
                    die;
                    break;

                case'login':

                    if ($this->getRequest()->isPost()) {
                        $typeofrequest = $this->getRequest()->getPost('type');

                        if (!empty($typeofrequest)) {

                            switch ($typeofrequest) {

                                case 1 : // Normal login
                                    $email = $this->getRequest()->getPost('email');

                                    $password = $this->getRequest()->getPost('password');

                                    if (!empty($email)) {

                                        $userData = $users->authenticateByEmail($email, md5(sha1($password)));

                                        if ($userData) {

                                            if ($userData['status'] == 1) {

                                                $userid = $userData['user_id'];

                                                $usermeta = $users->checkuserid($userid);

                                                if ($usermeta) {
                                                    $response->message = 'Authentication successful';
                                                    $response->code = 200;
                                                    $response->data['user_id'] = $userData['user_id'];
                                                    $response->data['uname'] = $userData['uname'];
                                                    $response->data['email'] = $userData['email'];
                                                    $response->data['status'] = 'Old User';
                                                } else {
                                                    $response->message = 'Authentication successful';
                                                    $response->code = 200;
                                                    $response->data['user_id'] = $userData['user_id'];
                                                    $response->data['uname'] = $userData['uname'];
                                                    $response->data['email'] = $userData['email'];
                                                    $response->data['status'] = 'New User';
                                                }
                                            } else {
                                                $response->message = 'Need to Activate Email 1st';
                                                $response->code = 196;
                                            }
                                        } else {
                                            $response->message = 'Please check your Email or Password.It is Incorrect';

                                            $response->code = 197;
                                        }
                                    } else {
                                        $response->message = 'Email cannot be blank';
                                        $response->code = 198;
                                    }

                                    echo json_encode($response, true);
                                    die;
                                    break;

                                case 2:  // FB login

                                    $fb_id = $this->getRequest()->getPost('social_id');

                                    if (!empty($fb_id)) {

                                        $checkFb = $users->checkFBUserExist($fb_id);

                                        if ($checkFb) {

                                            $userid = $checkFb['user_id'];
                                            $usermeta = $users->checkuserid($userid);

                                            if ($usermeta) {
                                                $response->message = 'Authentication successful';
                                                $response->code = 200;
                                                $response->data['user_id'] = $checkFb['user_id'];
                                                $response->data['uname'] = $checkFb['uname'];
                                                $response->data['email'] = $checkFb['email'];
                                                $response->data['status'] = 'Old User';
                                            } else {
                                                $response->message = 'Authentication successful';
                                                $response->code = 200;
                                                $response->data['user_id'] = $checkFb['user_id'];
                                                $response->data['uname'] = $checkFb['uname'];
                                                $response->data['email'] = $checkFb['email'];
                                                $response->data['status'] = 'New User';
                                            }
                                        } else {
                                            $response->message = 'Authentication Failed';
                                            $response->code = 197;
                                        }
                                    } else {
                                        $response->message = 'Request Parameter Fb id is required';
                                        $response->code = 196;
                                    }

                                    echo json_encode($response, true);
                                    die;
                                    break;


                                case 3 : // Twitter login

                                    $twt_id = $this->getRequest()->getPost('social_id');

                                    if (!empty($twt_id)) {

                                        $checktwt = $users->checkTWTUserExist($twt_id);

                                        if ($checktwt) {

                                            $userid = $checktwt['user_id'];
                                            $usermeta = $users->checkuserid($userid);

                                            if ($usermeta) {
                                                $response->message = 'Authentication successful';
                                                $response->code = 200;
                                                $response->data['user_id'] = $checktwt['user_id'];
                                                $response->data['uname'] = $checktwt['uname'];
                                                $response->data['email'] = $checktwt['email'];
                                                $response->data['status'] = 'Old User';
                                            } else {
                                                $response->message = 'Authentication successful';
                                                $response->code = 200;
                                                $response->data['user_id'] = $checktwt['user_id'];
                                                $response->data['uname'] = $checktwt['uname'];
                                                $response->data['email'] = $checktwt['email'];
                                                $response->data['status'] = 'New User';
                                            }
                                        } else {
                                            $response->message = 'Authentication Failed';
                                            $response->code = 197;
                                        }
                                    } else {
                                        $response->message = 'Request Parameter Fb id is required';
                                        $response->code = 196;
                                    }

                                    echo json_encode($response, true);
                                    die;
                                    break;
                            }
                        } else {
                            $response->message = 'Invalid Request';
                            $response->code = 401;
                            echo json_encode($response, true);
                            die();
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                    }
                    echo json_encode($response, true);
                    die();
                    break;
            }
        } else {

            $response->message = 'Invalid Request';
            $response->code = 401;
            echo json_encode($response);
            die();
        }
    }

    /*
     * Dev : Sibani Mishra
     * Date : 15th March 2016
     * Desc : Activation Email
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

//            $this->_appSetting = $objCore->getAppSetting();
//            $url = $this->_appSetting->apiLink . '/user-authentication?method=userSignupActivationLink';
            $url = 'api.ziingo.com/user-authentication?method=userSignupActivationLink';
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
     * Date : 2/12/2015
     * Desc : user profile registration and updation
     * 
     */

    public function userProfileAction() {
        $users = Application_Model_Users::getInstance();
        $usermeta = Application_Model_Usermeta::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {
            switch ($method) {
                case'userprofileinfo':
                    if ($this->getRequest()->isPost()) {

                        $firstname = $this->getRequest()->getPost('firstname');
                        if (!empty($firstname)) {
                            $data['first_name'] = $firstname;
                        }

                        $lastname = $this->getRequest()->getPost('lastname');
                        if (!empty($firstname)) {
                            $data['last_name'] = $lastname;
                        }

                        $phone = $this->getRequest()->getPost('phone');
                        if (!empty($phone)) {
                            $data['phone'] = $phone;
                        }

                        $city = $this->getRequest()->getPost('city');
                        if (!empty($city)) {
                            $data['city'] = $city;
                        }

                        $state = $this->getRequest()->getPost('state');
                        if (!empty($state)) {
                            $data['state'] = $state;
                        }

                        $country = $this->getRequest()->getPost('country');
                        if (!empty($country)) {
                            $data['country'] = $country;
                        }

                        $contactcountrycode = $this->getRequest()->getPost('contactcountrycode');
                        if (!empty($contactcountrycode)) {
                            $data['contact_country_code'] = $contactcountrycode;
                        }

                        $userid = $this->getRequest()->getPost('userid');
                        if (!empty($userid)) {
                            $data['user_id'] = $userid;
                        }

                        $userinfodata = $users->checkUserData($userid);

                        if ($userinfodata == 'update') {

                            if (!empty($userid)) {

                                $usermetaid = $usermeta->updateUserMeta($userid, $data);

                                if ($usermetaid) {
                                    $response->message = 'Successfully updated';
                                    $response->code = 200;
                                } else {
                                    $response->message = 'Could not Serve the Request';
                                    $response->code = 197;
                                }
                            } else {
                                $response->message = 'Invalid Request';
                                $response->code = 401;
                            }
                        } else {
                            if ($userinfodata == 'insert') {

                                $userinfo = $usermeta->insertUserMetainfo($data);

                                if ($userinfo) {
                                    $response->message = 'Successfully inserted';
                                    $response->code = 200;
                                    $response->data = $userinfo;
                                } else {
                                    $response->message = 'Could not Serve the Request';
                                    $response->code = 197;
                                }
                            } else {
                                $response->message = $userinfodata;
                                $response->code = 401;
                            }
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                    }
                    echo json_encode($response, true);
                    die();
                    break;
                case 'getuserprofileinfo':

                    if ($this->getRequest()->isPost()) {

                        $userid = $this->getRequest()->getPost('userid');

                        if (!empty($userid)) {

                            $usermetaid = $usermeta->fetchUserMeta($userid);

                            if ($usermetaid) {

                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $usermetaid;
                            } else {
                                $response->message = 'Could not Serve the Request';
                                $response->code = 197;
                            }
                        } else {
                            $response->message = 'Invalid Request';
                            $response->code = 401;
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                    }
                    echo json_encode($response, true);
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
     * Date : 11/12/2015
     * Desc : agent authentication
     * 
     */

    public function agentAuthenticationAction() {


        $agentsModal = Application_Model_Agents::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {
            switch ($method) {
                case'agentsignup':
                    if ($this->getRequest()->isPost()) {
                        $data = $this->getRequest()->getPost('agentdata');
                        $dearr = json_decode($data, true);
                        $arrayinobject = (array) $dearr;
                        $insertId = $agentsModal->insertAgent($arrayinobject);
                        if ($insertId) {
                            $response->message = 'Successfull';
                            $response->code = 200;
                            $response->data = $insertId;
                        } else {
                            $response->message = 'Could not Serve the Request';
                            $response->code = 197;
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                    }
                    echo json_encode($response, true);
                    die();
                    break;

                case'agentlogin':

                    $response = new stdClass();
                    if ($this->getRequest()->isPost()) {
                        $data = $this->getRequest()->getPost('logindata');
                        $password = $this->getRequest()->getPost('password');

                        if (stripos($data, '@')) {
                            $userData = $agentsModal->authenticateByEmail($data, md5($password));
                        } else {
                            $userData = $agentsModal->authenticateByUsername($data, md5($password));
                        }
                        if ($userData) {
                            $response->message = 'Authentication successful';
                            $response->code = 200;
                            $response->data = $userData;
                        } else {
                            $response->message = 'No record found with this Credentials';
                            $response->code = 197;
                            $response->data = $userData;
                        }
                    } else {

                        $response->message = 'Request Could not served';
                        $response->code = 197;
                        $response->data = Null;
                    }

                    echo json_encode($response, true);
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
     * Date : 15/12/2015
     * Desc : web users authentication
     * 
     */


    /*
     * Dev : Sibani Mishra
     * Date : 4th March 2016
     * Desc : web users authentication through Normal user,Facebook,twitter
     * Desc : Signup activation Link
     * 
     */

    public function webAuthenticationAction() {


        $users = Application_Model_Users::getInstance();

        $mailer = Engine_Mailer_MandrillApp_Mailer::getInstance();

        $response = new stdClass();

        $objCore = Engine_Core_Core::getInstance();

        $this->_appSetting = $objCore->getAppSetting();

        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {

                case'usersignup':

                    if ($this->getRequest()->isPost()) {

                        $type = $this->getRequest()->getPost('type');

                        $name = $this->getRequest()->getPost('name');

                        $email = $this->getRequest()->getPost('email');

                        $password = $this->getRequest()->getPost('password');

//                        $confirmpassword = $this->getRequest()->getPost('ConfirmPassword');

                        $signupTokenStrng = time() . $email;
                        $signupToken = md5($signupTokenStrng);

                        $data = array_merge(['email' => $email], ['uname' => $name], ['password' => $password], ['ActivationToken' => $signupToken]);

                        $insertId = $users->insertUser($data);

                        if ($insertId) {

                            $signupTokenlink = $this->_appSetting->hostLink . '/activate-account/?token=' . $signupToken;

                            $to = $email;
                            $subject = 'Activate Your Account';
                            $template_name = 'Activation User Account';
                            $username = "Ziingo Support";
                            $mergevars = array(
                                array(
                                    'name' => 'UserNickName',
                                    'content' => $name
                                ),
                                array(
                                    'name' => 'signuptokenlink',
                                    'content' => $signupTokenlink
                                ),
                                array(
                                    'name' => 'userEmail',
                                    'content' => $email
                                )
                            );

                            $result = $mailer->sendtemplate($template_name, $to, $username, $subject, $mergevars);
                        }


                        if ($result[0]['status'] == "sent") {
                            $response->message = 'Successfully Register.Please check your email for Confirm Email';
                            $response->code = 200;
                            $response->data = $insertId;
                        } else {
                            $response->message = 'Could not Serve the Request';
                            $response->code = 197;
                        }

//Facebook User//
//                        } else if ($type == 2) {
//Twitter user//
//                        } else if ($type == 3) {
//                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                    }
                    echo json_encode($response, true);
                    die();
                    break;

                case 'userSignupActivationLink':


                    $signupToken = $this->getRequest()->getParam('ActivationToken');
                    $userData = $users->getUsercredsWhere($signupToken);
                    $email = $userData['email'];
                    $name = $userData['uname'];


                    if ($userData['role'] == 1) {

                        $usercredsData = array('ActivationToken' => '', 'status' => "1");
                        $userCreds = "user_id = '" . $userData['user_id'] . "'";
                        $updated = $users->updateActivationToken($usercredsData, $userCreds);

                        if (isset($updated)) {

                            $to = $email;
                            $subject = 'Welcome To ZIINGO';
                            $template_name = 'Welcome Message';
                            $username = "Ziingo Support";
                            $mergevars = array(
                                array(
                                    'name' => 'UserNickName',
                                    'content' => $name
                                ),
                                array(
                                    'name' => 'userEmail',
                                    'content' => $email
                                )
                            );
                            $result = $mailer->sendtemplate($template_name, $to, $username, $subject, $mergevars);
                            if ($result[0]['status'] == "sent") {
                                $response->message = 'Authentication successful';
                                $response->code = 200;
                                $response->data = $updated;
                            } else {
                                $response->message = 'Something went wrong please try again';
                                $response->code = 100;
                                $response->data = NULL;
                            }
                        } else {
                            $response->message = 'Oops you are lost. Click <a>here</a> to go to home page.';
                            $response->code = 401;
                            $response->data = NULL;
                        }
                    }
                    echo json_encode($response, true);
                    die;
                    break;

                case'userlogin':


                    $response = new stdClass();
                    if ($this->getRequest()->isPost()) {
                        $data = $this->getRequest()->getPost('logindata');
                        $password = $this->getRequest()->getPost('password');

                        if (!empty($data)) {

                            $userData = $users->authenticateByEmail($data, sha1(md5($password)));

                            if ($userData) {
                                if ($userData['status'] == 1) {

                                    $response->message = 'Authentication successful';
                                    $response->code = 200;
                                    $response->data['user_id'] = $userData['user_id'];
                                } else {

                                    $response->message = 'Need to Activate Email 1st';
                                    $response->code = 196;
                                }
                            } else {
                                $response->message = 'Please check your Email or Password.It is Incorrect';

                                $response->code = 197;
                            }
                        } else {
                            $response->message = 'Email cannot be blank';
                            $response->code = 198;
                        }

//                        if (stripos($data, '@')) {
//                            $userData = $users->authenticateByEmail($data, sha1(md5($password)));
//                        } else {
//                            $userData = $users->authenticateByUsername($data, sha1(md5($password)));
//                        }
//                        if ($userData) {
//                            $response->message = 'Authentication successful';
//                            $response->code = 200;
//                            $response->data = $userData;
//                        } else {
//                            $response->message = 'No record found with this Credentials';
//                            $response->code = 197;
//                            $response->data = $userData;
//                        }
                    } else {

                        $response->message = 'Request Could not served';
                        $response->code = 197;
                        $response->data = Null;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'validateusername':


                    if ($this->getRequest()->isPost()) {
                        $username = $this->getRequest()->getPost('uname');
//                        echo $username;die("dghf");
                        if ($username) {
                            $userData = $users->validateUserName($username);
                            if ($userData) {
                                $response->message = 'same username exists';
                                $response->code = 197;
                                $response->data = $userData;
                            } else {
                                $response->message = 'username verified';
                                $response->code = 200;
                                $response->data = $userData;
                            }
                        }
                    } else {
                        $response->message = 'Request Could not served';
                        $response->code = 197;
                        $response->data = Null;
                    }

                    echo json_encode($response, true);
                    die();

                    break;

                case'validateemail':

                    if ($this->getRequest()->isPost()) {
                        $email = $this->getRequest()->getPost('email');
                        if ($email) {
                            $userData = $users->validateUserEmail($email);
                            if ($userData) {
                                $response->message = 'same email exists';
                                $response->code = 197;
                                $response->data = $userData;
                            } else {
                                $response->message = 'email verified';
                                $response->code = 200;
                                $response->data = $userData;
                            }
                        }
                    } else {
                        $response->message = 'Request Could not served';
                        $response->code = 197;
                        $response->data = Null;
                    }

                    echo json_encode($response, true);
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
     * Dev : Sibani Mishra
     * Date : 11th March 2016
     * Desc : Forgot Password
     * 
     */

    public function forgotPasswordAction() {

        $response = new stdClass();

        if ($this->getRequest()->isPost()) {

            $users = Application_Model_Users::getInstance();
            $mailer = Engine_Mailer_MandrillApp_Mailer::getInstance();
            $method = $this->getRequest()->getPost('method');

            switch ($method) {

                case "EnterEmailId":

                    if ($this->getRequest()->isPost()) {

                        $postData = $this->getRequest()->getParams();

                        $fpwemail = '';
                        if (isset($postData['EmailId'])) {
                            $fpwemail = $postData['EmailId'];
                        }

                        if ($fpwemail != '') {

                            $resetcode = mt_rand(100000, 999999);

                            $exists = $users->checkMail($fpwemail, $resetcode);

                            $uname = $exists['uname'];

                            if ($exists) {
//Mandrill mail
                                $template_name = 'ResetPW';
                                $to = $fpwemail;
                                $username = "Ziingo Support";
                                $subject = "Ziingo Reset password";
                                $mergevars = array(
                                    array(
                                        'name' => 'resetcode',
                                        'content' => $resetcode
                                    ),
                                    array(
                                        'name' => 'usermail',
                                        'content' => $fpwemail
                                    ),
                                    array(
                                        'name' => 'support',
                                        'content' => "Ziingo Support"
                                    )
                                );
                                $result = $mailer->sendtemplate($template_name, $to, $username, $subject, $mergevars);

//Mandrill mail ends
                                if ($result[0]['status'] == "sent") {
//                                if (true) {
                                    $response->code = 200;
                                    $response->message = "Mail Sent with Reset code";
                                    $response->data = 1;
                                }
                            } else {
                                $response->code = 100;
                                $response->message = "Email Doesnt Exist. Enter correct Email.";
                                $response->data = null;
                            }
                        } else {
                            $response->code = 100;
                            $response->message = "You missed something";
                            $response->data = null;
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Invalid request";
                        $response->data = null;
                    }
                    echo json_encode($response, true);
                    break;
                case "verifyResetCode":
                    if ($this->getRequest()->isPost()) {
                        $postData = $this->getRequest()->getParams();
                        $fpwemail = '';
                        if (isset($postData['EmailId'])) {
                            $fpwemail = $postData['EmailId'];
                        }
                        $resetcode = '';
                        if (isset($postData['resetcode'])) {
                            $resetcode = $postData['resetcode'];
                        }

                        if ($fpwemail != '' && $resetcode != '') {

                            $exists = $users->verifyResetCode($fpwemail, $resetcode);


                            if ($exists) {
                                $response->code = 200;
                                $response->message = "Reset Code Verified Successfully.";
                                $response->data = $exists;
                            } else {
                                $response->code = 100;
                                $response->message = "Reset Code Didnt Matched, Enter Correct Reset Code.";
                                $response->data = null;
                            }
                        } else {
                            $response->code = 100;
                            $response->message = "You missed something";
                            $response->data = null;
                        }
//                        } else {
//                            $response->code = 401;
//                            $response->message = "Access Denied";
//                            $response->data = null;
//                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Invalid request";
                        $response->data = null;
                    }
                    echo json_encode($response, true);
                    break;

                case "resetPassword":

                    if ($this->getRequest()->isPost()) {

                        $postData = $this->getRequest()->getParams();

                        $fpwemail = '';
                        if (isset($postData['EmailId'])) {
                            $fpwemail = $postData['EmailId'];
                        }

                        $resetcode = '';
                        if (isset($postData['resetcode'])) {
                            $resetcode = $postData['resetcode'];
                        }

                        $password = ''; //Send Password in md5 format
                        if (isset($postData['Password'])) {
                            $password = $postData['Password'];
                        }

                        $re_password = '';
                        if (isset($postData['rePassword'])) {
                            $re_password = $postData['rePassword'];
                        }

                        if ($fpwemail != '' && $resetcode != '' && $password != '' && $re_password != '') {

                            if ($password == $re_password) {

                                $updated = $users->resetPassword($fpwemail, $resetcode, $password);

                                if ($updated) {
                                    $response->code = 200;
                                    $response->message = "Password Changed Successfully.";
                                    $response->data = $updated;
                                } else {
                                    $response->code = 100;
                                    $response->message = "Something went Wrong. Provide Correct Input.";
                                    $response->data = null;
                                }
                            } else {
                                $response->code = 100;
                                $response->message = "Password Didnt match";
                                $response->data = null;
                            }
                        } else {
                            $response->code = 100;
                            $response->message = "You missed something";
                            $response->data = null;
                        }
//                        } else {
//                            $response->code = 401;
//                            $response->message = "Access Denied";
//                            $response->data = null;
//                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Invalid request";
                        $response->data = null;
                    }
                    echo json_encode($response, true);
                    break;
                default:
                    break;
            }
        }
    }

}

?>