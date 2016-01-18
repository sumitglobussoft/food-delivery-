<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Web_HomeController extends Zend_Controller_Action {

    public function init() {
        
    }
/*
 * Dev: Priyanka Varanasi
 * Date : 13/1/2016
 * Desc: Home page funtionlity such as search..
 */
    public function indexAction(){
        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $url = $this->_appSetting->apiLink . '/get-locations?method=getcitys';
        $curlResponse = $objCurlHandler->curlUsingGet($url);
         if ($curlResponse->code===200) {
             $this->view->cityslist = $curlResponse->data;
             }
          if($this->getRequest()->isPost()){
                $citylocation_id =   $this->getRequest()->getPost('city');
                $location_id =   $this->getRequest()->getPost('location');
                if($location_id){
                    }
                }
                        
                        
      }
        
    
   /*
 * Dev: Priyanka Varanasi
 * Date : 12/1/2016
 * Desc: ajax handler funtionalitys
 */ 
    
    public function homeAjaxHandlerAction(){
        
        $this->_helper->_layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
     
        $method = $this->getRequest()->getParam('methodtype');
         
        switch($method){
            case 'getlocations':
                $locationid = $this->getRequest()->getParam('locationid');
                  $url = $this->_appSetting->apiLink . '/get-locations?method=getlocations';
                  $data['location_id'] = $locationid;
                 $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
                   if($curlResponse->code==200){
                       $array = array('code'=>200,
                                       'data'=>$curlResponse->data);
                       echo json_encode($array,true);
                       die;
                   }else{
                     $array = array('code'=>198,
                        'message'=>'No location for the city');
                       echo json_encode($array,true); 
                       die;
                   }
                break;
               case 'getproductdetails':
                $productid = $this->getRequest()->getParam('productid');
                $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getproductbyproductId';
                $dat['product_id'] = $productid;
                $curlResponse = $objCurlHandler->curlUsingPost($url,$dat);
//                
//                $url = $this->_appSetting->apiLink . '/addto-cart?method=InsertOrdersToCart';
//                        $data['user_id'] = $curlResponse->data('userid');
//                        $data['product_id'] = $this->getrequest()->getPost('productid');
//                        $data['hotel_id'] = $this->getRequest()->getPost('hotelid');
//                        $data['quantity'] = $this->getRequest()->getPost('quantity');
//                        $data['cost'] = $this->getRequest()->getPost('cost');
//                $cResponse = $objCurlHandler->curlUsingPost($url,$data);
              
                   if($curlResponse->code==200){
                       $array = array('code'=>200,
                                       'data'=>$curlResponse->data);
                       echo json_encode($array,true);
                       die;
                    }else{
                     $array = array('code'=>198,
                        'message'=>'No product found');
                       echo json_encode($array,true); 
                       die;
                   }
                break;
                
            default :
                break;
        }
    }
    /*
 * Dev: Priyanka Varanasi
 * Date : 14/1/2016
 * Desc: restaurents list display based on restaurents search
 */
      public function restaurentsListAction(){
        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
            $citylocation_id =   $this->getRequest()->getParam('city');
                $location_id =   $this->getRequest()->getParam('location_id');
               
            ///////////for fetching name of the city in which the restaurents located//////////////
               
          $loc['city_id'] = $citylocation_id;
         $url = $this->_appSetting->apiLink . '/get-restaurants-list?method=getcityname';
         $Response = $objCurlHandler->curlUsingPost($url,$loc);
          if ($Response->code==200) {
             $this->view->cityname = $Response->data['name'];
         }
         ///////////////////code ends ///////
                if($location_id){
                    $info['location_id'] = $location_id;
                     $info['city_id'] = $citylocation_id;
         
        $curlResponse = $objCurlHandler->curlUsingPost($url,$info);
              $url = $this->_appSetting->apiLink . '/get-restaurants-list?method=bylocationid';
        $curlResponse = $objCurlHandler->curlUsingPost($url,$info);
           
         if ($curlResponse->code==200) {
             $this->view->restaurantslist = $curlResponse->data;
                }else{
                $info['location_id'] = $citylocation_id;    
            $url = $this->_appSetting->apiLink . '/get-restaurants-list?method=bycityid';
        $curlResponse = $objCurlHandler->curlUsingPost($url,$info);
         if ($curlResponse->code===200) {
           $this->view->restaurantslist = $curlResponse->data;
               
              }     
                 }
               }
 
}


  /*
 * Dev: Priyanka Varanasi
 * Date : 14/1/2016
 * Desc: restaurents details display
 */

  public function restaurantDetailsAction(){
    
        $mailer = Engine_Mailer_Mailer::getInstance();
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $hotel_id =   $this->getRequest()->getParam('id');
        if($hotel_id){
         $loc['hotel_id'] = $hotel_id;
          /****** Display of restaurant  details******/
           $url = $this->_appSetting->apiLink . '/restaurant-info-card?method=gethotelinfo';
         $curlResponse = $objCurlHandler->curlUsingPost($url,$loc);
         if($curlResponse->code==200){
            $this->view->hoteldata = $curlResponse->data;
                }
         /****** Display of restaurant menu details and products******/
         $url = $this->_appSetting->apiLink . '/restaurant-info-card?method=getmenulist';
         $Response = $objCurlHandler->curlUsingPost($url,$loc);
         if($Response->code==200){
              $this->view->hotelmenu = $Response->data;
         }
         
            
        }
}
}
