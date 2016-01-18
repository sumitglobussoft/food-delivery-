<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Agent_OrderController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function orderAjaxHandlerAction(){
        $this->_helper->_layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
       $method = $this->getRequest()->getParam('method');
        
        switch($method){
            ////////////////HOTEL ACTIONS //////////////////////////////
          case 'hotelactive':
                
          $hotelid = $this->getRequest()->getParam('hotelid');
          if($hotelid){
          $url = $this->_appSetting->apiLink . '/hoteldetails?method=changehotelstatus';
          $data['hotel_id'] = $hotelid;
          $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
          if($curlResponse->code==200){
              $array['code']= 200;
              $array['data']= $curlResponse->data['hotel_id'];
              echo json_encode($array,true);
              die();
          }else{
              $array['code']= 198;
              $array['data']= null;
              echo json_encode($array,true);
              die();
          }
                }else{
                    
                 $array['code']= 197;
                 $array['data']= null;
                 echo json_encode($array,true);
                 die();
                }
                
                break;
                
          case 'hoteldeactive':
                 
                 $hotelid = $this->getRequest()->getParam('hotelid');
          if($hotelid){
          $url = $this->_appSetting->apiLink . '/hoteldetails?method=changehotelstatus';
          $data['hotel_id'] = $hotelid;
          $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
          if($curlResponse->code==200){
              $array = array('code'=>200,
                             'data'=>$curlResponse->data['hotel_id']);

              echo json_encode($array,true);
               die();
          }else{
                    $array = array('code'=>198,
                             'data'=>null);
              echo json_encode($array,true);
               die();
          }
                }else{
                    
                $array = array('code'=>198,
                             'data'=>null);
                 echo json_encode($array,true);
                  die();
                }
                
                break;
                
          case 'hoteldelete':
          $hotelid = $this->getRequest()->getParam('hotelid');
          if($hotelid){
          $url = $this->_appSetting->apiLink . '/hoteldetails?method=hoteldelete';
          $data['hotel_id'] = $hotelid;
          $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
         
          if($curlResponse->code==200){
              $array = array('code'=>200,
                             'data'=>$curlResponse->data['hotel_id']);
                echo json_encode($array,true);
               die();
                }else{
                    $array = array('code'=>198,
                             'data'=>null);
              echo json_encode($array,true);
               die();
                }
                }else{
                 $array = array('code'=>198,
                             'data'=>null);
                 echo json_encode($array,true);
                  die();
                }
                break;
               
       /////////////////////////////// PRODUCT ACTIONS /////////////////////////////         
                
               case 'productactive':
                
          $productid = $this->getRequest()->getParam('productid');
          if($productid){
          $url = $this->_appSetting->apiLink . '/getproducts?method=changeproductstatus';
          $data['product_id'] = $productid;
          $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
          if($curlResponse->code==200){
              $array['code']= 200;
              $array['data']= $curlResponse->data['product_id'];
              echo json_encode($array,true);
              die();
          }else{
              $array['code']= 198;
              $array['data']= null;
              echo json_encode($array,true);
              die();
          }
                }else{
                    
                 $array['code']= 197;
                 $array['data']= null;
                 echo json_encode($array,true);
                 die();
                }
                
                break;
                
          case 'productdeactive':
                 
           $productid = $this->getRequest()->getParam('productid');
          if($productid){
          $url = $this->_appSetting->apiLink . '/getproducts?method=changeproductstatus';
          $data['product_id'] = $productid;
          $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
          if($curlResponse->code==200){
              $array = array('code'=>200,
                             'data'=>$curlResponse->data['product_id']);

              echo json_encode($array,true);
               die();
          }else{
                    $array = array('code'=>198,
                             'data'=>null);
              echo json_encode($array,true);
               die();
          }
                }else{
                    
                $array = array('code'=>198,
                             'data'=>null);
                 echo json_encode($array,true);
                  die();
                }
                
                break;
                
          case 'productdelete':
          $productid = $this->getRequest()->getParam('productid');
          if($productid){
          $url = $this->_appSetting->apiLink . '/getproducts?method=productdelete';
          $data['product_id'] = $productid;
          $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
         
          if($curlResponse->code==200){
              $array = array('code'=>200,
                             'data'=>$curlResponse->data['product_id']);
                echo json_encode($array,true);
               die();
                }else{
                    $array = array('code'=>198,
                             'data'=>null);
              echo json_encode($array,true);
               die();
                }
                }else{
                 $array = array('code'=>198,
                             'data'=>null);
                 echo json_encode($array,true);
                  die();
                }
                break;  
                
                
                
                
                
                
            default :
                break;
        }
    }
    
    /*
     * Dev: priyanka varanasi 
     * date: 22/12/2015
     * Desc: To work on restauaren orders 
     * 
     */
    public function restuarentOrdersAction(){
        
        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;
          $url = $this->_appSetting->apiLink . '/order-products?method=orderedproductstatus';
          $data['agent_id'] = $agent_id;
          $curlResponse = $objCurlHandler->curlUsingPost($url,$data);
          if($curlResponse->code==200){
             
              $this->view->orderedproducts = $curlResponse->data;
          }
        
        
    }
}
