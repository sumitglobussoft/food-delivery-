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

    public function restaurentMenuCardAction() {
        $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
        $deliverystatusmodal = Application_Model_DeliveryStatusLog::getInstance();
        $productsummaryModel = Application_Model_Products::getInstance();
        $categorysModel = Application_Model_MenuCategory::getInstance();
        $famouscuisinesModel = Application_Model_FamousCuisines::getInstance();
        $hotelcuisinesModel = Application_Model_HotelCuisines::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {
            switch ($method) {

                /*
                 * Modyfied By : Nitin Kumar Gupta
                 * Modyfied Date : 15 FEB 2016
                 */
                case'GetMenu':

                    if ($this->getRequest()->isPost()) {
                        $hotel_id = $this->getRequest()->getPost('hotel_id');
                        if ($hotel_id) {
                            $cats = $hotelssummaryModel->getcategoriesByHotelId($hotel_id);
                            if ($cats) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $cats;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }
                    echo json_encode($response, true);
                    die();

                    break;

                case'getproductbyproductId':
                    if ($this->getRequest()->isPost()) {

                        $product_id = $this->getRequest()->getPost('product_id');

                        if ($product_id) {
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

                case'updateproductdetails':
                    if ($this->getRequest()->isPost()) {
                        $product_id = $this->getRequest()->getPost('product_id');
                        $name = $this->getRequest()->getPost('name');
                        if (!empty($name)) {
                            $data['name'] = $name;
                        }
                        $prod_desc = $this->getRequest()->getPost('prod_desc');
                        if (!empty($prod_desc)) {
                            $data['prod_desc'] = $prod_desc;
                        }
                        $cost = $this->getRequest()->getPost('cost');
                        if (!empty($cost)) {
                            $data['cost'] = $cost;
                        }
                        $prod_status = $this->getRequest()->getPost('prod_status');
                        if (!empty($prod_status)) {
                            $data['prod_status'] = $prod_status;
                        }
                        $imagelink = $this->getRequest()->getPost('imagelink');
                        if (!empty($imagelink)) {
                            $data['imagelink'] = $imagelink;
                        }
                        $delivery_time = $this->getRequest()->getPost('delivery_time');
                        if (!empty($delivery_time)) {
                            $data['delivery_time'] = $delivery_time;
                        }
                        $product_discount = $this->getRequest()->getPost('product_discount');
                        if (!empty($product_discount)) {
                            $data['product_discount'] = $product_discount;
                        }
                        $product_discount_type = $this->getRequest()->getPost('product_discount_type');
                        if (!empty($product_discount_type)) {
                            $data['product_discount_type'] = $product_discount_type;
                        }
                        $servicetax = $this->getRequest()->getPost('servicetax');
                        if (!empty($servicetax)) {
                            $data['servicetax'] = $servicetax;
                        }

                        if ($product_id) {
                            $updatestatus = $productsummaryModel->updateProductDetails($product_id, $data);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $updatestatus;
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

                case'GetCategorys':
                    $categorydetails = $categorysModel->selectAllCategorys();
                    if ($categorydetails) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $categorydetails;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }
                    echo json_encode($response, true);
                    die();
                    break;

                case'addproductdetails':
                    if ($this->getRequest()->isPost()) {
                        $productdata['name'] = $this->getRequest()->getPost('name');
                        $productdata['hotel_id'] = $this->getRequest()->getPost('hotel_id');
                        $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc');
                        $productdata['item_type'] = $this->getRequest()->getPost('item_type');
                        $productdata['cost'] = $this->getRequest()->getPost('cost');
                        $productdata['prod_status'] = $this->getRequest()->getPost('prod_status');
                        $productdata['delivery_time'] = $this->getRequest()->getPost('delivery_time');
                        $productdata['product_discount'] = $this->getRequest()->getPost('product_discount');
                        $productdata['product_discount_type'] = $this->getRequest()->getPost('product_discount_type');
                        $productdata['agent_id'] = $this->getRequest()->getPost('agent_id');
                        $productdata['prod_type'] = $this->getRequest()->getPost('product_type');
                        if ($productdata['prod_type'] == 1) {
                            $productdata['category_id'] = $this->getRequest()->getPost('category_id');
                        } else if ($productdata['prod_type'] == 2) {
                            $productdata['cuisine_id'] = $this->getRequest()->getPost('cuisine_id');
                        } else {
                            $productdata['prod_type'] = 0;
                            $productdata['category_id'] = 0;
                            $productdata['cuisine_id'] = 0;
                        }
                        $insertproductid = $productsummaryModel->AddProductDetails($productdata);

                        if ($insertproductid) {
                            $response->message = 'successfull';
                            $response->code = 200;
                            $response->data['product_id'] = $insertproductid;
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

                    break;

                /*
                 * Modyfied By : Nitin Kumar Gupta
                 * Modyfied Date : 16 FEB 2016
                 */
                case'getproductbycategoryId':
                    if ($this->getRequest()->isPost()) {

                        $category_id = $this->getRequest()->getPost('category_id');
                        $category_type = $this->getRequest()->getPost('category_type');

                        if ($category_id && $category_type) {
                            $proddetails = $productsummaryModel->getProductBycategoryID($category_id, $category_type);

                            if ($proddetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $proddetails;
                            } else {
                                $response->message = 'There are no product available inside this category.';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } else {
                            $response->message = 'You should be send all parameters.';
                            $response->code = 401;
                            $response->data = NULL;
                        }
                    } else {
                        $response->message = 'Request should be through post method';
                        $response->code = 401;
                        $response->data = Null;
                    }
                    echo json_encode($response, true);
                    die;

                    break;
                case'getproductsByCookie':
                    if ($this->getRequest()->isPost()) {

                        $cookies_values = $this->getRequest()->getPost('cookies_values');
                        $hotel_id = $this->getRequest()->getPost('hotel_id');
                        $cookies_values = (array) json_decode($cookies_values, true);

                        if ($cookies_values) {
                            $proddetails = $productsummaryModel->getProductsByCookies($cookies_values, $hotel_id);

                            if ($proddetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $proddetails;
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

                case'getproductsForAllHotels':
                    if ($this->getRequest()->isPost()) {

                        $cookies_values = $this->getRequest()->getPost('cookies_values');
                        $cookies_values = (array) json_decode($cookies_values, true);
                        if ($cookies_values) {

                            $proddetails = $productsummaryModel->getProductsFromCookiesOfAllHotels($cookies_values);

                            if ($proddetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $proddetails;
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

                case'getcuisines':
                    $cuisinesdetails = $famouscuisinesModel->getCuisines();
                    if ($cuisinesdetails) {
                        $response->message = 'successfull';
                        $response->code = 200;
                        $response->data = $cuisinesdetails;
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 197;
                        $response->data = null;
                    }

                    echo json_encode($response, true);
                    die;

                    break;

                case'getcuisinesofHotel':
                 
                    if ($this->getRequest()->isPost()) {
                        $hotel_id = $this->getRequest()->getPost('hotel_id');
                        $cuisinesdetails = $hotelcuisinesModel->getCuisinesByHotelId($hotel_id);
                  
                        if ($cuisinesdetails) {
                            $response->message = 'successfull';
                            $response->code = 200;
                            $response->data = $cuisinesdetails;
                        } else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 197;
                            $response->data = null;
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
            $response->data = 'No Method';

            echo json_encode($response);
        }
    }

    public function orderProductsAction() {
        $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
        $deliverystatusmodal = Application_Model_DeliveryStatusLog::getInstance();
        $productsummaryModel = Application_Model_Products::getInstance();
        $categorysModel = Application_Model_MenuCategory::getInstance();
        $orderproductsModel = Application_Model_OrderProducts::getInstance();
        $ordersModel = Application_Model_Orders::getInstance();
        $response = new stdClass();
        if ($this->getRequest()->isPost()) {
            $agent_id = $this->getRequest()->getPost('agent_id');
        }
        $orderproductsdetails = $ordersModel->GetOrderProducts($agent_id);
        if ($orderproductsdetails) {
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $orderproductsdetails;
        } else {
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
        }
        echo json_encode($response, true);
    }
//added by sowmya 21 march 2016
      public function editOrderProductsAction() {
        $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
        $deliverystatusmodal = Application_Model_DeliveryStatusLog::getInstance();
        $productsummaryModel = Application_Model_Products::getInstance();
        $categorysModel = Application_Model_MenuCategory::getInstance();
        $orderproductsModel = Application_Model_OrderProducts::getInstance();
        $ordersModels= Application_Model_Orders::getInstance();
        $response = new stdClass();
        if ($this->getRequest()->isPost()) {
            $order_id = $this->getRequest()->getPost('order_id');
        }
        $orderproductsdetails = $ordersModels->GetAgentProduct($order_id);
        if ($orderproductsdetails) {
            $response->message = 'Successfull';
            $response->code = 200;
            $response->data = $orderproductsdetails;
        } else {
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
        }
        echo json_encode($response, true);
    }
}

?>