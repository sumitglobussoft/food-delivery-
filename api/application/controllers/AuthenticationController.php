<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class AuthenticationController extends Zend_Controller_Action{

    public function init()
    { 
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

    public function userAuthenticationAction() {
               
        $users = Application_Model_Users::getInstance();
        $usermeta = Application_Model_Usermeta::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        
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
                            if($email){
                            $checkEmail = $users->validateUserEmail($email);
                            if (empty($checkEmail)) {
                                $insertData['uname'] = $name;
                                $insertData['email'] = $email;
                                $insertData['password'] = md5(sha1($password));
                                $insertData['status'] = 1;
                                $insertData['role'] = 1;
                                $insertData['reg_date'] = date('Y-m-d H:i:s');
                                $insertId = $users->insertUser($insertData);
                                //send welcome email //
                  
                                if ($insertId) {
                                    $metaData['user_id'] = $insertId;
                                    $usermetaid = $usermeta->insertUserMeta($metaData);
                                    $return['user_id'] = $insertId;

                                    $response->code = 200;
                                    $response->message = "signup Success";
                                    $response->data['user_id'] = $return;
                                } else {
                                    $response->code = 196;
                                    $response->message = "Error Occured : try again";
                                }
                            } else {
                                $response->code = 198;
                                $response->message = "Email already exist";
                        } }else{
                               $response->code = 201;
                                $response->message = "Email param doesn't exists";
                        }
                        } else if ($type == 2) { 
                            //if type=2 facebook signup
                            $facebookId = $this->getRequest()->getPost('social_id');
                            if(isset($facebookId)){
                                                                
                                $checkFb = $users->checkFBUserExist($facebookId);
                                if(empty($checkFb)){
                                    if($email){
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
                                            $return['user_id'] = $insertId;

                                            $response->code = 200;
                                            $response->message = "signup Success";
                                            $response->data['user_id'] = $return;
                                        } else {
                                            $response->code = 196;
                                            $response->message = "Error Occured : try again";
                                        }
                                    }else{
                                            $response->code = 196;
                                            $response->message = "Email Already Registered";
                                } }else{
                                   $response->code = 201;
                                $response->message = "Email param doesn't exists";  
                                }
                                }else{
                                    $response->code = 198;
                                    $response->message = "facebook id already exist";
                                }
                            }else{
                               $response->code = 198;
                               $response->message = "Request Could Not Processed";  
                            }
                            
                            
                        } else if ($type == 3) {
                            // type=3  twitter signup
                            
                            $twitterId = $this->getRequest()->getPost('social_id');
                            if(isset($twitterId)){
                                $checkTwt = $users->checkTWTUserExist($twitterId);
                                
                                if(empty($checkTwt)){
                                    if($email){
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
                                            $return['user_id'] = $insertId;

                                            $response->code = 200;
                                            $response->message = "signup Success";
                                            $response->data['user_id'] = $return['user_id'];
                                        } else {
                                            $response->code = 196;
                                            $response->message = "Error Occured : try again";
                                        }
                                    }else{
                                            $response->code = 196;
                                            $response->message = "email Already Registered";
                                    } }else{
                                    $response->code = 201;
                                   $response->message = "Email param doesn't exists";  
                                
                                    }
                                }else{
                                    $response->code = 200;
                                    $response->message = "twitter id already exist";
                                }
                            }else{
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
                    echo json_encode($response,true);
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
                                             if($userData){
                                             $response->message = 'Authentication successful';
                                             $response->code = 200; 
                                             $response->data['user_id'] = $userData['user_id'];  
                                             }else{
                                               $response->message = 'Authentication Failed';
                                             $response->code = 197;   
                                                }
                                        }else {
                                            $response->message = 'Email Parameter required';
                                            $response->code = 196;
                                        }
                                    
                                    echo json_encode($response,true);
                                     die;
                                    break;

                                case 2:  // FB login
                                  
                                 $fb_id = $this->getRequest()->getPost('social_id');
                                 if (!empty($fb_id)) {
                                           $checkFb = $users->checkFBUserExist($fb_id);
                                             if($checkFb){
                                             $response->message = 'Authentication successful';
                                             $response->code = 200;
                                             $response->data['user_id'] = $checkFb['user_id']; 
                                            
                                             }else{
                                               $response->message = 'Authentication Failed';
                                             $response->code = 197;   
                                                }
                                        }else {
                                            $response->message = 'Request Parameter Fb id is required';
                                            $response->code = 196;
                                        }
                                   
                                    echo json_encode($response,true);
                                     die;

                                    break;


                                case 3 : // Twitter login
                               
                                 $twt_id = $this->getRequest()->getPost('social_id');
                                 if (!empty($twt_id)) {
                                           $checktwt = $users->checkTWTUserExist($twt_id);
                                             if($checktwt){
                                             $response->message = 'Authentication successful';
                                             $response->code = 200;  
                                             $response->data['user_id'] = $checktwt['user_id'];  
                                            
                                             }else{
                                               $response->message = 'Authentication Failed';
                                             $response->code = 197;   
                                                }
                                        }else {
                                            $response->message = 'Request Parameter Fb id is required';
                                            $response->code = 196;
                                        }
                                   
                                    echo json_encode($response,true);
                                     die;

                                    break;
                            }
                        } else {
                            $response->message = 'Invalid Request';
                            $response->code = 401;
                            echo json_encode($response,true);
                            die();
                        }
                    } 
                    else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                       
                    }
                        echo json_encode($response,true);
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
                 if($this->getRequest()->isPost()){
                     
             $firstname  = $this->getRequest()->getPost('firstname');
        if(!empty($firstname)){
             $data['first_name'] = $firstname;
           }
         
            $lastname  = $this->getRequest()->getPost('lastname');
        if(!empty($firstname)){
             $data['last_name'] = $lastname; 
           }

              $phone  = $this->getRequest()->getPost('phone');
        if(!empty($phone)){
             $data['phone'] = $phone; 
           }

               $city = $this->getRequest()->getPost('city');
        if(!empty($city)){
             $data['city'] = $city;
           }

             $state  = $this->getRequest()->getPost('state');
        if(!empty($state)){
             $data['state'] = $state;
           }

	    $country  = $this->getRequest()->getPost('country');
        if(!empty($country)){
             $data['country'] = $country;
           }

	    $address  = $this->getRequest()->getPost('address');
        if(!empty($address)){
             $data['address'] = $address;
           }
        $userid = $this->getRequest()->getPost('userid');
          if (!empty($userid)) {
                            $usermetaid = $usermeta->updateUserMeta($userid, $data);
                            if ($usermetaid) {
                                $response->message = 'Successfull';
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
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                     }
                    echo json_encode($response,true);
                     die();
                    break;
            }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = 'No Method';

            echo json_encode($response,true);
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
                 if($this->getRequest()->isPost()){
                        $data = $this->getRequest()->getPost('agentdata');
                        $dearr  = json_decode($data,true);
                        $arrayinobject = (array)$dearr;
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
                        echo json_encode($response,true);
                        die();
                        break;
                        
                case'agentlogin':
                    
           $response = new stdClass();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('logindata');
            $password = $this->getRequest()->getPost('password'); 
          
            if (stripos($data, '@')) {
                $userData = $agentsModal->authenticateByEmail($data, sha1(md5($password)));
             
            }else {
                $userData = $agentsModal->authenticateByUsername($data, sha1(md5($password)));
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
            }else{
                
              $response->message = 'Request Could not served';
                $response->code = 197;
                $response->data = Null;   
            }
           
         echo json_encode($response,true);
               die();
           break;
                   
            }     
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = 'No Method';

            echo json_encode($response,true);
            die();
        }
   

}



   /*
     * Dev : Priyanka Varanasi
     * Date : 15/12/2015
     * Desc : web users authentication
     * 
     */

    public function webAuthenticationAction() {
        
    
       $users = Application_Model_Users::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {
            switch ($method) {
               case'usersignup':
                 if($this->getRequest()->isPost()){
                        $data = $this->getRequest()->getPost('userdata');
                        $dearr  = json_decode($data,true);
                        $arrayinobject = (array)$dearr;
                        $insertId = $users->insertUser($arrayinobject);
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
                           echo json_encode($response,true);
                        die();
                        break;
                        
                case'userlogin':
                    
           $response = new stdClass();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('logindata');
            $password = $this->getRequest()->getPost('password'); 
          
            if (stripos($data, '@')) {
                $userData = $users->authenticateByEmail($data, sha1(md5($password)));
             
            }else {
                $userData = $users->authenticateByUsername($data, sha1(md5($password)));
               
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
            }else{
                
              $response->message = 'Request Could not served';
                $response->code = 197;
                $response->data = Null;   
            }
           
         echo json_encode($response,true);
               die();
           break;
           
               case'validateusername':
                                 
           $response = new stdClass();
        if ($this->getRequest()->isPost()) {
            $username = $this->getRequest()->getPost('uname');
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
        } }else{
              $response->message = 'Request Could not served';
                $response->code = 197;
                $response->data = Null;   
            }
           
         echo json_encode($response,true);
               die();
                   
                   break;
     case'validateemail':
           $response = new stdClass();
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
        } }else{
              $response->message = 'Request Could not served';
                $response->code = 197;
                $response->data = Null;   
            }
           
         echo json_encode($response,true);
               die();
                   
                   break;      
            }     
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = 'No Method';

            echo json_encode($response,true);
            die();
        }
   

}
               
}
?>