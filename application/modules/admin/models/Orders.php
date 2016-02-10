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

    public function getAllOrders() {
//        if (func_num_args() > 0) {
        $role = 1;
        try {
            $select = $this->select()
                    ->from(array('o' => 'orders'))
                    ->setIntegrityCheck(false)
                    ->joinLeft(array('u' => 'users'), 'o.user_id= u.user_id', array('u.uname','u.email'));
                    //->where('u.role = ?', $role);

            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
//        }
    }

    public function getallorderdetails() {

        if (func_num_args() > 0) {
//            $role = 1;
            $orderId = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('o' => 'orders'))
                        ->joinLeft(array('u' => 'users'), 'o.user_id= u.user_id', array('u.uname', 'u.email'))
                        ->joinLeft(array('um' => 'usermeta'), 'o.user_id= um.user_id', array('um.phone', 'um.city', 'um.state', 'um.country', 'um.address'))
                        ->joinLeft(array('op' => 'order_products'), 'o.order_id= op.order_id', array('op.product_id','op.product_cost', 'op.product_discount', 'op.pay_amount', 'op.quantity', 'p.delivery_time'))
                        ->joinLeft(array('p' => 'products'), 'op.product_id= p.product_id', array('p.item_type', 'p.name', 'p.prod_desc', 'p.imagelink', 'p.cost', 'p.delivery_time'))
                        ->joinLeft(array('dsl' => 'delivery_status_log'), 'o.order_id= dsl.order_id', array('dsl.delivery_guy_id','dsl.status_id','dsl.status_type','dsl.time'))
                        ->joinLeft(array('dg' => 'delivery_guys'), 'dsl.delivery_guy_id= dg.del_guy_id')
//                        ->where('u.role = ?',$role)
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

}
