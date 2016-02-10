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

    public function productDetailsAction() {



        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/getproducts?method=getagentproducts';
        $data['agent_id'] = $agent_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
         $proddetails='';
        if ($curlResponse->code == 200) {
         $proddetails =  $curlResponse->data;
            $this->view->productdetails = $proddetails;
        }

        $url = $this->_appSetting->apiLink . '/hoteldetails?method=getHotelDetailsByAgentId';
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
        if ($curlResponse->code == 200) {

            $this->view->hotelslist = $curlResponse->data;
        }

        if ($this->_request->isPost()) {
            $hotelId = $this->getRequest()->getPost('hotelname');
            if ($hotelId) {
                $url = $this->_appSetting->apiLink . '/getproducts?method=getProductsByHotelId';
                $data['hotel_id'] = $hotelId;
                $curlResponse = $objCurlHandler->curlUsingPost($url, $data);

                if ($curlResponse->code == 200) {
                    $this->view->productdetailsbyhotels = $curlResponse->data;
                } else {
                    $this->view->productdetails = $proddetails;
                }
            } else {
                $this->view->productdetails = $proddetails;
            }
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


            
            $productdata['name'] = $this->getRequest()->getPost('name');
            $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $productdata['cost'] = $this->getRequest()->getPost('cost');
            $productdata['prod_status'] = $this->getRequest()->getPost('prod_status');
            $productdata['delivery_time'] = $this->getRequest()->getPost('delivery_time');
            $productdata['product_discount'] = $this->getRequest()->getPost('product_discount');
            $productdata['product_discount_type'] = $this->getRequest()->getPost('product_discount_type');
            $productdata['servicetax'] = $this->getRequest()->getPost('servicetax');
            $productdata['product_id'] = $product_id;
            $coverphoto = $_FILES["fileToUpload"]["name"];
            
            $dirpath = getcwd() . "/themes/agent/skin/productimages/$product_id/";

            if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
            }
            if (!empty($coverphoto)) {
                $imagepath = $dirpath . $coverphoto;
                $savepath = "/themes/agent/skin/productimages/$product_id/$coverphoto";
                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                    if ($imagemoveResult) {
                       
                        $link = $this->_appSetting->hostLink;
                        $productdata['imagelink'] = $link . $savepath;
                        $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=updateproductdetails';
                       
                        $curlResponse = $objCurlHandler->curlUsingPost($url, $productdata);
 
                        if ($curlResponse->code == 200) {
                            $this->redirect('/agent/product-details');
                        }
                    } else {

                        echo "DIE HERE";
                        die;
                    }
                }
            } else {
                $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=updateproductdetails';
                $curlResponse = $objCurlHandler->curlUsingPost($url, $productdata);

                if ($curlResponse->code == 200) {
                    $this->redirect('/agent/product-details');
                }
            }
        }
        $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getproductbyproductId';
        $data['product_id'] = $product_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
  
        if ($curlResponse->code == 200) {

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
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
        if($curlResponse->code==200){
            $this->view->hotellist =$curlResponse->data; 
            
        }
        if ($this->getRequest()->isPost()) {
            $productdata['name'] = $this->getRequest()->getPost('name');
            $productdata['hotel_id'] = $this->getRequest()->getPost('hotel_id');
            $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $productdata['cost'] = $this->getRequest()->getPost('cost');
            $productdata['prod_status'] = $this->getRequest()->getPost('prod_status');
            $productdata['delivery_time'] = $this->getRequest()->getPost('delivery_time');
            $productdata['product_discount'] = $this->getRequest()->getPost('product_discount');
            $productdata['product_discount_type'] = $this->getRequest()->getPost('product_discount_type');
            $productdata['prod_type'] = $this->getRequest()->getPost('product_type');
            $productdata['item_type'] = 1;
            $productdata['agent_id'] = $agent_id;
            
            if ($productdata['prod_type'] == 1) {
                $productdata['category_id'] = $this->getRequest()->getPost('category_id');
            } else if ($productdata['prod_type'] == 2) {
                $productdata['cuisine_id'] = $this->getRequest()->getPost('cuisine_id');
            } else {
                $productdata['prod_type'] = 0;
                $productdata['category_id'] = 0;
                $productdata['cuisine_id'] = 0;
            }
            $productdata['servicetax'] = $this->getRequest()->getPost('servicetax');
             if($productdata){
           
            $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=addproductdetails';
            $curlResponse = $objCurlHandler->curlUsingPost($url, $productdata);
         if ($curlResponse->code == 200) {

                $coverphoto = $_FILES["fileToUpload"]["name"];
                $product_id = $curlResponse->data['product_id'];
                $dirpath = getcwd() . "/themes/agent/skin/productimages/$product_id/";
                if (!file_exists($dirpath)) {
                    mkdir($dirpath, 0777, true);
                }
                if (!empty($coverphoto)) {
                    $imagepath = $dirpath . $coverphoto;
                    $savepath = "/themes/agent/skin/productimages/$product_id/$coverphoto";
                    $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                    $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                    if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                        echo json_encode("Something went wrong image upload");
                    } else {
                        $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                        if ($imagemoveResult) {
                            $link = $this->_appSetting->hostLink;
                            $dt['imagelink'] = $link . $savepath;
                            $dt['product_id'] = $product_id;

                            $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=updateproductdetails';
                            $curlResponse = $objCurlHandler->curlUsingPost($url, $dt);

                            if ($curlResponse->code == 200) {
                                $this->redirect('/agent/product-details');
                            }else{
                                  $this->view->errormessage = 'Product image not uploaded ';
                            }
                        }else{
                              $this->view->errormessage = 'Product image not updated ';
                            
                        }
                        }
                    }else{
                          $this->view->errormessage = 'Product image not updated ';
                    }
                }else{
                     $this->view->errormessage = 'Product details are not updated ';
                }
            }
        }
    }


}
