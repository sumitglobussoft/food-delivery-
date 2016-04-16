<?php

class Admin_Model_ProductTransactions extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'product_transactions';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_ProductTransactions();
        }
        return self::$_instance;
    }

    //dev:sowmya
    //desc: all product transaction details
    //date:4/4/2016
    public function getAllProducttransaction() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('pt' => 'product_transactions'))
                    ->joinLeft(array('u' => 'users'), 'pt.user_id= u.user_id', array('u.uname', 'u.email'))
                    ->joinLeft(array('p' => 'products'), 'pt.product_id= p.product_id', array('p.name'))
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
    //desc: to delete product transaction
    //date:4/4/2016

    public function transDelete() {
        if (func_num_args() > 0):
            $product_tx_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('product_tx_id = ?' => $product_tx_id));
                $db->delete('product_transactions', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $product_tx_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

//dev:sowmya
    //desc: to delete Product details by user id
    //date:30/3/2016

    public function productDeleteByUserId() {
        if (func_num_args() > 0):
            $user_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('user_id = ?' => $user_id));
                $db->delete('product_transactions', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $user_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

}
