<?php

class Admin_Model_UserTransactions extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'user_transactions';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_UserTransactions();
        }
        return self::$_instance;
    }

    public function getAllUsertransaction() {
//        die("lkjh");
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('ut' => 'user_transactions'))
                    ->joinLeft(array('u' => 'users'), 'ut.user_id= u.user_id', array('u.uname', 'u.email'));
            
//            echo $select;die;
            $result = $this->getAdapter()->fetchAll($select);
//            echo '<pre>';print_r($result);die("ok");
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

}
