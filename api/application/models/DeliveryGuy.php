<?php

class Application_Model_DeliveryGuy extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'delivery_guys';

    private function __clone() {
        
    }

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_DeliveryGuy ();
        return self::$_instance;
    }

    public function authenticateByEmail() {
        if (func_num_args() > 0) {

            $email = func_get_arg(0);
            $password = func_get_arg(1);

            try {
                $select = $this->select()
                        ->from($this)
                        ->where('email = ?', $email)
                        ->where('password = ?', $password);
//echo $select;die;
                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
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

  public function fetchorderlist() {
        if (func_num_args() > 0) {
            $deliveryguyid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('del_guy_id = ?', $deliveryguyid);
                $fetchdeliveryguydetails = $this->getAdapter()->fetchRow($select);
                $fetchdeliveryguydetails['hotel_id'] = json_decode($fetchdeliveryguydetails['hotel_id']);

                if ($fetchdeliveryguydetails) {
                    $select1 = $this->select()
                            ->setIntegrityCheck(false)
                            ->from(array('o' => 'orders'), array('o.order_id', 'o.order_status'))
                            ->join(array('oa' => 'order_address'), 'o.order_id=oa.order_id', array('oa.landmark', 'oa.Location'))
                            ->where('o.hotel_id IN (?)', $fetchdeliveryguydetails['hotel_id'])
                            ->where('o.deliveryguy_id IN (?)', [0, $deliveryguyid])
                            ->where('order_status>= ?', 1)
                            ->where('order_status!= ?', 4);
                    $productResult = $this->getAdapter()->fetchAll($select1);
                }
                return $productResult;
            } catch (Exception $ex) {
                throw new Exception('Unable to access data :' . $ex);
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    public function getorderDetails() {
        if (func_num_args() > 0) {
            $orderid = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('oa' => 'order_address'), array('oa.user_name', 'oa.user_contact_number', 'oa.landmark', 'oa.Location', 'oa.address_line1', 'oa.address_line2', 'oa.pin'))
                        ->join(array('o' => 'orders'), 'oa.order_id=o.order_id', array('total_amount' => new Zend_Db_Expr('o.total_amount + o.delivery_charge')))
                        ->join(array('ut' => 'user_transactions'), 'o.order_id=ut.order_id', array('ut.tx_type'))
                        ->join(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id', array('hd.hotel_name', 'hd.hotel_contact_number', 'hd.address', '', '', ''))
                        ->where('oa.order_id= ?', $orderid);

                $productResult = $this->getAdapter()->fetchRow($select);

                return $productResult;
            } catch (Exception $ex) {
                throw new Exception('Unable to access data :' . $ex);
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    public function selecthistoryorder() {
        if (func_num_args() > 0) {
            $deliveryguyid = func_get_arg(0);
            $offset = func_get_arg(1);
            $limit = func_get_arg(2);

            try {

                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('o' => 'orders'), array('o.order_id', 'o.delivery_date'))
                        ->join(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id', array('hd.hotel_name', 'hd.address'))
                        ->join(array('oa' => 'order_address'), 'o.order_id=oa.order_id', array('oa.user_name', 'oa.address_line1'))
                        ->where('o.deliveryguy_id=?', $deliveryguyid)
                        ->where('o.order_status=?', 4)
                        ->limit($limit, $offset)
                        ->order('delivery_date DESC');

                $result = $this->getAdapter()->fetchAll($select);

                foreach ($result as $key => $val) {
                    $date = explode(" ", $val['delivery_date']);
                    $result[$key]['delivery_date'] = $date[0];
                }
                return $result;
            } catch (Exception $ex) {
                throw new Exception('Unable to access data :' . $ex);
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

}
