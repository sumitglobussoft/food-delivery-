<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class OrderController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }
     /*
   * Dev : Priyanka Varanasi
   * Date: 3/12/2015
   * Desc: User delivery address settings insert and update
   */
 public function userDeliverySettingsAction(){
        $userdeliveryaddrmodal = Application_Model_UserDeliveryAddr::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
       if($method){  
        switch ($method) {
       
   case'insertdeliveryaddress':
      
      if ($this->getRequest()->isPost()) {
          
        $data['user_id'] = $this->getRequest()->getPost('userid');
        $data['city'] = $this->getRequest()->getPost('city');
        $data['state'] = $this->getRequest()->getPost('state');
        $data['country'] = $this->getRequest()->getPost('country');
        $data['landmark'] = $this->getRequest()->getPost('landmark');
        $data['delivery_addr'] = $this->getRequest()->getPost('address');
        $data['order_id'] = $this->getRequest()->getPost('order_id');
        $data['delivery_time'] = $this->getRequest()->getPost('deliverytime');
        if([$data['user_id']]){
          
         $userdelid = $userdeliveryaddrmodal->insertUserDeliveryAddress($data); 
        if($userdelid){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $userdelid;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
         }else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = NUll;
        } 
      }else{
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = NULL;
            
       }
        echo json_encode($response,true);
           die();  
       break;
       
       
    case'updatedeliveryaddress': 
              
      if ($this->getRequest()->isPost()) {
       
          
        $landmark = $this->getRequest()->getPost('landmark');
        if(!empty($landmark)){
             $data['landmark'] = $landmark;
           }
         
            $orderid  = $this->getRequest()->getPost('order_id');
        if(!empty($orderid)){
             $data['order_id'] = $orderid; 
           }

              $deliverytime  = $this->getRequest()->getPost('deliverytime');
        if(!empty($deliverytime)){
             $data['delivery_time'] = $deliverytime; 
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
             $data['delivery_addr'] = $address;
           }
         $addressid= $this->getRequest()->getPost('addressid');
         $userid = $this->getRequest()->getPost('userid');
           if($userid && $addressid){
            $update  = $userdeliveryaddrmodal->updateUserDeliveryAddress($userid,$addressid,$data);
              if ($update) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data = $update;
                    
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
  
   /*
   * Dev : Priyanka Varanasi
   * Date: 10/12/2015
   * Desc: fetch all products from db
   */
   public function productsSummaryAction(){
        $productsummaryModel = Application_Model_Products::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
       if($method){  
     
        switch ($method) {
       
   case'allproducts':
      
         $productdetails = $productsummaryModel->selectAllProducts(); 
        if($productdetails){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $productdetails;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
      
        echo json_encode($response,true);
           die();  
       break;
       
        case'getagentproducts':
      
    if ($this->getRequest()->isPost()) {
         
        $agent_id = $this->getRequest()->getPost('agent_id');
       
        if($agent_id){
            $agentproducts  = $productsummaryModel->getALLAgentProducts($agent_id);
              if ($agentproducts) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data = $agentproducts;
                    
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
        
          
       case'changeproductstatus':
      if ($this->getRequest()->isPost()) {
     
        $product_id = $this->getRequest()->getPost('product_id');
      
        if($product_id){
            $updatestatus = $productsummaryModel->getstatusChangeOfProduct($product_id);
              if ($updatestatus) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data['product_id'] = $product_id;
                    
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
     
      case'productdelete':
      if ($this->getRequest()->isPost()) {
     
        $product_id = $this->getRequest()->getPost('product_id');
      
        if($product_id){
            $updatestatus = $productsummaryModel->productDelete($product_id);
             
              if ($updatestatus) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data['product_id'] = $product_id;
                    
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
            $response->data = "No Method Passed";
         echo json_encode($response,true);
           die(); 
           }
    }
    
    
    /*
   * Dev : Priyanka Varanasi
   * Date: 10/12/2015
   * Desc: Insert all orders in db
   */   
   public function ordersAction(){
        $ordersModel = Application_Model_Orders::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
       if($method){  
     
        switch ($method) {
       
   case'insertorders':
      
    if ($this->getRequest()->isPost()) {
         
        $data['user_id'] = $this->getRequest()->getPost('userid');
        $data['total_amount'] = $this->getRequest()->getPost('totalamount');
        $data['delivery_charge'] = $this->getRequest()->getPost('deliverycharge');
        $data['service_tax'] = $this->getRequest()->getPost('servicetax');
        $data['pay_type'] = $this->getRequest()->getPost('paytype');
        $data['pay_status'] = $this->getRequest()->getPost('paystatus');
        $data['order_status'] = $this->getRequest()->getPost('orderstatus');
        $data['order_date'] = date('Y-m-d H-i-s');
        if($data['user_id']){
            $insertedorderid  = $ordersModel->insertOrders($data);
              if ($insertedorderid) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data['order_id'] = $insertedorderid;
                    
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
            $response->data = "No Method Passed";
         echo json_encode($response,true);
           die(); 
           }
    }
   
    
     /*
   * Dev : Priyanka Varanasi
   * Date: 10/12/2015
   * Desc: fetch all hotel details from db
   */
   public function hotelsSummaryAction(){
        $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
        $deliverystatusmodal   = Application_Model_DeliveryStatusLog::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
       if($method){  
     
     switch ($method) {
       
   case'allhotels':
      
         $hoteldetails = $hotelssummaryModel->selectAllHotels(); 
        if($hoteldetails){
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $hoteldetails;
         }else{
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
           }
      
        echo json_encode($response,true);
           die();  
       break;
       
       
  case'getorderstatus':
      if ($this->getRequest()->isPost()) {
     
        $order_id = $this->getRequest()->getPost('order_id');
       
        if($order_id){
            $statusdetails  = $deliverystatusmodal->getOrderStatus($order_id);
              if ($statusdetails) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data = $statusdetails;
                    
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
     
            
  case'getHotelDetailsByAgentId':
      if ($this->getRequest()->isPost()) {
     
        $agent_id = $this->getRequest()->getPost('agent_id');
      
        if($agent_id){
            $agenthoteldetails  = $hotelssummaryModel->getHoteldetails($agent_id);
              if ($agenthoteldetails) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data = $agenthoteldetails;
                    
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
     
       case'changehotelstatus':
      if ($this->getRequest()->isPost()) {
     
        $hotel_id = $this->getRequest()->getPost('hotel_id');
      
        if($hotel_id){
            $updatestatus = $hotelssummaryModel->getstatusChangeOfHotel($hotel_id);
              if ($updatestatus) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data['hotel_id'] = $hotel_id;
                    
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
     
      case'hoteldelete':
      if ($this->getRequest()->isPost()) {
     
        $hotel_id = $this->getRequest()->getPost('hotel_id');
      
        if($hotel_id){
            $updatestatus = $hotelssummaryModel->hotelDelete($hotel_id);
             
              if ($updatestatus) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data['hotel_id'] = $hotel_id;
                    
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
      case'getHotelDetailsByHotelId':
      if ($this->getRequest()->isPost()) {
     
        $hotel_id = $this->getRequest()->getPost('hotel_id');
      
        if($hotel_id){
            $hoteldetails  = $hotelssummaryModel->getHoteldetailsByHotelId($hotel_id);
              if ($hoteldetails) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data = $hoteldetails;
                    
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
     
       case'updatehoteldetails':
      if ($this->getRequest()->isPost()) {
     
        
            $hotel_id = $this->getRequest()->getPost('id');
              if(!empty($this->getRequest()->getPost('owner_fname'))){
            $data['owner_fname']= $this->getRequest()->getPost('owner_fname');
            }
               if(!empty($this->getRequest()->getPost('owner_lname'))){
            $data['owner_lname']= $this->getRequest()->getPost('owner_lname');
            }
                if(!empty($this->getRequest()->getPost('city'))){
            $data['city']= $this->getRequest()->getPost('city');
            }
                if(!empty($this->getRequest()->getPost('state'))){
            $data['state']= $this->getRequest()->getPost('state');
            }
                if(!empty($this->getRequest()->getPost('country'))){
            $data['country']= $this->getRequest()->getPost('country');
            }
                if(!empty($this->getRequest()->getPost('primary_phone'))){
            $data['primary_phone']= $this->getRequest()->getPost('primary_phone');
            }
                if(!empty($this->getRequest()->getPost('secondary_phone'))){
            $data['secondary_phone']= $this->getRequest()->getPost('secondary_phone');
            }
                if(!empty($this->getRequest()->getPost('hotel_name'))){
            $data['hotel_name']= $this->getRequest()->getPost('hotel_name');
            }
                if(!empty($this->getRequest()->getPost('open_time'))){
            $data['open_time']= $this->getRequest()->getPost('open_time');
            }
                if(!empty($this->getRequest()->getPost('hotel_status'))){
            $data['hotel_status']= $this->getRequest()->getPost('hotel_status');
            }
                if(!empty($this->getRequest()->getPost('closing_time'))){
            $data['closing_time']= $this->getRequest()->getPost('closing_time');
            }
                if(!empty($this->getRequest()->getPost('notice'))){
            $data['notice']= $this->getRequest()->getPost('notice');
            }
           if(!empty($this->getRequest()->getPost('hotel_image'))){
            $data['hotel_image']= $this->getRequest()->getPost('hotel_image');
            }
        if($hotel_id){
            $updatestatus  = $hotelssummaryModel->updateHotelDetails($hotel_id,$data);
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
     
   case'addhoteldetails':
          if ($this->getRequest()->isPost()) {
            $data['agent_id']= $this->getRequest()->getPost('agent_id');
            $data['owner_fname']= $this->getRequest()->getPost('owner_fname');
            $data['owner_lname']= $this->getRequest()->getPost('owner_lname');
            $data['city']= $this->getRequest()->getPost('city'); 
            $data['state']= $this->getRequest()->getPost('state');
            $data['country']= $this->getRequest()->getPost('country');
            $data['primary_phone']= $this->getRequest()->getPost('primary_phone');
            $data['secondary_phone']= $this->getRequest()->getPost('secondary_phone');
            $data['hotel_name']= $this->getRequest()->getPost('hotel_name');
            $data['open_time']= $this->getRequest()->getPost('open_time');
            $data['closing_time']= $this->getRequest()->getPost('closing_time');
            $data['closing_time']= $this->getRequest()->getPost('closing_time');
            $data['hotel_status']= $this->getRequest()->getPost('hotel_status');
            $data['notice']= $this->getRequest()->getPost('notice');
          if($data['agent_id']){
            $updatestatus  = $hotelssummaryModel->insertHotelDetails($data);
              if ($updatestatus) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data['hotel_id'] = $updatestatus;
                    
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
            $response->data = "No Method Passed";
         echo json_encode($response,true);
           die(); 
           }
    }
    
    
    
        /*
     * Dev:Sibani Mishra
     * Date:12/01/2016
     * Desc:Insert all orders details in addtocart table
     */

    public function addtoCartSummaryAction() {

        $Addtocart = Application_Model_Addtocart::getInstance();
        $Removeaddtocart = Application_Model_Addtocart::getInstance();
        $Getaddtocart = Application_Model_Addtocart::getInstance();

        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {
            switch ($method) {
                case 'InsertOrdersToCart':
                    if ($this->getRequest()->isPost()) {
                        $data['user_id'] = $this->getRequest()->getPost('userid');
                        $data['product_id'] = $this->getrequest()->getPost('productid');
                        $data['hotel_id'] = $this->getRequest()->getPost('hotelid');
                        $data['quantity'] = $this->getRequest()->getPost('quantity');
                        $data['cost'] = $this->getRequest()->getPost('cost');
             if ($data['user_id'] && $data['hotel_id'] && $data['hotel_id'] ) {
                $productexists = $Addtocart->checkProductifExists($data['user_id'],$data['product_id'],$data['hotel_id']);
                if($productexists){
                    $array = array('product_id'=>$data['product_id'],
                                   'hotel_id'=>$data['hotel_id']);
                             $response->message = 'Product Already Exists';
                                $response->code = 198;
                                $response->data =$array;
                          }else{
                            $insertedorderidtoCart = $Addtocart->insertOrderstoCart($data);


                            if ($insertedorderidtoCart) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['cart_id'] = $insertedorderidtoCart;
                                echo json_encode($response, true);
                                die();
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } }else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 401;
                            $response->data = NULL;
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = Null;
                    }
                    echo json_encode($response, true);
                    die;
                    break;

                case 'getOrderToCart':

                    if ($this->getRequest()->isPost()) {
                      $user_id = $this->getRequest()->getPost('user_id');
                        if ($user_id) {
                            $getaddtocartdetails = $Getaddtocart->getaddtocart($user_id);

                            if ($getaddtocartdetails) {

                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $getaddtocartdetails;
                                echo json_encode($response, true);
                                die;
                            } else {
                                $response->message = 'Could Not Serve The Request completely';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 197;
                            $response->data = null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;


                case 'RemoveOrderToCart':
                    if ($this->getRequest()->isPost()) {

                        $addtocartSerialNo = $this->getRequest()->getPost('sl_no');

                        if ($addtocartSerialNo) {
                            $removeaddtocartorderid = $Removeaddtocart->RemoveAddtocartorder($addtocartSerialNo);

                            if ($removeaddtocartorderid) {

                                $response->message = 'successfully Deleted';
                                $response->code = 200;
                                $response->data = $removeaddtocartorderid;
                                echo json_encode($response, true);
                                die();
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 401;
                            $response->data = NULL;
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = Null;
                    }
                    echo json_encode($response, true);
                    die;
                    break;
            }
        } else {

            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = "No Method Passed";
            echo json_encode($response, true);
            die();
        }
    }
    
}
?>
