<?php

/*
 * Dev : Priyanka Varanasi
 * Date: 2/12/2015
 * Desc: Users Transactiona Modal Design
 */

class Application_Model_UserTransactions extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'user_transactions';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_UserTransactions();
        return self::$_instance;
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 3/12/2015
     * Desc: insert all user transaction details 
     */

    public function insertUseTransactions() {

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
                throw new Exception('Unable To Insert Exception Occured :' . $e);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 3/12/2015
     * Desc: insert all user transaction details 
     */

//    public function insertUseTransactions1() {
//
//        if (func_num_args() > 0) {
//            $data = func_get_arg(0);
//
//            try {
//                $responseId = $this->insert($data);
//                if ($responseId) {
//                    return $responseId;
//                } else {
//                    return null;
//                }
//            } catch (Exception $e) {
//                throw new Exception('Unable To Insert Exception Occured :' . $e);
//            }
//        } else {
//            throw new Exception('Argument Not Passed');
//        }
//    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 3/12/2015
     * Desc: update transaction info
     */

    public function updateTransaction() {
        if (func_num_args() > 0) {
            $userid = func_get_arg(0);
            $orderid = func_get_arg(1);
            $data = func_get_arg(2);
            $where = array();
            $where[] = $this->getAdapter()->quoteInto('user_id = ?', $userid);
            $where[] = $this->getAdapter()->quoteInto('order_id = ?', $orderid);
            $update = $this->update($data, $where);
            if ($update) {
                return $update;
            } else {
                return null;
            }
        }
    }
<<<<<<< .mine


































































































=======

    /*
     * Dev : Sibani Mishra
     * Date: 4/11/2016
     * Desc: Message sent to phone for COD
     */

    public function checkOrderid() {
        if (func_num_args() > 0) {
            $orderid = func_get_arg(0);
            $cod_code = func_get_arg(1);

            $data = array(
                'COD_Code' => $cod_code
            );

            $select = $this->select()
                    ->from($this)
                    ->where('order_id = ?', $orderid);

            $row = $this->getAdapter()->fetchRow($select);

            if ($row) {
                try {
                    $updated = $this->update($data, "order_id = '" . $orderid . "'");
                } catch (Exception $exc) {

                    throw new Exception('Unable to update, exception occured' . $exc);
                }
                if ($updated)
                    return $updated;
            } else {
                return null;
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    /*
     * Dev :- Sibani Mishra
     * date :- 11/3/2016
     * Desc :- verify resetcode
     */

    public function verifycodCode() {

        if (func_num_args() > 0) {
            $orderid = func_get_arg(0);

            $codcode = func_get_arg(1);
            $data = array(
                'tx_status' => 1
            );
            $select = $this->select()
                    ->from($this)
                    ->where('COD_Code = ?', $codcode)
                    ->where('order_id = ?', $orderid);

            $row = $this->getAdapter()->fetchRow($select);

            if ($row) {
                try {
                    $updated = $this->update($data, "order_id = '" . $orderid . "'");
                } catch (Exception $exc) {

                    throw new Exception('Unable to update, exception occured' . $exc);
                }
                if ($updated)
                    return $updated;
            } else {
                return null;
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    public function fetchorderdetails() {
        if (func_num_args() > 0) {

            $transactionId1 = func_get_arg(0);

            try {
                $select = $this->select()
                        ->from($this)
                        ->where('user_tx_id = ?', $transactionId1);
                $row = $this->getAdapter()->fetchRow($select);
                return $row;
            } catch (Exception $e) {
                throw new Exception('Unable To Insert Exception Occured :' . $e);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

}
>>>>>>> .theirs

    //dev:sowmya
    //desc: to get all user transaction by agent id
    //date:11/4/2016
    public function getAllUserTransaction() {
     
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
    }



?>
