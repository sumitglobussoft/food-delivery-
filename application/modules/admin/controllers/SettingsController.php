<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_SettingsController extends Zend_Controller_Action {

    public function init() {
        
    }

            /*
     * Dev: priyanka varanasi
     * Desc: fetch countrys from db
     * date : 13/1/2015;
     */
    public function countriesDetailsAction(){
        
      $locationsModel = Admin_Model_Location::getInstance();  
      
          $countrys   = $locationsModel->getCountrys();
          if($countrys){
              
              $this->view->countriesdetails = $countrys;
          }
        
    }
                /*
     * Dev: priyanka varanasi
     * Desc: fetch citys from db
     * date : 13/1/2015;
     */
      public function cityDetailsAction(){
          $locationsModel = Admin_Model_Location::getInstance();  
      
          $citys   = $locationsModel->getCitys();
          if($citys){
              
              $this->view->citiesdetails = $citys;
          }  
        
        
    }
                /*
     * Dev: priyanka varanasi
     * Desc: fetch states from db
     * date : 13/1/2015;
     */
    public function statesDetailsAction(){
       $locationsModel = Admin_Model_Location::getInstance();  
      
          $states   = $locationsModel->getStates();
          if($states){
              
              $this->view->statesdetails = $states;
          }  
    }
                /*
     * Dev: priyanka varanasi
     * Desc: fetch locations from db
     * date : 13/1/2015;
     */    
    public function locationDetailsAction(){
       $locationsModel = Admin_Model_Location::getInstance();  
      
          $locations   = $locationsModel->getLocations();
          if($locations){
              
              $this->view->locationdetails = $locations;
          }    
    }
    
    
   /*
     * Dev: priyanka varanasi
     * Desc: add coountrys 
     * date : 13/1/2015;
     */
     public function addCountryAction()
    {
         $locationsModel = Admin_Model_Location::getInstance();
         
         if($this->getRequest()->isPost()){
             
            $data['name']= $this->getRequest()->getPost('name');
            $data['location_status']= $this->getRequest()->getPost('location_status');
            $data['location_type']= 0;
            $data['parent_id']= 0;
             
           $result = $locationsModel->addLocation($data);
           if($result){
               
               $this->redirect('/admin/countries-details');
           }
           }
    }
     /*
     * Dev: priyanka varanasi
     * Desc: add states 
     * date : 13/1/2015;
     */
     public function addStateAction(){
        $locationsModel = Admin_Model_Location::getInstance(); 
         $countrieslist  = $locationsModel->getCountrys();
       
        if($countrieslist){
            $this->view->countrieslist = $countrieslist;
        }
        
          if($this->getRequest()->isPost()){
            $country= $this->getRequest()->getPost('coutries');
            $data['name']= $this->getRequest()->getPost('statename');
            $data['location_status']= $this->getRequest()->getPost('location_status');
            $data['location_type']= 1;
            if($country){
             $data['parent_id']= $country;   
            }
            $result = $locationsModel->addLocation($data);
           if($result){
               
               $this->redirect('/admin/states-details');
           }
           }
        
    }
     /*
     * Dev: priyanka varanasi
     * Desc: add citys 
     * date : 13/1/2015;
     */
        public function addCityAction(){
            
              $locationsModel = Admin_Model_Location::getInstance(); 
         $States  = $locationsModel->getStates();
       
        if($States){
            $this->view->stateslist = $States;
        }
        
          if($this->getRequest()->isPost()){
            $states= $this->getRequest()->getPost('states');
            $data['name']= $this->getRequest()->getPost('cityname');
            $data['location_status']= $this->getRequest()->getPost('location_status');
            $data['location_type']= 2;
            if($states){
             $data['parent_id']= $states;   
            }
            $result = $locationsModel->addLocation($data);
           if($result){
               
               $this->redirect('/admin/city-details');
           }
           }   
        
         }
    
     /*
     * Dev: priyanka varanasi
     * Desc: add locations 
     * date : 13/1/2015;
     */
         public function addLocationAction(){
             
                   
              $locationsModel = Admin_Model_Location::getInstance(); 
         $CitysList  = $locationsModel->getCitys();
       
        if($CitysList){
            $this->view->cityslist = $CitysList;
        }
        
          if($this->getRequest()->isPost()){
            $citys= $this->getRequest()->getPost('citys');
            $data['name']= $this->getRequest()->getPost('locationname');
            $data['location_status']= $this->getRequest()->getPost('location_status');
            $data['location_type']= 3;
            if($citys){
             $data['parent_id']= $citys;   
            }
            $result = $locationsModel->addLocation($data);
           if($result){
               
               $this->redirect('/admin/location-details');
           }
           } 
        
    }
    
}
