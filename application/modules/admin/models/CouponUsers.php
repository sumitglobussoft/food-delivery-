<?php

/**
 * CouponUsers model
 * @author Sowmya <sowmya@globussoft.in>
 */
class Admin_Model_CouponUsers extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'coupon_users';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_CouponUsers();
        return self::$_instance;
    }

    /**
     * Get all used coupons log
     * @return array
     * @author Sowmya <sowmya@globussoft.in>
     * @since 03-05-2016
     */
    public function getCouponsLog() {
        $sql = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('cu' => 'coupon_users'))
                ->joinInner(array('c' => 'coupons'), 'c.coupon_id=cu.coupon_id', array('coupon_code' => 'c.coupon_code'))
                ->joinInner(array('u' => 'usermeta'), 'u.user_id=cu.user_id', array('first_name' => 'u.first_name', 'last_name' => 'u.last_name'))
                ->joinInner(array('o' => 'orders'), 'o.order_id=cu.order_id', array('product_id' => new Zend_Db_Expr(" trim(trailing ']' from trim( leading '[' from replace(product_id,'\"','')))")))
//                ->joinInner(array('p' => 'products'), 'o.product_id=p.product_id', array('product_name' => new Zend_Db_Expr('SUBSTRING_INDEX(o.product_id,",",1)')))
        ;
        $result = $this->getAdapter()->fetchAll($sql);
        return $result;
    }

    public function getCouponStatistics() {
        for ($i = 0; $i < 12; $i++) {
            $d1 = 'ADDDATE(FROM_UNIXTIME(UNIX_TIMESTAMP()),' . '-' . ($i * 30) . ')';
            $d2 = 'ADDDATE(FROM_UNIXTIME(UNIX_TIMESTAMP()),' . '-' . (($i + 1) * 30) . ')';
            $cond = 'FROM_UNIXTIME(used_date)<' . $d1 . ' AND FROM_UNIXTIME(used_date)>' . $d2;
            $select = $this->select()
                    ->from($this)
                    ->where($cond);

            $result[] = $this->getAdapter()->fetchAll($select);
        }
        return $result;
    }
 /* Dev : Sowmya
     * Date: 5/4/2015
     * desc: to delete coupon user */

    public function couponuserdelete() {
        if (func_num_args() > 0):
            $id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('coupon_users_id = ?' => $id));
                $db->delete('coupon_users', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }
}
?>
