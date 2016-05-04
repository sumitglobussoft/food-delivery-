<?php

/**
 * Coupons model
 * @author Sowmya <sowmya@globussoft.in>
 */
class Admin_Model_Coupons extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'coupons';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_Coupons();
        return self::$_instance;
    }

    /**
     * Add new coupon details
     * @return int
     * @throws Exception
     * @author Sowmya <sowmya@globussoft.in>
     * @since 03-05-2016
     */
    public function addNewCoupon() {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = $this->insert($data);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Get all coupons details
     * @return array
     * @author Sowmya <sowmya@globussoft.in>
     * @since 03-05-2016
     */
    public function getCoupons() {
        $sql = $this->select()
                ->from($this);
        $result = $this->getAdapter()->fetchAll($sql);
        return $result;
    }

    /**
     * Get coupon details based on some condition
     * @return array
     * @throws Exception
     * @author Sowmya <sowmya@globussoft.in>
     * @since 03-09-2015
     */
    public function getCouponWhere() {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $sql = $this->select()
                    ->from($this)
                    ->where("$where");
            $result = $this->getAdapter()->fetchRow($sql);
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Get coupons details based on some condition
     * @return array
     * @throws Exception
     * @author Sowmya <sowmya@globussoft.in>
     * @since 03-05-2016
     */
    public function getCouponsWhere() {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $sql = $this->select()
                    ->from($this)
                    ->where("$where");
            $result = $this->getAdapter()->fetchAll($sql);
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * To update coupon details
     * @return boolean
     * @author Sowmya <sowmya@globussoft.in>
     * @since 03-05-2016
     */
    public function updateCouponDetails() {
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

   /* Dev : Sowmya
     * Date: 5/4/2015
     * desc:activate and deactive of the user */

    public function getstatustodeactivate() {
        if (func_num_args() > 0):
            $id = func_get_arg(0);
            try {
                $data = array('coupon_status' => new Zend_DB_Expr('IF(coupon_status=1, 0, 1)'));
                $result = $this->update($data, 'coupon_id = "' . $id . '"');
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

  

    /* Dev : Sowmya
     * Date: 5/4/2015
     * desc: to delete coupon */

    public function coupondelete() {
        if (func_num_args() > 0):
            $id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('coupon_id = ?' => $id));
                $db->delete('coupons', $where);
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
