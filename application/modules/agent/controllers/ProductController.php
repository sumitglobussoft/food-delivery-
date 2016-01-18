<?php
/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Agent_ProductController extends Zend_Controller_Action {



    public function init() {     
        
    }
    
    /*
     * Dev : Priyanka Varanasi
     * Date: 18/12/2015
     * Desc : To fetch all product details
     */
    public function productDetailsAction(){
        
    $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
    $objCore = Engine_Core_Core::getInstance();
    $objSecurity = Engine_Vault_Security::getInstance();
    $this->_appSetting = $objCore->getAppSetting();
    $agent_id = $this->view->session->storage->agent_id;
    $url = $this->_appSetting->apiLink . '/getproducts?method=getagentproducts';
    $data['agent_id'] = $agent_id;
    $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
    if($curlResponse->code==200){
       
        $this->view->productdetails = $curlResponse->data;
        
    }
    }
    
      /*
     * Dev : Priyanka Varanasi
     * Date: 22/12/2015
     * Desc : To edit and update the product details
     */  
    
      public function editProductDetailsAction() {
          
    $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
    $objCore = Engine_Core_Core::getInstance();
    $objSecurity = Engine_Vault_Security::getInstance();
    $this->_appSetting = $objCore->getAppSetting();
    $agent_id = $this->view->session->storage->agent_id; 
   
    $product_id = $this->getRequest()->getParam('prod_id'); 
    
       if ($this->getRequest()->isPost()) {

           
            $data['name'] = $this->getRequest()->getPost('name');
            $data['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $data['cost'] = $this->getRequest()->getPost('cost');
            $data['prod_status'] = $this->getRequest()->getPost('prod_status');
            $data['product_id'] = $product_id;
            $coverphoto = $_FILES["fileToUpload"]["name"];

            $dirpath = getcwd()."/themes/agent/skin/productimages/$product_id/";
            
             if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
                 }
            if (!empty($coverphoto)) {
               $imagepath = $dirpath.$coverphoto;
               $savepath = "/themes/agent/skin/productimages/$product_id/$coverphoto";
               $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
               $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$imagepath));
                     if ($imagemoveResult) {
                    $data['imagelink'] = $savepath;
                    $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=updateproductdetails';
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    
                    if ($curlResponse->code == 200) {
                        $this->redirect('/agent-product-details');
                    }
                }else{
                    
                    echo "DIE HERE" ;die;
                }
                }
            } else {
                $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=updateproductdetails';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
              
                if ($curlResponse->code == 200) {
                    $this->redirect('/agent-product-details');
                }
            }
        }    
    $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getproductbyproductId';
    $data['product_id'] = $product_id;
    $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
   
    if($curlResponse->code==200){
      
        $this->view->editproductdetails = $curlResponse->data;
        
    }
      
      }
      
      
        /*
     * Dev : Priyanka Varanasi
     * Date: 22/12/2015
     * Desc : To add product details 
     */  
      
     public function addProductDetailsAction() {
         
    $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
    $objCore = Engine_Core_Core::getInstance();
    $objSecurity = Engine_Vault_Security::getInstance();
    $this->_appSetting = $objCore->getAppSetting();
    $agent_id = $this->view->session->storage->agent_id; 
    
    $url = $this->_appSetting->apiLink . '/hoteldetails?method=getHotelDetailsByAgentId';
    $data['agent_id'] = $agent_id;
    $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
    
     $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=GetCategorys';
     $curlResponseforcategory = $objCurlHandler->curlUsingGet($url);
     
    if($curlResponseforcategory->code==200){
       $j=0;
        $newarray= array();
        foreach ($curlResponseforcategory->data as $value) {
            
            $newarray[$j]['cat_id'] = $value['category_id'];
            $newarray[$j]['cat_name'] = $value['cat_name'];
           $j++ ;
        }   
         $this->view->categoryids = $newarray; 
    }
    if($curlResponse->code==200){
        $i=0;
        $array= array();
        foreach ($curlResponse->data as $value) {
            
            $array[$i]['hotel_id'] = $value['id'];
            $array[$i]['hotel_name'] = $value['hotel_name'];
           $i++ ;
        }
     
        $this->view->hotelids = $array;
        
    }
    
    if ($this->getRequest()->isPost()) {
            $dat['name'] = $this->getRequest()->getPost('name');
            $dat['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $dat['cost'] = $this->getRequest()->getPost('cost');
            $dat['prod_status'] = $this->getRequest()->getPost('prod_status');
            $dat['item_type'] = $this->getRequest()->getPost('item_type');
            $dat['hotel_id'] = $this->getRequest()->getPost('hotels');
            $dat['category_id'] = $this->getRequest()->getPost('category');
            $dat['agent_id'] = $agent_id;
          
            $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=addproductdetails';
            $curlResponse = $objCurlHandler->curlUsingPost($url,$dat);
           
            if ($curlResponse->code == 200) {
                
            $coverphoto = $_FILES["fileToUpload"]["name"];
            $product_id = $curlResponse->data['product_id'];
            $dirpath = getcwd()."/themes/agent/skin/productimages/$product_id/";
              if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
                 }
            if (!empty($coverphoto)) {
               $imagepath = $dirpath.$coverphoto;
               $savepath = "/themes/agent/skin/productimages/$product_id/$coverphoto";
               $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
               $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$imagepath));      
                    if ($imagemoveResult) {
                    $dt['imagelink'] = $savepath;
                    $dt['product_id'] = $product_id;
                   
                    $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=updateproductdetails';
                    $curlResponse = $objCurlHandler->curlUsingPost($url,$dt);
                    
                    if ($curlResponse->code == 200) {
                        $this->redirect('/agent-product-details');
                    }
           }
    }
              }
                }
            }
        }  
    
}