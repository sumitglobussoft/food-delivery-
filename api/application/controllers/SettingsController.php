<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class SettingsController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    /*
     * DEV :Priyanka Varanasi
     * Desc : To fetch citys, states, countries and locations to search restuarents
     * Date : 13/1/2016
     */
 
    public function getLocationsAction(){
        
     $locationsmodal = Application_Model_Location::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
       if($method){  
        switch ($method) {
       
   case'getcitys':
       
      $cityslist = $locationsmodal->getCitys(); 
        if($cityslist){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $cityslist;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
       
       echo json_encode($response,true);
           die();
       break;
       
       case'getlocations':
               
    if ($this->getRequest()->isPost()) {
       $location_id = $this->getRequest()->getPost('location_id');
     if($location_id){
      $locationslist = $locationsmodal->getLocationsByCitys($location_id); 
        if($locationslist){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $locationslist;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
            }   
     
         } }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
       
       echo json_encode($response,true);
           die();
       break;
   
    }
       }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
                echo json_encode($response,true);
           die();
    }
    
    /*
     * DEV :Priyanka Varanasi
     * Desc : To fetch restuarents based on citys or locations
     * Date : 13/1/2016
     */
 
    public function getRestaurantsListAction(){
        
     $locationsmodal = Application_Model_Location::getInstance();
     $hoteldetailsModal = Application_Model_HotelDetails::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
       if($method){  
        switch ($method) {
       
   case'bylocationid':
      if ($this->getRequest()->isPost()) {
       $location_id = $this->getRequest()->getPost('location_id');
       $citylocation_id = $this->getRequest()->getPost('city_id');
       if($location_id && $citylocation_id){ 
      $restuarentslist = $hoteldetailsModal->getRestaurentsByLocationid($location_id,$citylocation_id); 
        if($restuarentslist){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $restuarentslist;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
           
         } }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
       
       echo json_encode($response,true);
           die();
       break;
       
       case'bycityid':
               
    if ($this->getRequest()->isPost()) {
       $location_id = $this->getRequest()->getPost('location_id');
     if($location_id){
      $restuarentslist = $hoteldetailsModal->getRestaurentsBycityId($location_id); 
        if($restuarentslist){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $restuarentslist;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
            }   
     
         } }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
       
       echo json_encode($response,true);
           die();
       break;
     case'getcityname':
      if ($this->getRequest()->isPost()) {
      
       $citylocation_id = $this->getRequest()->getPost('city_id');
       if($citylocation_id){ 
      $cityname = $locationsmodal->getCityNameByCityId($citylocation_id); 
        if($cityname){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $cityname;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
           
         } }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
       
       echo json_encode($response,true);
           die();
       break;
       
    }
       }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
                echo json_encode($response,true);
           die();
    }
    
    
      
    /*
     * DEV :Priyanka Varanasi
     * Desc : To fetch restaurent menu products
     * Date : 15/1/2016
     */
 
    public function restaurantInfoCardAction(){
        
     $locationsmodal = Application_Model_Location::getInstance();
     $hoteldetailsModal = Application_Model_HotelDetails::getInstance();
     $productdetailsModal = Application_Model_Products::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
       if($method){  
        switch ($method) {
       
   case'getmenulist':
      if ($this->getRequest()->isPost()) {
       $hotel_id = $this->getRequest()->getPost('hotel_id');
       if($hotel_id){ 
      $restuarentsmenudetails = $productdetailsModal->getRestaurentsMenuDetails($hotel_id); 
        if($restuarentsmenudetails){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $restuarentsmenudetails;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
           
         } }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
       
       echo json_encode($response,true);
           die();
       break;
       
          case'gethotelinfo':
      if ($this->getRequest()->isPost()) {
       $hotel_id = $this->getRequest()->getPost('hotel_id');
       if($hotel_id){ 
      $restuarentsmenudetails = $hoteldetailsModal->getHoteldetailsByHotelId($hotel_id); 
        if($restuarentsmenudetails){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $restuarentsmenudetails;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
           
         } }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
       
       echo json_encode($response,true);
           die();
       break;

       
    }
       }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
                echo json_encode($response,true);
           die();
    } 
    
    
}
