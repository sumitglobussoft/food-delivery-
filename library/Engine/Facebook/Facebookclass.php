<?php
//include '/Facebook/HttpClients/FacebookCurlHttpClient.php';
//
//require_once( 'Facebook/FacebookRequest.php' );
//
//require_once( 'Facebook/FacebookResponse.php' );
//
//require_once( 'Facebook/FacebookSDKException.php' );
//
//require_once( 'Facebook/FacebookRequestException.php' );
//
//require_once( 'Facebook/FacebookAuthorizationException.php' );
//
//require_once( 'Facebook/GraphObject.php' );
//
//require_once( 'Facebook/GraphUser.php' );
//
//require_once( 'Facebook/FacebookCanvasLoginHelper.php' );
//require_once( 'Facebook/FacebookPermissionException.php' );

require 'autoload.php';
use Facebook\FacebookRequest;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\FacebookCanvasLoginHelper;
use Facebook\FacebookPermissionException;
//include 'Facebook/FacebookSession.php';

//include 'Facebook/FacebookRedirectLoginHelper.php';

Use Facebook\FacebookSession;
Use Facebook\FacebookRedirectLoginHelper;

class Engine_Facebook_Facebookclass {
    

      // public $fbsession;
    ///Condition 1 - Presence of a static member variable
    private static $_instance = null;
    
    ///Condition 2 - Locked down the constructor
    private function __construct() {
        
        
            $objCore = Engine_Core_Core::getInstance();
            $this->_appSetting = $objCore->getAppSetting();
            $this->facebookId = $this->_appSetting->facebookId;
            $this->facebookSecret = $this->_appSetting->facebookSecret;
           
            $this->session = FacebookSession::setDefaultApplication($this->facebookId, $this->facebookSecret);
            $this->helper = new FacebookRedirectLoginHelper($this->_appSetting->hostLink.'/signup');
            $this->_session = $objCore->getSession();
            $this->_session->fbsession = $this->helper->getSessionFromRedirect();
    }
    
//Prevent any oustide instantiation of this class
    ///Condition 3 - Prevent any object or instance of that class to be cloned
    private function __clone() {
        
    }

//Prevent any copy of this object
    ///Condition 4 - Have a single globally accessible static method
    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Engine_Facebook_Facebookclass();
        return self::$_instance;
    }
    
    
    public function getLoginUrl(){ 
        return  $this->helper->getLoginUrl(array('scope' => 'user_birthday,user_location,user_about_me,user_friends,user_likes,publish_actions,email'));
    }
    
    public function getUserDetails() {
        if ($this->_session->fbsession != NULL) {
            $user_profile = (new FacebookRequest(
                            $this->_session->fbsession, 'GET', '/me'
                    ))->execute()->getGraphObject();
            return $user_profile;
        } else {
            return null;
        }
    }
   public function gefbToken(){ 
       if ($this->_session->fbsession != NULL) {
           return $this->_session->fbsession->getToken();
       }else{
           return null;
       }
   }     
  /**
     * This function posts a link to the user's timeline with the provided message.
     * 
     * @param String $link_address Required. Link to be posted in form of a String.
     * @param String $message Optional. Message to be posted along with the link
     * @return null If session object is not valid
     * @return String ID of the link uploaded in form of String
     */
    public function wallPost($link, $message = null, $caption = null,$name = null,$decription=null) {
        
        if($this->_session->fbsession == NULL){
            $session = FacebookSession::newAppSession();
            $this->_session->fbsession = $session;
        }
        if ($this->_session->fbsession != NULL) {
            try{
            // Graph API to publish to timeline
            $msg_body = array(
                        'name' =>  $name,
                        'caption' =>  $caption ,
                        'link' => $link, 
                        'message' => $message,
                        'description'=>$decription,
                        'picture' => $this->_appSetting->hostLink . $this->_appSetting->assestPath."images/fansports-logo - Copy.png"
                    );  
           if(isset($this->_session->fbid) && $this->_session->fbid!=null){
              
                $request = (new FacebookRequest($this->_session->fbsession, 'POST', '/'.$this->_session->fbid.'/feed',$msg_body))->execute();

                // Get response as an array, returns ID of post
                $result = $request->getGraphObject();
            }
            } catch (FacebookRequestException $e) {
//                echo "Exception occured, code: " . $e->getCode();
//                echo " with message: " . $e->getMessage();
            }
        } else {
            return null;
        }
    }
    
    
    public function userWallPost($fbId,$link, $message = null, $caption = null,$name = null ,$decription=null){

             if($this->_session->fbsession == NULL){ 
                $session = FacebookSession::newAppSession();
                $this->_session->fbsession = $session;
            }
            
            if ($this->_session->fbsession != NULL) {
                try { 
                    // Graph API to publish to timeline
                    $msg_body = array(
                        'name' => $name,
                        'caption' => $caption,
                        'link' => $link,
                        'message' => $message,
                        'description'=>$decription,
                        'picture'=> $this->_appSetting->hostLink . $this->_appSetting->assestPath."images/fansports-logo - Copy.png"
                    );
                   
                        $request = (new FacebookRequest($this->_session->fbsession, 'POST', '/' .$fbId. '/feed', $msg_body))->execute();
       
                        // Get response as an array, returns ID of post
                        $result = $request->getGraphObject();
                      
                } catch (FacebookRequestException $e) {
                    echo "Exception occured, code: " . $e->getCode();
                    echo " with message: " . $e->getMessage();
                }
            } else {
                return null;
            }
//        }
    }

    public function userJoinContest($fbID,$contestDetails=null){ 
         if($this->_session->fbsession == NULL){ 
                $session = FacebookSession::newAppSession();
                $this->_session->fbsession = $session;
            }
         if ($this->_session->fbsession != NULL && $fbID!=NULL) {
             if($contestDetails['prize_pool'] ==0){
                 $desc = "Join contest ".$contestDetails['contest_name']." in Draftoff";
             }else{
                 $desc = "Join contest ".$contestDetails['contest_name']." in Draftoff to win prize $".$contestDetails['prize_pool']." of contest";
             }
             
             
                  $objBody = array(
                                'fb:app_id' => $this->facebookId,
                                'og:title' =>	$contestDetails['contest_name'],
                                'og:image'=>	$this->_appSetting->hostLink."/assets/images/logo-large@2x1.png",
                                'og:url'=>	$this->_appSetting->hostLink,
                                'og:description' => $desc
                          );
                  $object = array('contest' => json_encode($objBody));
                  try{
                    $request = new FacebookRequest($this->_session->fbsession,'POST','/'.$fbID.'/'.$this->_appSetting->facebookappNamespace .':join',$object);

                    // Get response as an array, returns ID of post
                    $result = $request->execute()->getGraphObject();
                    } catch (FacebookRequestException $e) {
//                        echo "Exception occured, code: " . $e->getCode();
//                        echo " with message: " . $e->getMessage();
                    }
                }
           }
} 



?>