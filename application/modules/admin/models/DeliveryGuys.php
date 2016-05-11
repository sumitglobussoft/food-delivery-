<?php

class Admin_Model_DeliveryGuys extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'delivery_guys';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_DeliveryGuys();
        }
        return self::$_instance;
    }

    public function getAllDeliveryGuys() {

        try {
            $select = $this->select()
                    ->from($this)
                    ->order('reg_date DESC');
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    public function addDeliveryGuydetails() {
        if (func_num_args() > 0) {
            $deliverydata = func_get_arg(0);

            try {
                $row = $this->insert($deliverydata);
                if ($row) {
                    return $row;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To insert data :' . $e);
            }
        }
    }

    public function updateDeliveryGuydetails() {
        if (func_num_args() > 0) {
            $delguyId = func_get_arg(0);
            $data = func_get_arg(1);
            try {
                $result3 = $this->update($data, 'del_guy_id = "' . $delguyId . '"');
                if ($result3) {
                    return $result3;
                } else {

                    return null;
                }
            } catch (Exception $e) {

                throw new Exception('Unable To update data :' . $e);
            }
        }
    }

    public function getDeliveryGuyById() {
        if (func_num_args() > 0) {
            $delguyId = func_get_arg(0);

            try {
                $select = $this->select()
                        ->from($this)
                        ->where('del_guy_id=?', $delguyId);
                $result = $this->getAdapter()->fetchRow($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        }
    }

    public function getDeliveryGuyOrders() {
        if (func_num_args() > 0) {
            $delguyId = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('del' => 'delivery_guys'))
                        ->join(array('o' => 'orders'), 'del.del_guy_id=o.deliveryguy_id')
                        ->join(array('ut' => 'user_transactions'), 'ut.order_id=o.order_id')
                        ->join(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id')
                        ->where('del.del_guy_id=?', $delguyId);

                $result = $this->getAdapter()->fetchAll($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        }
    }

    //dev:priyanka varanasi
    //desc:activate and deactive of the delivery guy
    //date:9/2/2016
    public function getstatustodeactivate() {
        if (func_num_args() > 0):
            $delguyid = func_get_arg(0);
            try {
                $data = array('status' => new Zend_DB_Expr('IF(status=1, 0, 1)'));
                $result = $this->update($data, 'del_guy_id = "' . $delguyid . '"');
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

    //dev:priyanka varanasi
    //desc: to delete delivery guy
    //date:9/2/2016

    public function deliveryGuydelete() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('del_guy_id = ?' => $uid));
                $db->delete('delivery_guys', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $uid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    public function getDeliveryGuyOrderLogs() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('del' => 'delivery_guys'))
                    ->join(array('o' => 'orders'), 'del.del_guy_id=o.deliveryguy_id')
                    ->join(array('ut' => 'user_transactions'), 'ut.order_id=o.order_id')
                    ->join(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id');
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    public function getStoreDeliveryGuyOrderLogs() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('del' => 'delivery_guys'))
                    ->join(array('o' => 'orders'), 'del.del_guy_id=o.deliveryguy_id')
                    ->join(array('ut' => 'user_transactions'), 'ut.order_id=o.order_id')
                    ->join(array('sd' => 'store_details'), 'o.store_id=sd.store_id');
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    public function getStoreDeliveryGuyOrders() {
        if (func_num_args() > 0) {
            $delguyId = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('del' => 'delivery_guys'))
                        ->join(array('o' => 'orders'), 'del.del_guy_id=o.deliveryguy_id')
                        ->join(array('ut' => 'user_transactions'), 'ut.order_id=o.order_id')
                        ->join(array('sd' => 'store_details'), 'o.store_id=sd.store_id')
                        ->where('del.del_guy_id=?', $delguyId);

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
