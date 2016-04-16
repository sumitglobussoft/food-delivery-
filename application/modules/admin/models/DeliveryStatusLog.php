<?php

/*
 * Dev : Priyanka Varanasi
 * Date: 10/10/2015
 * Desc: DElivery status log modal
 */

class Admin_Model_DeliveryStatusLog extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'delivery_status_log';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Admin_Model_DeliveryStatusLog();
        return self::$_instance;
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 10/10/2015
     * Desc: TO select all products in db
     */

    public function getOrderStatus() {
        if (func_num_args() > 0) {
            $orderid = func_get_arg(0);

            try {
                $select = $this->select()
                        ->from($this)
                        ->where('order_id=?', $orderid);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                } else {

                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev : sowmya
     * Date: 4/4/2016
     * Desc: TO select all products in db
     */

    public function getAllOrderStatus() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('dslo' => 'delivery_status_log'))
                    ->joinLeft(array('um' => 'delivery_guys'), 'um.del_guy_id= dslo.delivery_guy_id')
                    ->joinLeft(array('o' => 'orders'), 'dslo.order_id=o.order_id');
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    //dev:sowmya
    //desc: to delete delivery guy status
    //date:5/4/2016

    public function deliveryGuyStatusdelete() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('status_id = ?' => $uid));
                $db->delete('delivery_status_log', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $uid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

}

?>
