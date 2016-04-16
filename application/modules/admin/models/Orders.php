<?php

class Admin_Model_Orders extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'orders';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_Orders();
        }
        return self::$_instance;
    }

    // added by sowmya 4/2/2016
    public function getAllOrder() {
  
        try {
            $select = $this->select()
                    ->from(array('o' => 'orders'))
                    ->setIntegrityCheck(false)
                    ->joinLeft(array('u' => 'users'), 'o.user_id= u.user_id', array('u.uname', 'u.email'))
                    ->order('order_date DESC');

            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
//        }
    }

//added by sowmya 30.3.2016
    public function getAllOrders($where = null, $order = null, $count = null, $offset = null) {
        try {
            $select = $this->select()
                    ->from(array('o' => 'orders'))
                    ->setIntegrityCheck(false)
                    ->joinLeft(array('u' => 'users'), 'o.user_id= u.user_id', array('u.uname', 'u.email'))
                    ->joinLeft(array('p' => 'products'), 'o.product_id = p.product_id', array('p.product_id', 'p.name'))
                    ->where($where)
                    ->order($order)
                    ->limit($count, $offset);
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    public function getallorderdetails() {

        if (func_num_args() > 0) {
            $orderId = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('o' => 'orders'))
                        ->joinLeft(array('u' => 'users'), 'o.user_id= u.user_id', array('u.uname', 'u.email'))
                        ->joinLeft(array('um' => 'usermeta'), 'o.user_id= um.user_id', array('um.phone', 'um.city', 'um.state', 'um.country', 'um.address'))
                        ->joinLeft(array('op' => 'order_products'), 'o.order_id= op.order_id', array('op.product_id', 'op.product_cost', 'op.product_discount', 'op.pay_amount', 'op.quantity', 'p.delivery_time'))
                        ->joinLeft(array('p' => 'products'), 'op.product_id= p.product_id', array('p.item_type', 'p.name', 'p.prod_desc', 'p.imagelink', 'p.cost', 'p.delivery_time'))
                        ->joinLeft(array('dsl' => 'delivery_status_log'), 'o.order_id= dsl.order_id', array('dsl.delivery_guy_id', 'dsl.status_id', 'dsl.status_type', 'dsl.time'))
                        ->joinLeft(array('dg' => 'delivery_guys'), 'dsl.delivery_guy_id= dg.del_guy_id')
                        ->where('o.order_id = ?', $orderId);

                $result = $this->getAdapter()->fetchAll($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        }
    }

    /*
     * DEV :sowmya
     * Desc : get All Orders By ID
     * Date : 21/3/2016
     */

    public function getAllOrdersById() {
        if (func_num_args() > 0) {
            $order_id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from(array('o' => 'orders'))
                        ->setIntegrityCheck(false)
                        ->joinLeft(array('u' => 'users'), 'o.user_id= u.user_id', array('u.uname', 'u.email'))
                        ->joinLeft(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id', array('hd.id', 'hd.hotel_name'))
                        ->joinLeft(array('p' => 'products'), 'o.product_id=p.product_id', array('p.product_id', 'p.name'))
//                        ->joinLeft(array('u' => 'users'), 'o.user_id= u.user_id', array('u.uname', 'u.email'))
                        ->joinLeft(array('um' => 'usermeta'), 'o.user_id= um.user_id', array('um.first_name', 'um.last_name', 'um.phone', 'um.city', 'um.state', 'um.country'))
//                        ->joinLeft(array('od' => 'order_address'), 'o.order_id= od.order_id', array('od.user_name', 'od.landmark', 'od.Location', 'od.contact_number', 'od.address_line1', 'od.address_line2', 'od.district', 'od. 	state', 'od. 	country', 'od. pin'))
//                        ->joinLeft(array('op' => 'order_products'), 'o.order_id= op.order_id', array('op.ordered_cart_id', 'op.product_cost', 'op.pay_amount', 'op.coupon_id', 'op.product_discount', 'op.quantity', 'op.hotel_id'))
//                      
                        ->where('order_id = ?', $order_id);
                $result = $this->getAdapter()->fetchRow($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        }
    }

//dev:sowmya
    //desc: to delete order details
    //date:30/3/2016

    public function orderDelete() {
        if (func_num_args() > 0):
            $order_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('order_id = ?' => $order_id));
                $db->delete('orders', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $order_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    /// added by sowmya 31/3/2016
    public function getOrderDetailsWhere() {
        if (func_get_args() > 0) {
            $where = func_get_arg(0);
            $sql = $this->select()
                    ->setIntegrityCheck(FALSE)
                    ->from(array('o' => 'orders'))
                    ->joinLeft(array('u' => 'users'), 'o.user_id= u.user_id', array('u.uname', 'u.email'))
                    ->joinLeft(array('um' => 'usermeta'), 'o.user_id= um.user_id', array('um.first_name', 'um.last_name', 'um.phone', 'um.city', 'um.state', 'um.country'))
                    ->joinLeft(array('od' => 'order_address'), 'o.order_id= od.order_id', array('od.user_name', 'od.landmark', 'od.Location', 'od.contact_number', 'od.address_line1', 'od.address_line2', 'od.district', 'od. 	state', 'od. 	country', 'od. pin'))
                    ->joinLeft(array('op' => 'order_products'), 'o.order_id= op.order_id', array('op.ordered_cart_id', 'op.product_cost', 'op.pay_amount', 'op.coupon_id', 'op.product_discount', 'op.quantity', 'op.hotel_id'))
                    ->joinLeft(array('p' => 'products'), 'p.product_id=(' . new Zend_Db_Expr('SUBSTRING_INDEX(`o`.`product_id`, ",", 1)') . ')', array('p.product_id', 'p.hotel_id', 'p.name'))
                    ->joinLeft(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id', array('hd.id', 'hd.hotel_name'))
                    ->where($where)
            ;
            $result = $this->getAdapter()->fetchRow($sql);
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /// added by sowmya 31/3/2016
    public function updateOrderDetails() {
        if (func_get_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $result = $this->update($data, $where);
            } catch (Exception $exc) {
                return $exc->getTraceAsString();
            }
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function changeOrderStatus() {
        if (func_num_args() > 0) {
            $productId = func_get_arg(0);
            $select = $this->select()
                    ->from($this)
                    ->where('order_id = ?', $productId);
            $result = $this->getAdapter()->fetchAll($select);
            return $result;
        }
    }

    public function updateOrderStatus() {
        if (func_num_args() > 0) {
            $productId = func_get_arg(0);
            $productStatus = func_get_arg(1);
            $data['order_status'] = $productStatus;
            try {
                $updated = $this->update($data, 'order_id = ' . $productId);
                return $updated;
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

//dev:sowmya
    //desc: to delete order details by user id
    //date:11/4/2016

    public function orderDeleteByUserId() {
        if (func_num_args() > 0):
            $user_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('user_id = ?' => $user_id));
                $db->delete('orders', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $user_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

//dev:sowmya
    //desc: to delete order details by hotel id
    //date:11/4/2016

    public function deleteOrdersByHotelId() {
        if (func_num_args() > 0):
            $hotel_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('hotel_id = ?' => $hotel_id));
                $db->delete('orders', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $hotel_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

}
