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

    //dev:sowmya
    //desc: to get all user transaction
    //date:4/4/2016
    public function getAllUsertransaction() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('ut' => 'user_transactions'))
                    ->joinLeft(array('u' => 'users'), 'ut.user_id= u.user_id', array('u.uname', 'u.email'))
                    ->order('tx_date DESC');
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    //dev:sowmya
    //desc: to delete user transaction
    //date:30/3/2016

    public function transDelete() {
        if (func_num_args() > 0):
            $user_tx_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('user_tx_id = ?' => $user_tx_id));
                $db->delete('user_transactions', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $user_tx_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

//dev:sowmya
    //desc: to delete user trans by user id
    //date:30/3/2016

    public function userDeleteByUserId() {
        if (func_num_args() > 0):
            $user_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('user_id = ?' => $user_id));
                $db->delete('user_transactions', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $user_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

}
