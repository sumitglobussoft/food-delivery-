<?php

/*
 * Dev:Sibani Mishra
 * Date:12/01/2016
 * Desc:Function for All methods for addtocart table
 */


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_Addtocart extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'addtocart';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_Addtocart();
        return self::$_instance;
    }

    public function insertOrderstoCart() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = $this->insert($data);
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new exception("argument not passed:" . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    public function RemoveAddtocartorder() {
        if (func_num_args() > 0) {
            $addtocartSerialNo = func_get_arg(0);
            $userid = func_get_arg(1);

            try {

                $deleted = $this->delete('id= ' . $addtocartSerialNo);
                if ($deleted) {

                    $select = $this->select()
                            ->from(array('act' => 'addtocart'), array('act.user_id', 'act.product_id', 'act.id AS cart_id', 'act.hotel_id', 'act.quantity'))
                            ->setIntegrityCheck(false)
                            ->joinLeft(array('p' => 'products'), 'act.product_id=p.product_id', array('p.name', 'p.imagelink', 'p.cost AS product_cost'))
                            ->joinLeft(array('hd' => 'hotel_details'), 'act.hotel_id=hd.id')
                            ->where('act.user_id = ?', $userid);

                    $result = $this->getAdapter()->fetchAll($select);

                    if ($result) {
                        $i = 0;
                        foreach ($result as $value) {
                            $hotel_id = $value['id'];
                            $res['hotel_name'] = $value['hotel_name'];
                            $res['hotel_id'] = $value['id'];
                            $res['deliverycharge'] = $value['deliverycharge'];
                            $res['products'][$i]['product_id'] = $value['product_id'];
                            $res['products'][$i]['imagelink'] = $value['imagelink'];
                            $res['products'][$i]['cost'] = $value['product_cost'];
                            $res['products'][$i]['sub_cost_product'] = $value['product_cost'] * $value['quantity'];
                            $res['products'][$i]['quantity'] = $value['quantity'];
                            $res['products'][$i]['cart_id'] = $value['cart_id'];
                            $res['products'][$i]['product_name'] = $value['name'];
                            if (isset($res['subtotal'])) {
                                $res['subtotal']+= $res['products'][$i]['sub_cost_product'];
                            } else {
                                $res['subtotal'] = 0;
                                $res['subtotal']+= $res['products'][$i]['sub_cost_product'];
                            }
                            $i++;
                        }
                        if ($res) {
                            return $res;
                        } else {
                            return null;
                        }
                    } else {
                        return null;
                    }
                } else {
                    return 'error';
                }
            } catch (Exception $ex) {
                echo $ex->getTraceAsString();
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    /*
     * Dev: Priyanka Varanasi
     * Desc : getting user cart products from cart 
     * this service is for andriod , where they are having only one restuarent related prducts in cart of logged user 
     * no where condition  is required to check for hotel id i
     * 
     */

//    public function getaddtocart() {
//
//        if (func_num_args() > 0) {
//            $user_id = func_get_arg(0);
//
//            try {
//                $select = $this->select()
//                        ->from(array('act' => 'addtocart'))
//                        ->setIntegrityCheck(false)
//                        ->joinLeft(array('p' => 'products'), 'act.product_id=p.product_id', array('p.name', 'p.imagelink', 'p.cost AS product_cost'))
//                        ->where('act.user_id = ?', $user_id);
//                $result = $this->getAdapter()->fetchAll($select);
//
//                if ($result) {
//                    return $result;
//                } else {
//                    return null;
//                }
//            } catch (Exception $ex) {
//                throw new Exception("argument not passed: " . $ex);
//            }
//        } else {
//            throw new Exception("argument not passed");
//        }
//    }

    /*
     * Dev: Priyanka Varanasi
     * Desc : getting user cart products from cart 
     * this service is for andriod , where they are having only one restuarent related prducts in cart of logged user 
     * no where condition  is required to check for hotel id i
     * 
     */ // ABOVE CODE MODIFIED 

    /*
     * Modyfied By : Nitin Kumar Gupta
     * Modyfied Date : 20 FEB 2016
     */
    public function getaddtocart() {

        if (func_num_args() > 0) {
            $user_id = func_get_arg(0);
            $hotel_id = func_get_arg(1);
            $res = array();
            try {
                $select = $this->select()
                        ->from(array('act' => 'addtocart'), array('act.user_id', 'act.product_id', 'act.id AS cart_id', 'act.hotel_id', 'act.quantity'))
                        ->setIntegrityCheck(false)
                        ->joinLeft(array('p' => 'products'), 'act.product_id=p.product_id', array('p.name', 'p.imagelink', 'p.cost AS product_cost'))
                        ->joinLeft(array('hd' => 'hotel_details'), 'act.hotel_id=hd.id')
                        ->where('act.user_id = ?', $user_id)
                        ->where('act.hotel_id = ?', $hotel_id);

                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    $i = 0;
                    foreach ($result as $value) {
                        $hotel_id = $value['id'];
                        $res['hotel_name'] = $value['hotel_name'];
                        $res['hotel_id'] = $value['id'];
                        $res['deliverycharge'] = $value['deliverycharge'];
                        $res['products'][$i]['product_id'] = $value['product_id'];
                        $res['products'][$i]['imagelink'] = $value['imagelink'];
                        $res['products'][$i]['cost'] = $value['product_cost'];
                        $res['products'][$i]['sub_cost_product'] = $value['product_cost'] * $value['quantity'];
                        $res['products'][$i]['quantity'] = $value['quantity'];
                        $res['products'][$i]['cart_id'] = $value['cart_id'];
                        $res['products'][$i]['product_name'] = $value['name'];
                        if (isset($res['subtotal'])) {
                            $res['subtotal']+= $res['products'][$i]['sub_cost_product'];
                        } else {
                            $res['subtotal'] = 0;
                            $res['subtotal']+= $res['products'][$i]['sub_cost_product'];
                        }
                        $i++;
                    }

                    return $res;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception("argument not passed: " . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    /*
     * DEV : priyanka varanasi
     * Desc: TO cart products by Hotel ids
     * Date : 13/1/2015
     * 
     */

    public function getCartProductsByHotelIds() {

        if (func_num_args() > 0) {
            $user_id = func_get_arg(0);
            $hotel_id = func_get_arg(1);

            try {
                $select = $this->select()
                        ->from(array('act' => 'addtocart'), array('act.id', 'act.product_id', 'act.user_id', 'act.hotel_id', 'act.quantity', 'act.cost', 'act.hotel_id'))
                        ->setIntegrityCheck(FALSE)
                        ->joinLeft(array('p' => 'products'), 'act.product_id=p.product_id', array('p.name', 'p.imagelink', 'p.cost AS product_cost'))
                        ->joinLeft(array('hd' => 'hotel_details'), 'act.hotel_id=hd.id', array())
                        ->where('act.user_id = ?', $user_id)
                        ->where('act.hotel_id = ?', $hotel_id)
                        ->where('p.prod_status = ?', 1)
                        ->where('hd.hotel_status = ?', 1);

                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception("argument not passed: " . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    /*
     * DEV : priyanka varanasi
     * Desc: TO check whether  same product exits or not
     * Date : 13/1/2015
     * 
     */

    public function checkProductifExists() {
        if (func_num_args() > 0) {
            $user_id = func_get_arg(0);
            $product_id = func_get_arg(1);
            $hotel_id = func_get_arg(2);

            try {
                $select = $this->select()
                        ->where('user_id = ?', $user_id)
                        ->where('hotel_id = ?', $hotel_id)
                        ->where('product_id = ?', $product_id);

                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception("argument not passed: " . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    /*
     * DEV : priyanka varanasi
     * Desc: TO update quantity
     * Date : 18/1/2016
     * 
     */

    public function updateCart() {
        if (func_num_args() > 0):
            $userid = func_get_arg(0);
            $productid = func_get_arg(1);
            $quantity = func_get_arg(2);
            $cost = func_get_arg(3);
            $hotelid = func_get_arg(4);
            $select = $this->select()
                    ->from($this)
                    ->where('user_id = ?', $userid)
                    ->where('product_id = ?', $productid)
                    ->where('hotel_id = ?', $hotelid);
            $res = $this->getAdapter()->fetchRow($select);

            $value = 1;
            if ($quantity['quantity'] === 'increase') {
                $data = array('quantity' => new Zend_Db_Expr('quantity + ' . $value),
                    'cost' => new Zend_Db_Expr('cost + ' . $cost));
            } else if ($quantity['quantity'] === 'decrease' && $res['quantity'] > 1) {
                $data = array('quantity' => new Zend_Db_Expr('quantity - ' . $value),
                    'cost' => new Zend_Db_Expr('cost - ' . $cost));
            } else {
                $value = 0;
                $cost = 0;
                $data = array('quantity' => new Zend_Db_Expr('quantity + ' . $value),
                    'cost' => new Zend_Db_Expr('cost + ' . $cost));
            }
            try {
                $where[] = $this->getAdapter()->quoteInto('user_id = ?', $userid);
                $where[] = $this->getAdapter()->quoteInto('product_id = ?', $productid);
                $where[] = $this->getAdapter()->quoteInto('hotel_id = ?', $hotelid);
                $result = $this->update($data, $where);
                if ($result) {
                    try {
                        $select = $this->select()
                                ->from($this)
                                ->where('user_id = ?', $userid)
                                ->where('product_id = ?', $productid)
                                ->where('hotel_id = ?', $hotelid);
                        $response = $this->getAdapter()->fetchRow($select);
                        if ($response) {
                            $select = $this->select()
                                    ->from($this, array("totalcost" => "SUM(cost)"))
                                    ->where('user_id = ?', $userid)
                                    ->where('hotel_id = ?', $hotelid);
                            $res = $this->getAdapter()->fetchRow($select);
                            $response['total'] = $res['totalcost'];
                            if ($response) {
                                return $response;
                            } else {
                                return null;
                            }
                        } else {
                            return null;
                        }
                    } catch (Exception $ex) {
                        
                    }
                } else {
                    return null;
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        else:
            throw new Exception("Argument not passed");
        endif;
    }

    /*
     * DEV : priyanka varanasi
     * Desc: TO delete cart
     * Date : 18/1/2016
     * 
     */

    public function deleteItem() {

        if (func_num_args() > 0) {
            $uid = func_get_arg(0);
            $prid = func_get_arg(1);
            $hotelid = func_get_arg(2);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where[] = $this->getAdapter()->quoteInto('user_id = ?', $uid);
                $where[] = $this->getAdapter()->quoteInto('product_id = ?', $prid);
                $where[] = $this->getAdapter()->quoteInto('hotel_id = ?', $hotelid);
                $did = $db->delete('addtocart', $where);
                if ($did) {
                    try {
                        $select = $this->select()
                                ->from($this)
                                ->where('user_id = ?', $uid)
                                ->where('hotel_id = ?', $hotelid);
                        $response = $this->getAdapter()->fetchAll($select);
                        if ($response) {

                            return $response;
                        } else {
                            return null;
                        }
                    } catch (Exception $ex) {
                        
                    }
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception($e);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * DEV : priyanka varanasi
     * Desc: TO cart products by Hotel ids
     * Date : 13/1/2015
     * 
     */

    public function getCartProductsByLoggedIds() {

        if (func_num_args() > 0) {
            $user_id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from(array('act' => 'addtocart'), array('act.id', 'act.product_id', 'act.user_id', 'act.hotel_id', 'act.quantity', 'act.cost', 'act.hotel_id'))
                        ->setIntegrityCheck(FALSE)
                        ->joinLeft(array('p' => 'products'), 'act.product_id=p.product_id', array('p.name', 'p.imagelink', 'p.cost AS product_cost'))
                        ->joinLeft(array('hd' => 'hotel_details'), 'act.hotel_id=hd.id')
                        ->where('act.user_id = ?', $user_id)
                        ->where('hd.hotel_status = ?', 1)
                        ->where('p.prod_status = ?', 1);

                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception("argument not passed: " . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    /*
     * DEV : priyanka varanasi
     * Desc: TO insert orders to cart and fetch the details sum of cost of all products in cart
     * Date : 13/1/2015
     * 
     */

    public function insertCartProducts() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            foreach ($data as $value) {
                $result[] = $this->insert($value);
            }
            if ($result) {
                return $result;
            } else {

                return null;
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    /*
     * DEV : priyanka varanasi
     * Desc: TO check whether  same product exits or not
     * Date : 13/1/2015
     * 
     */

    public function checkCartSameProductIfExists() {
        if (func_num_args() > 0) {
            $user_id = func_get_arg(0);
            $product_id = func_get_arg(1);
            $hotel_id = func_get_arg(2);
            $quantity = func_get_arg(2);

            try {
                $select = $this->select()
                        ->where('user_id = ?', $user_id)
                        ->where('hotel_id = ?', $hotel_id)
                        ->where('product_id = ?', $product_id)
                        ->where('quantity = ?', $quantity);

                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception("argument not passed: " . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 1/2/2015
     * Desc: To fetch the products details based on cookie values of all hotels
     */

    function getCartProductsByCartIds() {

        if (func_num_args() > 0) {
            $carts = func_get_arg(0);
            $result = array();
            if ($carts) {
                foreach ($carts as $value) {
                    $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->from(array('cr' => 'addtocart'))
                            ->joinLeft(array('pr' => 'products'), 'pr.product_id=cr.product_id')
                            ->where('cr.id=?', $value)
                            ->where('pr.prod_status=?', 1);
                    $result[] = $this->getAdapter()->fetchRow($select);
                }
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            }
        } else {
            return null;
        }
    }

    /*
     * Dev : Nitin Kumar Gupta
     * Desc : To insert the new cart product and update the existing cart product in addtocart table.
     * Date : 19 FEB 2016
     */

    public function insertUpdateProductInCart() {
        if (func_num_args() > 0) {
            $user_id = func_get_arg(0);
            $hotel_id = func_get_arg(1);
            $product_id = func_get_arg(2);
            $quantity = func_get_arg(3);
            $allCartDetail = array();
            $success = null;
            $i = 0;
            $this->getAdapter()->beginTransaction();

            try {

                foreach ($product_id as $key => $value) {
                    $cartId = $this->select()
                            ->from($this, array('id'))
                            ->where('user_id = ?', $user_id)
                            ->where('hotel_id = ?', $hotel_id)
                            ->where('product_id = ?', $value);

                    $cartId = $this->getAdapter()->fetchRow($cartId);

                    $data = null;

                    if ($cartId) {

                        $where['id = ?'] = $cartId['id'];
                        $data1 = array('quantity' => 0);
                        $data2 = array('quantity' => $quantity[$key]);
                        $updateQuantity1 = $this->update($data1, $where);
                        $updateQuantity2 = $this->update($data2, $where);

                        if ($updateQuantity1 && $updateQuantity2) {

                            $allCartDetail[$i]['cartId'] = $cartId['id'];
                            $allCartDetail[$i]['productId'] = $value;
                            $allCartDetail[$i]['orderedQuantity'] = $quantity[$key];
                            $success = true;
                        } else {
                            $success = false;
                            break;
                        }
                    } else {

                        $data = array(
                            'product_id' => $value,
                            'user_id' => $user_id,
                            'quantity' => $quantity[$key],
                            'hotel_id' => $hotel_id,
                        );

                        $insertedCartId = $this->insert($data);

                        if ($insertedCartId) {
                            $allCartDetail[$i]['cartId'] = $insertedCartId;
                            $allCartDetail[$i]['productId'] = $value;
                            $allCartDetail[$i]['orderedQuantity'] = $quantity[$key];
                            $success = true;
                        } else {
                            $success = false;
                            break;
                        }
                    }

                    $i++;
                }

                if ($success) {
                    $this->getAdapter()->commit();
                    return $allCartDetail;
                } else {
                    $this->getAdapter()->rollBack();
                    return 'fail';
                }
            } catch (Exception $ex) {
                $this->getAdapter()->rollBack();
                throw new Exception("Error : " . $ex);
            }
        } else {
            throw new Exception("Argument has not passed");
        }
    }

    /*
     * Dev : Sibani Mishra
     * Date: 10/12/2015
     * Desc: Select cart details 
     */

    public function selectcartiddetails() {
        if (func_num_args() > 0) {
            $cartid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('id IN (?)', $cartid);

                $result = $this->getAdapter()->fetchAll($select);

                return $result;
            } catch (Exception $ex) {
                throw new Exception("argument not passed: " . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    /*
     * Dev : Sibani Mishra
     * Date: 10/12/2015
     * Desc: Delete cart details after payment part is over 
     */

    public function deletecartiddetails() {
        if (func_num_args() > 0) {

            $cartid = func_get_arg(0);

            try {
                $deleted = $this->delete('id IN (' . implode(',', $cartid) . ')');
            } catch (Exception $exc) {
                throw new Exception('Unable to update, exception occured' . $exc);
            }

            if ($deleted)
                return $deleted;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

}
