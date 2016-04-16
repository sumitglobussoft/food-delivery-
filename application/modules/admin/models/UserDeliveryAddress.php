<?php

/*
 * Dev : sowmya
 * Date: 11/4/2016
 * Desc: User delivery address Modal Design
 */

class Admin_Model_UserDeliveryAddress extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'user_delivery_address';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Admin_Model_UserDeliveryAddress();
        return self::$_instance;
    }
//dev:sowmya
    //desc: to delete UserDeliveryAddress by user id
    //date:11/4/2016

    public function userDeliveryAddressByUserId() {
        if (func_num_args() > 0):
            $user_id= func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('ordered_user_id = ?' => $user_id));
                $db->delete('user_delivery_address', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $user_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }
}

?>
