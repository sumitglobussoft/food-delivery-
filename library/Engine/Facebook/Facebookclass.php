<?php
include 'Facebook/FacebookCurlHttpClient.php';

require_once( 'Facebook/FacebookRequest.php' );

require_once( 'Facebook/FacebookResponse.php' );

require_once( 'Facebook/FacebookSDKException.php' );

require_once( 'Facebook/FacebookRequestException.php' );

require_once( 'Facebook/FacebookAuthorizationException.php' );

require_once( 'Facebook/GraphObject.php' );

require_once( 'Facebook/GraphUser.php' );

require_once( 'Facebook/FacebookCanvasLoginHelper.php' );

require_once( 'Facebook/FacebookPermissionException.php' );

use Facebook\FacebookRequest;
use Facebook\FacebookHttpable;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\FacebookCanvasLoginHelper;
use Facebook\FacebookPermissionException;

include 'Facebook/FacebookSession.php';
include 'Facebook/FacebookRedirectLoginHelper.php';

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
            $this->helper = new FacebookRedirectLoginHelper($this->_appSetting->hostLink.'/login');
//            echo "<pre>"; print_r($this->helper);die;
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
        return  $this->helper->getLoginUrl(array('scope' => 'user_location,email'));
    }
    
    public function getUserDetails() {
        if ($this->_session->fbsession != NULL) {
            $user_profile = (new FacebookRequest(
//                            $this->_session->fbsession, 'GET', '/me'
                    $this->_session->fbsession, 'GET', '/me?fields=id,name,first_name,last_name,email'
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
} 
?>