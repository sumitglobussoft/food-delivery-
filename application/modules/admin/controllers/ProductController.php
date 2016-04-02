<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_ProductController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * Modified code
     * Dev: priyanka varanasi
     * 
     */

    public function productDetailsAction() {

        $productsModel = Admin_Model_Products::getInstance();
        $hotelModel = Admin_Model_HotelDetails::getInstance();
        $hoteldetails = $hotelModel->selectAllHotels();

        if ($hoteldetails) {
            $this->view->hotelslist = $hoteldetails;
        }
        $result = $productsModel->getProductsdetails();
        if ($result) {
            $this->view->productdetails = $result;
        } else {
            echo 'controller error occured';
        }

        if ($this->_request->isPost()) {
            $hotelId = $this->getRequest()->getPost('hotelname');
            if ($hotelId) {
                $res = $productsModel->getProductsByHotelId($hotelId);
                if ($res) {
                    $this->view->productsbyhotels = $res;
                } else {
                    $this->view->productdetails = $result;
                }
            } else {
                $this->view->productdetails = $result;
            }
        }
    }

    /*
     * Modified code
     * Dev: priyanka varanasi
     * 
     */
    /*
     * Modified code
     * Dev: sowmya
     * date: 28 march 2016
     */

    public function editProductDetailsAction() {

        $productsModel = Admin_Model_Products::getInstance();
        $productId = $this->getRequest()->getParam("productId");
        $objcuisines = Admin_Model_FamousCuisines::getInstance();
        $cuisinesdDetails = $objcuisines->getCuisines();
        if ($cuisinesdDetails) {
            $this->view->cuisineslist = $cuisinesdDetails;
        }
        $objcategory = Admin_Model_MenuCategory::getInstance();
        $categoryDetails = $objcategory->selectAllCategorys();
        if ($categoryDetails) {
            $this->view->categorylist = $categoryDetails;
        }
        if ($this->_request->isPost()) {

            $productId = $this->getRequest()->getParam("productId");
            $productdata['name'] = $this->getRequest()->getPost('name');
            $productdata['item_type'] = $this->getRequest()->getPost('item_type');
            $productdatatype = $this->getRequest()->getPost('product_type');
            $productdatatype1 = $this->getRequest()->getPost('product_type1');
            $productdata['prod_type'] = $productdatatype . "," . $productdatatype1 . "";
            $str_explode = explode(",", $productdata['prod_type']);
            $string1['category'] = $str_explode[0];
            $string2['cuisine'] = $str_explode[1];

//            $objcuisines = Admin_Model_FamousCuisines::getInstance();
//            $result =$objcuisines->getcusinesById($string2['cuisine']);
//             $abc =$result[0]['Cuisine_name'];
//            $productdata1['Cuisine_name'] = $abc; 

            $productdata['category_id'] = $this->getRequest()->getPost('category_id');
            $productdata['cuisine_id'] = $this->getRequest()->getPost('cusine_id');
            $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $productdata['cost'] = $this->getRequest()->getPost('cost');
            $productdata['prod_status'] = $this->getRequest()->getPost('prod_status');
            $productdata['delivery_time'] = $this->getRequest()->getPost('delivery_time');
            $productdata['product_discount'] = $this->getRequest()->getPost('product_discount');
            $productdata['product_discount_type'] = $this->getRequest()->getPost('product_discount_type');
            $productdata['servicetax'] = $this->getRequest()->getPost('servicetax');
            $coverphoto = $_FILES["fileToUpload"]["name"];

            $dirpath = getcwd() . "/assets/productimages/$productId/";
            if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
            }
            if (!empty($coverphoto)) {
                $imagepath = $dirpath . $coverphoto;
                $savepath = "/assets/productimages/$productId/$coverphoto";
                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                    if ($imagemoveResult) {
                        $link = $this->_appSetting->hostLink;
                        $productdata['imagelink'] = $link . $savepath;
                        $result3 = $productsModel->updateProductsdetails($productId, $productdata);
                        if ($result3) {
                            $this->redirect('/admin/product-details');
                        } else {
                            $this->view->errormessage = 'Product image not updated ';
                        }
                    } else {
                        $result3 = $productsModel->updateProductsdetails($productId, $productdata);
                    }
                }
            } else {
                $result3 = $productsModel->updateProductsdetails($productId, $productdata);
            }
        }
        $result = $productsModel->getAllProductdetails($productId);
        if ($result) {
            $this->view->allproductdetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * Modified code
     * Dev: priyanka varanasi
     * 
     */
    /*
     * Modified code
     * Dev: sowmya
     * date: 18 march 2016
     */

    public function addProductDetailsAction() {

        $productsModel = Admin_Model_Products::getInstance();
        $agentModel = Admin_Model_Agents::getInstance();
        $agentdetails = $agentModel->getAgentsDetails();
        if ($agentdetails) {
            $this->view->agentlist = $agentdetails;
        }
        if ($this->_request->isPost()) {

            $productdata['agent_id'] = $this->getRequest()->getPost('agent_id');
            $productdata['hotel_id'] = $this->getRequest()->getPost('hotel_id');
            $productdata['item_type'] = $this->getRequest()->getPost('item_type');
            $productdatatype = $this->getRequest()->getPost('product_type');
            $productdatatype1 = $this->getRequest()->getPost('product_type1');
            $productdata['prod_type'] = $productdatatype . "," . $productdatatype1 . "";
            $productdata['category_id'] = $this->getRequest()->getPost('category_id');
            $productdata['cuisine_id'] = $this->getRequest()->getPost('cusine_id');
            $productdata['name'] = $this->getRequest()->getPost('name');
            $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc');
            $productdata['imagelink'] = $this->getRequest()->getPost('imagelink');
            $productdata['cost'] = $this->getRequest()->getPost('cost');
            $productdata['product_discount'] = $this->getRequest()->getPost('product_discount');
            $productdata['product_discount_type'] = $this->getRequest()->getPost('product_discount_type');
            $productdata['delivery_time'] = $this->getRequest()->getPost('delivery_time');
            $productdata['prod_status'] = $this->getRequest()->getPost('prod_status');
            $productdata['servicetax'] = $this->getRequest()->getPost('servicetax');

            if ($productdata) {
                $productId = $productsModel->addProductsdetails($productdata);

                if ($productId) {
                    $coverphoto = $_FILES["fileToUpload"]["name"];
                    $dirpath = getcwd() . "/assets/productimages/$productId/";
                    if (!file_exists($dirpath)) {
                        mkdir($dirpath, 0777, true);
                    }
                    if (!empty($coverphoto)) {
                        $imagepath = $dirpath . $coverphoto;
                        $savepath = "/assets/productimages/$productId/$coverphoto";
                        $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                        $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                        if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                            echo json_encode("Something went wrong image upload");
                        } else {
                            $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                            if ($imagemoveResult) {
                                $link = $this->_appSetting->hostLink;
                                $product['imagelink'] = $link . $savepath;
                                $result3 = $productsModel->updateProductsdetails($productId, $product);
                                if ($result3) {
                                    $this->redirect('/admin/product-details');
                                } else {
                                    $this->view->errormessage = 'Product image not updated ';
                                }
                            } else {
                                $this->view->errormessage = 'Product image not updated ';
                            }
                        }
                    } else {
                        $this->redirect('/admin/product-details');
                    }
                }
            }
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: product ajax handler
     * date : 13/1/2015;
     */

    public function productAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $productsModel = Admin_Model_Products::getInstance();
        $hotelModel = Admin_Model_HotelDetails::getInstance();
        $catModel = Admin_Model_MenuCategory::getInstance();
        $CuisinesModel = Admin_Model_FamousCuisines::getInstance();

        if ($this->getRequest()->isPost()) {
            $method = $this->getRequest()->getParam('method');

            switch ($method) {
                case 'productstatuschange':
                    $productid = $this->getRequest()->getParam('productid');
                    $result = $productsModel->changeProductStatus($productid);
                    if ($result) {
                        echo $productid;
                        die();
                    } else {
                        echo "error";
                    }
                    break;
                case 'productdelete':
                    $productid = $this->getRequest()->getParam('productid');
                    $result = $productsModel->productDelete($productid);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;


                case 'getcuisines':
                    $val = $this->getRequest()->getParam('typevalue');
                    if ($val == 2) {
                        $result = $CuisinesModel->getCuisines();
                        if ($result) {
                            $arr['code'] = 200;
                            $arr['data'] = $result;
                            echo json_encode($arr, true);
                        } else {
                            $arr['code'] = 197;
                            $arr['data'] = null;
                            echo json_encode($arr, true);
                        }
                    } else {
                        $arr['code'] = 198;
                        $arr['message'] = 'param not passed';
                        echo json_encode($arr, true);
                    }

                    break;

                case 'getcategories':
                    $val = $this->getRequest()->getParam('typevalue');
                    if ($val == 1) {
                        $result = $catModel->selectAllCategorys();
                        if ($result) {
                            $arr['code'] = 200;
                            $arr['data'] = $result;
                            echo json_encode($arr, true);
                            die();
                        } else {
                            $arr['code'] = 197;
                            $arr['data'] = null;
                            echo json_encode($arr, true);
                            die();
                        }
                    } else {
                        $arr['code'] = 198;
                        $arr['message'] = 'param not passed';
                        echo json_encode($arr, true);
                        die();
                    }

                    break;
                case 'hotelsbasedonagent':
                    $hotelid = $this->getRequest()->getParam('hotel_id');
                    $result = $hotelModel->getAllHotelsBasedOnAgent($hotelid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                    } else {
                        $arr['code'] = 197;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                    }
                    break;
            }
        }
    }

}
