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
// added by sowmya 12/4/2016
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
                        $item_type = 1;

                        if ($data['item_type'] == 1) {
                            $data['prod_type'] = $this->getRequest()->getPost('prod_type');
                            if ($data['prod_type'] == 1) {
                                $data['category_id'] = $this->getRequest()->getPost('category_id');
                                $data['Subcategory_id'] = $this->getRequest()->getPost('Subcategory_id');
                            } else if ($data['prod_type'] == 2) {
                                $data['cuisine_id'] = $this->getRequest()->getPost('cuisine_id');
                            }
                        }
                        $stock_quantity = $this->getRequest()->getPost('stock_quantity');
                        if (!empty($stock_quantity)) {
                            $data['stock_quantity'] = $stock_quantity;
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
// added by sowmya 12/4/2016
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
                        $productdata['prod_type'] = $this->getRequest()->getPost('prod_type');
                        $productdata['stock_quantity'] = $this->getRequest()->getPost('stock_quantity');
                        $productdata['servicetax'] = $this->getRequest()->getPost('servicetax');
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
                // dev :sowmya
                // to get store product by product id
                //date 7/5/2016
                case'getstoreproductbyproductId':
                    if ($this->getRequest()->isPost()) {

                        $product_id = $this->getRequest()->getPost('product_id');

                        if ($product_id) {
                            $proddetails = $productsummaryModel->getStoreProductByProductId($product_id);
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


                /*
                 * Modyfied By : Sibani Mishra
                 * Modyfied Date :  4/1/2016
                 * Desc:cuisines based on location.
                 */

                case'getcuisines':

                    if ($this->getRequest()->isPost()) {

                        $hotel_location = $this->getRequest()->getPost('hotel_location');

                        if ($hotel_location) {

                            $cuisinesdetails = $hotelssummaryModel->getCuisines($hotel_location);


                            foreach ($cuisinesdetails as $key => $val) {

                                unset($val['id']);
                                unset($val['agent_id']);
                                unset($val['hotel_location']);
                                unset($val['address']);
                                unset($val['hotel_contact_number']);
                                unset($val['hotel_name']);
                                unset($val['hotel_image']);
                                unset($val['open_time']);
                                unset($val['closing_time']);
                                unset($val['hotel_status']);
                                unset($val['notice']);
                                unset($val['minorder']);
                                unset($val['deliverycharge']);
//                                unset($val['cuisine_id']);
                                unset($val['secondary_phone']);

                                $cuisinesdetails[$key] = $val;
                            }
//                            print_r($cuisinesdetails);die;

                            if (!empty($cuisinesdetails)) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $cuisinesdetails;
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                                $response->data = null;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
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

//added by sowmya 13/4/2016
    public function orderProductsAction() {
        $ordersModel = Application_Model_Orders::getInstance();
        $response = new stdClass();
        if ($this->getRequest()->isPost()) {
            $hotel_id = $this->getRequest()->getPost('hotel_id');
            $orderproductsdetails = $ordersModel->GetOrderProducts($hotel_id);
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
            die();
        } else {
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
            echo json_encode($response, true);
            die();
        }
    }

//added by sowmya 21 march 2016
    public function editOrderProductsAction() {
        $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
        $deliverystatusmodal = Application_Model_DeliveryStatusLog::getInstance();
        $productsummaryModel = Application_Model_Products::getInstance();
        $categorysModel = Application_Model_MenuCategory::getInstance();
        $orderproductsModel = Application_Model_OrderProducts::getInstance();
        $ordersModels = Application_Model_Orders::getInstance();
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

    /*
     * Dev : sowmya
     * Date: 11/4/2016
     * Desc: fetch all products from db
     */

    public function productsSummaryAction() {
        $productsummaryModel = Application_Model_Products::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {

            switch ($method) {

                case'allproducts':

                    $productdetails = $productsummaryModel->selectAllProducts();
                    if ($productdetails) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $productdetails;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'getagentproducts':

                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agentproducts = $productsummaryModel->getALLAgentProducts($agent_id);
                            if ($agentproducts) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentproducts;
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


                case'getProductsByHotelId':

                    if ($this->getRequest()->isPost()) {

                        $hotelid = $this->getRequest()->getPost('hotel_id');

                        if ($hotelid) {
                            $agentproducts = $productsummaryModel->getProductsByHotelId($hotelid);
                            if ($agentproducts) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentproducts;
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
// added by sowmya  6/5/2016 to get store product details  in agent panel
                case'getagentstoreproducts':

                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agentproducts = $productsummaryModel->getALLAgentStoreProducts($agent_id);
                            if ($agentproducts) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentproducts;
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
                // added by sowmya  6/5/2016 to get store product details by store id  in agent panel
                case'getProductsByStoreId':

                    if ($this->getRequest()->isPost()) {

                        $store_id = $this->getRequest()->getPost('store_id');

                        if ($store_id) {
                            $agentproducts = $productsummaryModel->getProductsByStoreId($store_id);
                            if ($agentproducts) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentproducts;
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
                case'changeproductstatus':
                    if ($this->getRequest()->isPost()) {

                        $product_id = $this->getRequest()->getPost('product_id');

                        if ($product_id) {
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

                case'productdelete':
                    if ($this->getRequest()->isPost()) {

                        $product_id = $this->getRequest()->getPost('product_id');

                        if ($product_id) {
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