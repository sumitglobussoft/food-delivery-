<?php

/*
 * Dev : Priyanka Varanasi
 * Date: 10/10/2015
 * Desc: Products Modal
 */

class Application_Model_Products extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'products';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_Products();
        return self::$_instance;
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 10/10/2015
     * Desc: TO select all products in db
     */

    public function selectAllProducts() {

        try {

            $select = $this->select()
                    ->from($this);
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            } else {

                return null;
            }
        } catch (Exception $e) {
            throw new Exception('Unable to access data :' . $e);
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 18/12/2015
     * Desc: get all agent related products
     */

    public function getALLAgentProducts() {
        if (func_num_args() > 0) {
            $agent_id = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('pd' => 'products'))
                        ->join(array('hd' => 'hotel_details'), 'pd.hotel_id=hd.id')
                        ->where('pd.agent_id=?', $agent_id);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                } else {

                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }
        } else {

            throw new Exception('Argument Not Passed');
        }
    }

    //dev:priyanka varanasi
    //desc:activate and deactive product
    //date:18/12/2015

    public function getstatusChangeOfProduct() {
        if (func_num_args() > 0):
            $productid = func_get_arg(0);
            try {
                $data = array('prod_status' => new Zend_DB_Expr('IF(prod_status=1, 0, 1)'));
                $result = $this->update($data, 'product_id = "' . $productid . '"');
            } catch (Exception $e) {
                throw new Exception($e);
            }
            if ($result):
                return $result;
            else:
                return 0;
            endif;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    //dev:priyanka varanasi
    //desc: to delete hotel
    //date:18/12/2015

    public function productDelete() {
        if (func_num_args() > 0):
            $productid = func_get_arg(0);

            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('product_id = ?' => $productid));
                $delete = $db->delete('products', $where);
                if ($delete) {
                    return $delete;
                }
            } catch (Exception $e) {
                throw new Exception($e);
            }

        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 22/12/2015
     * Desc: TO select product by product id
     */

    public function getProductByProductId() {
        if (func_num_args() > 0) {
            $productid = func_get_arg(0);
            try {

                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('pd' => 'products'))
                        ->join(array('hd' => 'hotel_details'), 'pd.hotel_id=hd.id')
                        ->joinLeft(array('m' => 'menu_category'), 'pd.category_id= m.category_id')
                        ->joinLeft(array('fc' => 'famous_cuisines'), 'pd.cuisine_id= fc.cuisine_id')
                        ->where('product_id=?', $productid);
                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                } else {

                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 22/12/2015
     * Desc: TO update product by product id
     */

    public function updateProductDetails() {

        if (func_num_args() > 0) {
            $product_id = func_get_arg(0);
            $data = func_get_arg(1);

            try {
                $result = $this->update($data, 'product_id = "' . $product_id . '"');
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 22/12/2015
     * Desc: TO add product details 
     */

    public function AddProductDetails() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $responseId = $this->insert($data);
                if ($responseId) {
                    return $responseId;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Modyfied By : Nitin Kumar Gupta
     * Modyfied Date : 16 FEB 2016
     */

    public function getProductBycategoryID() {
        if (func_num_args() > 0) {
            $categoryId = func_get_arg(0);
            $categoryType = func_get_arg(1);
            try {
                $select = null;

                if ($categoryType == 'menuList') {
                    $select = $this->select()
                            ->from($this)
                            ->where('category_id=?', $categoryId);
                } else
                if ($categoryType == 'cuisineList') {
                    $select = $this->select()
                            ->from($this)
                            ->where('cuisine_id=?', $categoryId);
                }

                if ($select != null)
                    $result = $this->getAdapter()->fetchAll($select);
                else
                    $result = null;

                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }
        }
    }

//    /*
//     * Dev : Priyanka Varanasi
//     * Date: 17/12/2015
//     * Desc: To fetch the restaurent menu and products 
//     */
//
//    public function getRestaurentsMenuDetails() {
//        if (func_num_args() > 0) {
//            $hotel_id = func_get_arg(0);
//
//            try {
//
//                $select = $this->select()
//                        ->setIntegrityCheck(false)
//                        ->from(array('pd' => 'products'), array('category_id'))
//                        ->joinLeft(array('cat' => 'menu_category'), 'pd.category_id=cat.category_id', array('cat.cat_name'))
//                        ->where('pd.hotel_id=?', $hotel_id)
//                        ->where('pd.prod_status=?', 1)
//                        ->distinct('pd.category_id');
//                $result = $this->getAdapter()->fetchAll($select);
//
//                if ($result) {
//                    $i = 0;
//
//                    foreach ($result as $value) {
//
//                        $select = $this->select()
//                                ->setIntegrityCheck(false)
//                                ->from(array('pd' => 'products'))
//                                ->where('pd.category_id=?', $value['category_id'])
//                                ->where('pd.hotel_id=?', $hotel_id);
//                        $response = $this->getAdapter()->fetchAll($select);
//                        $result[$i]['cat_products'] = $response;
//                        $i++;
//                    }
//                    echo"<pre>";print_r($result);die;
//                    if ($result) {
//                        return $result;
//                    }
//                } else {
//
//                    return null;
//                }
//            } catch (Exception $e) {
//                throw new Exception('Unable to access data :' . $e);
//            }
//        }
//    }
    //    /*
//     * Dev : Priyanka Varanasi
//     * Date: 17/12/2015
//     * Desc: To fetch the restaurent menu and products 
//     */
    ///////// Modified code of Restaurant menu //////////////

    public function getRestaurentsMenuDetails() {
        if (func_num_args() > 0) {
            $hotel_id = func_get_arg(0);

            try {

                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('pd' => 'products'))
                        //->joinLeft(array('cat' => 'menu_category'), 'pd.category_id=cat.category_id', array('cat.cat_name'))
                        ->where('pd.hotel_id=?', $hotel_id)
                        ->where('pd.prod_status=?', 1);
                //->distinct('pd.category_id');
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    $i = 0;

                    foreach ($result as $value) {

                        if ($value['prod_type'] == 1) {
                            $select = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('pd' => 'products'))
                                    ->joinLeft(array('cat' => 'menu_category'), 'pd.category_id=cat.category_id', array('cat.cat_name'))
                                    ->where('pd.category_id=?', $value['category_id'])
                                    ->where('pd.hotel_id=?', $hotel_id)
                                    ->where('pd.product_id=?', $value['product_id']);
                            $response = $this->getAdapter()->fetchRow($select);
                            $category_id = $value['category_id'];
                            if ($category_id) {
                                $res[$category_id]['category_id'] = $value['category_id'];
                                $res[$category_id]['category_name'] = $response['cat_name'];
                                $res[$category_id]['product_type'][$i] = $response;
                            }
                        } else if ($value['prod_type'] == 2) {

                            $select = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('pd' => 'products'))
                                    ->joinLeft(array('cu' => 'famous_cuisines'), 'pd.cuisine_id=cu.cuisine_id')
                                    ->where('pd.cuisine_id=?', $value['cuisine_id'])
                                    ->where('pd.hotel_id=?', $hotel_id)
                                    ->where('pd.product_id=?', $value['product_id']);
                            $response1 = $this->getAdapter()->fetchRow($select);
                            $cuisine_id = $value['cuisine_id'];
                            if ($cuisine_id) {
                                $res[$cuisine_id]['cuisine_id'] = $value['cuisine_id'];
                                $res[$cuisine_id]['cusine_name'] = $response1['Cuisine_name'];
                                $res[$cuisine_id]['product_type'][$i] = $response1;
                            }
                        } else {

                            $select = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('pd' => 'products'))
                                    ->joinLeft(array('cat' => 'menu_category'), 'pd.category_id=cat.category_id', array('cat.cat_name'))
                                    ->where('pd.category_id=?', $value['category_id'])
                                    ->where('pd.hotel_id=?', $hotel_id)
                                    ->where('pd.product_id=?', $value['product_id']);
                            $response3 = $this->getAdapter()->fetchRow($select);

                            $category_id = $value['category_id'];
                            if ($category_id) {
                                $res[$category_id]['category_id'] = $value['category_id'];
                                $res[$category_id]['category_name'] = $response3['cat_name'];
                                $res[$category_id]['product_type'][$i] = $response3;
                            }
                        }

                        $i++;
                    }


                    if ($res) {
                        return $res;
                    }
                } else {

                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 1/2/2015
     * Desc: To fetch the products details based on cookie values for respective hotel_id
     */

    function getProductsByCookies() {

        if (func_num_args() > 0) {
            $products = func_get_arg(0);
            $hotel_id = func_get_arg(1);
            $arr = array();
            if ($products) {
                $i = 0;
                foreach ($products as $value) {
                    if (!empty($value['hotel_id'])) {
                        if ($value['hotel_id'] == $hotel_id) {
                            $select = $this->select()
                                    ->from($this)
                                    ->where('product_id=?', $value['product_id'])
                                    ->where('hotel_id=?', $value['hotel_id']);
                            $result = $this->getAdapter()->fetchRow($select);

                            if ($result) {
                                $arr[$i]['cost'] = ($result['cost']) * ($value['quantity']);
                                $arr[$i]['name'] = $result['name'];
                                $arr[$i]['product_id'] = $value['product_id'];
                                $arr[$i]['hotel_id'] = $hotel_id;
                                $arr[$i]['quantity'] = $value['quantity'];
                                $arr[$i]['item_cost'] = $result['cost'];
                            }
                            $i++;
                        }
                    }
                }
                return $arr;
            }
        } else {
            return null;
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 1/2/2015
     * Desc: To fetch the products details based on cookie values of all hotels
     */

    function getProductsFromCookiesOfAllHotels() {

        if (func_num_args() > 0) {
            $products = func_get_arg(0);
            $arr = array();
            if ($products) {
                $i = 0;
                foreach ($products as $value) {
                    $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->from(array('pd' => 'products'))
                            ->joinLeft(array('hd' => 'hotel_details'), 'pd.hotel_id=hd.id')
                            ->where('product_id=?', $value['product_id'])
                            ->where('hotel_id=?', $value['hotel_id'])
                            ->where('prod_status=?', 1);
                    $result = $this->getAdapter()->fetchRow($select);
                    if ($result) {
                        $result['product_cost'] = ($result['cost']) * ($value['quantity']);
                        $result['quantity'] = $value['quantity'];
                        $arr[$i] = $result;
                    }
                    $i++;
                }

                return $arr;
            }
        } else {
            return null;
        }
    }

    public function getProductsByHotelId() {
        if (func_num_args() > 0) {
            $hotelId = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('p' => 'products'))
                        ->joinLeft(array('hd' => 'hotel_details'), 'p.hotel_id= hd.id')
                        ->where('p.hotel_id=?', $hotelId);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

    /*
     * Dev : Nitin Kumar Gupta
     * Desc : Return the seperated product list based on availablity stock quantity.
     * Date : 20 FEB 2016
     */

    public function seperateTheProductsByQuantityAvailablity() {
        if (func_num_args() > 0) {
            $productId = func_get_arg(0);
            $quantity = func_get_arg(1);
            $availablity = array();
            $i = 0;

            try {
                foreach ($productId as $key => $value) {
                    $productQuantity = $this->select()
                            ->from($this, array('stock_quantity'))
                            ->where('product_id = ?', $value);

                    $productQuantity = $this->getAdapter()->fetchRow($productQuantity);

                    if ($productQuantity) {

                        if ($productQuantity['stock_quantity'] >= $quantity[$key]) {
                            $availablity['success'][] = $value;
                            $availablity['quantity'][] = $quantity[$key];
                        } else {
                            $availablity['fail'][$i]['productId'] = $value;
                            $availablity['fail'][$i]['stockQuantity'] = $productQuantity['stock_quantity'];
                            $availablity['fail'][$i]['orderedQuantity'] = $quantity[$key];
                            $i++;
                        }
                    } else {
                        return 'Please check your product ids.';
                    }
                }

                return $availablity;
            } catch (Exception $e) {
                throw new Exception('Error :' . $e);
            }
        } else {
            throw new Exception("Argument has not passed");
        }
    }

}

?>