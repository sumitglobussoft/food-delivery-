<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class ProductController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }
    /*
     * Dev :Priyanka Varanasi
     * Desc : To fetch the product details by product id
     * Date : 22/12/2015
     * 
     */
    public function restaurentMenuCardAction(){
     $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
     $deliverystatusmodal   = Application_Model_DeliveryStatusLog::getInstance();  
     $productsummaryModel = Application_Model_Products::getInstance();
     $categorysModel = Application_Model_MenuCategory::getInstance();
     $response = new stdClass();
     $method = $this->getRequest()->getParam('method');
    
       if($method){  
        switch ($method) {
      
    case'GetMenu':
        
    if ($this->getRequest()->isPost()) {
       $hotel_id = $this->getRequest()->getPost('hotel_id');
     if($hotel_id){
       $cats = $hotelssummaryModel->getcategoriesByHotelId($hotel_id);
       if($cats){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data['categorys'] = $cats;
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
       
   case'getproductbyproductId':
          if ($this->getRequest()->isPost()) {
     
          $product_id = $this->getRequest()->getPost('product_id');
      
        if($product_id){
            $proddetails = $productsummaryModel->getProductByProductId($product_id);
              if ($proddetails) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data = $proddetails;
                    
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 197;
                        $response->data = null;
                      }
             }else{
                     $response->message = 'Could Not Serve The Request';
                     $response->code = 401;
                     $response->data = NULL;
                 
                   }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = Null;
           
        }
         echo json_encode($response,true);
            die;
       
       break;
       
   case'updateproductdetails':
      if ($this->getRequest()->isPost()) {
            $product_id = $this->getRequest()->getPost('product_id');
            
            if(!empty($this->getRequest()->getPost('name'))){
            $data['name']= $this->getRequest()->getPost('name');
            }
            if(!empty($this->getRequest()->getPost('prod_desc'))){
            $data['prod_desc']= $this->getRequest()->getPost('prod_desc');
            }
            if(!empty($this->getRequest()->getPost('cost'))){
            $data['prod_status']= $this->getRequest()->getPost('cost');
            }
           if(!empty($this->getRequest()->getPost('prod_status'))){
            $data['cost']= $this->getRequest()->getPost('prod_status');
            }
            if(!empty($this->getRequest()->getPost('imagelink'))){
            $data['imagelink']= $this->getRequest()->getPost('imagelink');
            }
        if($product_id){
            $updatestatus  = $productsummaryModel->updateProductDetails($product_id,$data);
              if ($updatestatus) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data = $updatestatus;
                    
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 197;
                        $response->data = null;
                      }
             }else{
                     $response->message = 'Could Not Serve The Request';
                     $response->code = 401;
                     $response->data = NULL;
                 
                   }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = Null;
           
        }
         echo json_encode($response,true);
            die;
     
     break;
     
   case'GetCategorys':
       $categorydetails = $categorysModel->selectAllCategorys(); 
       if($categorydetails){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $categorydetails;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
        echo json_encode($response,true);
        die();  
       break;
       
   case'addproductdetails':
      if ($this->getRequest()->isPost()) {
     
            $data['name'] = $this->getRequest()->getPost('name');
            $data['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $data['cost'] = $this->getRequest()->getPost('cost');
            $data['prod_status'] = $this->getRequest()->getPost('prod_status');
            $data['item_type'] = $this->getRequest()->getPost('item_type');
            $data['hotel_id'] = $this->getRequest()->getPost('hotel_id');
            $data['category_id'] = $this->getRequest()->getPost('category_id');
            $data['agent_id'] = $this->getRequest()->getPost('agent_id');
            
            $insertproductid  = $productsummaryModel->AddProductDetails($data);
            
              if ($insertproductid) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data['product_id'] = $insertproductid;
                    
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 197;
                        $response->data = null;
                      }
             }else{
                     $response->message = 'Could Not Serve The Request';
                     $response->code = 401;
                     $response->data = NULL;
             }
         echo json_encode($response,true);
            die;
     
     break;
     
           case'getproductbycategoryId':
          if ($this->getRequest()->isPost()) {
     
          $category_id = $this->getRequest()->getPost('category_id');
  
        if($category_id){
            $proddetails = $productsummaryModel->getProductBycategoryID($category_id);
             
              if ($proddetails) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data['products'] = $proddetails;
                    
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 197;
                        $response->data = null;
                      }
             }else{
                     $response->message = 'Could Not Serve The Request';
                     $response->code = 401;
                     $response->data = NULL;
                 
                   }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = Null;
           
        }
         echo json_encode($response,true);
            die;
       
       break;
         
        }
   }else{
         $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = 'No Method';
      
        echo json_encode($response);
        die();       
       }  
 
    }
    
    public function orderProductsAction(){
     $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
     $deliverystatusmodal   = Application_Model_DeliveryStatusLog::getInstance();  
     $productsummaryModel = Application_Model_Products::getInstance();
     $categorysModel = Application_Model_MenuCategory::getInstance();
     $orderproductsModel = Application_Model_OrderProducts::getInstance();
      $ordersModel = Application_Model_Orders::getInstance();
     $response = new stdClass();
      if ($this->getRequest()->isPost()) {
          $agent_id = $this->getRequest()->getPost('agent_id');
      }
      $orderproductsdetails = $ordersModel->GetOrderProducts($agent_id); 
       if($orderproductsdetails){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $orderproductsdetails;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
        echo json_encode($response,true);
        die();  
     
        
        
        
    }
    
}

?>