<?php

/**
 * AgentController
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
     * Desc : To fetch all hotel  product details
     */

    public function productDetailsAction() {



        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/getproducts?method=getagentproducts';
        $data['agent_id'] = $agent_id;
        $curlResponse1 = $objCurlHandler->curlUsingPost($url, $data);

        $proddetails = '';
        if ($curlResponse1->code == 200) {
            $proddetails = $curlResponse1->data;
            $this->view->productdetails = $proddetails;
        }

        $url = $this->_appSetting->apiLink . '/hoteldetails?method=getHotelDetailsByAgentId';
        $curlResponse2 = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse2->code == 200) {

            $this->view->hotelslist = $curlResponse2->data;
        }

        if ($this->_request->isPost()) {
            $hotelId = $this->getRequest()->getPost('hotelname');
            if ($hotelId) {
                $url = $this->_appSetting->apiLink . '/getproducts?method=getProductsByHotelId';
                $data['hotel_id'] = $hotelId;
                $curlResponse3 = $objCurlHandler->curlUsingPost($url, $data);

                if ($curlResponse3->code == 200) {
                    $this->view->productdetailsbyhotels = $curlResponse3->data;
                } else {
                    $this->view->productdetails = $proddetails;
                }
            } else {
                $this->view->productdetails = $proddetails;
            }
        }
    }

    /*
     * Dev : sowmya
     * Date: 6/6/2016
     * Desc : To edit and update the product details
     */

    public function editProductDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $product_id = $this->getRequest()->getParam('prod_id');
        if ($this->getRequest()->isPost()) {
            $productdata['name'] = $this->getRequest()->getPost('name');
            $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $productdata['cost'] = $this->getRequest()->getPost('cost');
            $productdata['prod_status'] = $this->getRequest()->getPost('prod_status');
            $productdata['delivery_time'] = $this->getRequest()->getPost('delivery_time');
            $productdata['product_discount'] = $this->getRequest()->getPost('product_discount');
            $productdata['product_discount_type'] = $this->getRequest()->getPost('product_discount_type');
            $productdata['prod_type'] = $this->getRequest()->getPost('prod_type');
            $productdata['item_type'] = 1;
            $productdata['stock_quantity'] = $this->getRequest()->getPost('stock_quantity');
            $productdata['prod_type'] = $this->getRequest()->getPost('prod_type');
            if ($productdata['prod_type'] == 1) {
                $productdata['category_id'] = $this->getRequest()->getPost('category_id');
                $productdata['Subcategory_id'] = $this->getRequest()->getPost('Subcategory_id');
            } else if ($productdata['prod_type'] == 2) {
                $productdata['cuisine_id'] = $this->getRequest()->getPost('cuisine_id');
            }

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
        $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=GetCategorys';
        $curlResponse1 = $objCurlHandler->curlUsingGet($url);

        if ($curlResponse1->code == 200) {

            $this->view->GetCategorys = $curlResponse1->data;
        }
        $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getcuisinesofHotel';
        $data1['hotel_id'] = $curlResponse->data['hotel_id'];

        $curlResponse2 = $objCurlHandler->curlUsingPost($url, $data1);
        if ($curlResponse2->code == 200) {

            $this->view->GetCuisines = $curlResponse2->data;
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

        if ($curlResponse->code == 200) {
            $this->view->hotellist = $curlResponse->data;
        }
        $url1 = $this->_appSetting->apiLink . '/storedetails?method=getStoreDetailsByAgentId';
        $data1['agent_id'] = $agent_id;
        $curlResponse1 = $objCurlHandler->curlUsingPost($url1, $data1);

        if ($curlResponse1->code == 200) {
            $this->view->storelist = $curlResponse1->data;
        }
        $url2 = $this->_appSetting->apiLink . '/storedetails?method=storeCategory';

        $curlResponse2 = $objCurlHandler->curlUsingGet($url2);

        if ($curlResponse2->code == 200) {
            $this->view->storecategorylist = $curlResponse2->data;
        }
        if ($this->getRequest()->isPost()) {
            $productdata['name'] = $this->getRequest()->getPost('name');
            $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $productdata['cost'] = $this->getRequest()->getPost('cost');
            $productdata['prod_status'] = $this->getRequest()->getPost('prod_status');
            $productdata['delivery_time'] = $this->getRequest()->getPost('delivery_time');
            $productdata['product_discount'] = $this->getRequest()->getPost('product_discount');
            $productdata['product_discount_type'] = $this->getRequest()->getPost('product_discount_type');
            $productdata['prod_type'] = $this->getRequest()->getPost('prod_type');
            $productdata['item_type'] = $this->getRequest()->getPost('item_type');
            $productdata['stock_quantity'] = $this->getRequest()->getPost('stock_quantity');
            $productdata['agent_id'] = $agent_id;
            if ($productdata['item_type'] == 1) {
                $productdata['hotel_id'] = $this->getRequest()->getPost('hotel_id');
                $productdata['prod_type'] = $this->getRequest()->getPost('prod_type');
                if ($productdata['prod_type'] == 1) {
                    $productdata['category_id'] = $this->getRequest()->getPost('category_id');
                    $productdata['Subcategory_id'] = $this->getRequest()->getPost('Subcategory_id');
                } else if ($productdata['prod_type'] == 2) {
                    $productdata['cuisine_id'] = $this->getRequest()->getPost('cuisine_id');
                }
            } else if ($productdata['item_type'] == 2) {
                $productdata['store_id'] = $this->getRequest()->getPost('store_id');
                $productdata['store_category_id'] = $this->getRequest()->getPost('store_category_id');
            }

            $productdata['servicetax'] = $this->getRequest()->getPost('servicetax');
//            echo'<pre>';print_r($productdata);die;
            if ($productdata) {

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
                                } else {
                                    $this->view->errormessage = 'Product image not uploaded ';
                                }
                            } else {
                                $this->view->errormessage = 'Product image not updated ';
                            }
                        }
                    } else {
                        $this->view->errormessage = 'Product image not updated ';
                    }
                } else {
                    $this->view->errormessage = 'Product details are not updated ';
                }
            }
        }
    }

    /*
     * Dev : sowmya
     * Date: 11/4/2016
     * Desc : To view  all the product details
     */

    public function viewProductDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
//        $agent_id = $this->view->session->storage->agent_id;
        $product_id = $this->getRequest()->getParam('prod_id');

        $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getproductbyproductId';
        $data['product_id'] = $product_id;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
        if ($curlResponse->code == 200) {

            $this->view->editproductdetails = $curlResponse->data;
        }
    }

    /*
     * Dev : sowmya
     * Date: 6/5/2016
     * Desc : To fetch all store  product details
     */

    public function storeProductDetailsAction() {



        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $agent_id = $this->view->session->storage->agent_id;

        $url = $this->_appSetting->apiLink . '/getproducts?method=getagentstoreproducts';
        $data['agent_id'] = $agent_id;
        $curlResponse1 = $objCurlHandler->curlUsingPost($url, $data);

        $proddetails = '';
        if ($curlResponse1->code == 200) {
            $proddetails = $curlResponse1->data;
            $this->view->productdetails = $proddetails;
        }

        $url = $this->_appSetting->apiLink . '/storedetails?method=getStoreDetailsByAgentId';
        $curlResponse2 = $objCurlHandler->curlUsingPost($url, $data);

        if ($curlResponse2->code == 200) {

            $this->view->storelist = $curlResponse2->data;
        }

        if ($this->_request->isPost()) {
            $store_id = $this->getRequest()->getPost('storename');
            if ($store_id) {
                $url = $this->_appSetting->apiLink . '/getproducts?method=getProductsByStoreId';
                $data['store_id'] = $store_id;
                $curlResponse3 = $objCurlHandler->curlUsingPost($url, $data);

                if ($curlResponse3->code == 200) {
                    $this->view->productdetailsbyhotels = $curlResponse3->data;
                } else {
                    $this->view->productdetails = $proddetails;
                }
            } else {
                $this->view->productdetails = $proddetails;
            }
        }
    }

    /*
     * Dev : sowmya
     * Date: 6/6/2016
     * Desc : To edit and update the store product details 
     */

    public function editStoreProductDetailsAction() {

        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
        $objCore = Engine_Core_Core::getInstance();
        $objSecurity = Engine_Vault_Security::getInstance();
        $this->_appSetting = $objCore->getAppSetting();
        $product_id = $this->getRequest()->getParam('prod_id');
        if ($this->getRequest()->isPost()) {
            $productdata['name'] = $this->getRequest()->getPost('name');
            $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $productdata['cost'] = $this->getRequest()->getPost('cost');
            $productdata['prod_status'] = $this->getRequest()->getPost('prod_status');
            $productdata['delivery_time'] = $this->getRequest()->getPost('delivery_time');
            $productdata['product_discount'] = $this->getRequest()->getPost('product_discount');
            $productdata['product_discount_type'] = $this->getRequest()->getPost('product_discount_type');
            $productdata['prod_type'] = $this->getRequest()->getPost('prod_type');
            $productdata['item_type'] = 2;
            $productdata['stock_quantity'] = $this->getRequest()->getPost('stock_quantity');
            $productdata['store_category_id'] = $this->getRequest()->getPost('store_category_id');

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
        $url = $this->_appSetting->apiLink . '/restaurent-menu-card?method=getstoreproductbyproductId';
        $data['product_id'] = $product_id;
        $curlResponse2 = $objCurlHandler->curlUsingPost($url, $data);
        if ($curlResponse2->code == 200) {

            $this->view->storeproductdetails = $curlResponse2->data;
        }

      
        $url2 = $this->_appSetting->apiLink . '/storedetails?method=storeCategory';

        $curlResponse5 = $objCurlHandler->curlUsingGet($url2);

        if ($curlResponse5->code == 200) {
            $this->view->storecategorylist = $curlResponse5->data;
        }
    }

}
