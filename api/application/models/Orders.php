<?php

/*
 * Dev : Priyanka Varanasi
 * Date: 2/12/2015
 * Desc: Users Transactiona Modal Design
 */

class Application_Model_Orders extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'orders';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_Orders();
        return self::$_instance;
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 3/12/2015
     * Desc: insert all user transaction details 
     */

    public function insertOrders() {

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
     * Dev : sowmya
     * Date: 13/4/2016
     * Desc: get all order details agent id based
     */

    public function GetOrderProducts() {
        if (func_num_args() > 0) {
            $hotel_id = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('o' => 'orders'))
                        ->join(array('u' => 'users'), 'o.user_id=u.user_id')
                        ->join(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id', array('hd.id', 'hd.hotel_name', 'hd.agent_id'))
                        ->join(array('dsl' => 'delivery_status_log'), 'o.order_id= dsl.order_id')
                        ->join(array('dg' => 'delivery_guys'), 'dsl.delivery_guy_id=dg.del_guy_id')
                        ->where('hotel_id=?', $hotel_id);

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
     * Date: 13/4/2016
     * Desc: get all order details order id based
     */

    public function GetAgentProduct() {
        if (func_num_args() > 0) {
            $order_id = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('o' => 'orders'))
                        ->join(array('od' => 'order_address'), 'o.order_id=od.order_id')
                        ->join(array('u' => 'users'), 'o.user_id=u.user_id')
                        ->join(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id', array('hd.id', 'hd.hotel_name', 'hd.agent_id'))                     
                        ->where('o.order_id=?', $order_id);
             
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

    public function updateOrderDetails() {

        if (func_num_args() > 0) {

            $userid = func_get_arg(0);

            try {
                $select = $this->select()
                        ->from($this)
                        ->where('user_id=?', $userid);
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    /*
     * Dev : Sibani Mishra
     * Date: 26/3/2016
     * Desc: Select History Orders
     */

    public function selecthistoryorder() {
        if (func_num_args() > 0) {
            $userid = func_get_arg(0);
            $offset = func_get_arg(1);
            $limit = func_get_arg(2);

            try {

                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('o' => 'orders'), array('o.order_id', 'total_amount' => new Zend_Db_Expr('o.total_amount + o.delivery_charge'), 'order_date'))
                        ->join(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id', array('hd.hotel_name', 'hd.address'))
                        ->where('o.user_id=?', $userid)
                        ->limit($limit, $offset)
                        ->order('order_date DESC');

                $result = $this->getAdapter()->fetchAll($select);
                foreach ($result as $key => $val) {
                    $date = explode(" ", $val['order_date']);
                    $result[$key]['order_date'] = $date[0];
                }
                return $result;
            } catch (Exception $ex) {
                throw new Exception('Unable to access data :' . $ex);
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    /*
     * Dev : Sibani Mishra
     * Date: 10/12/2015
     * Desc: Select  Orders Status
     */

    public function selectorderstatus() {
        if (func_num_args() > 0) {

            $orderid = func_get_arg(0);

            try {

                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('o' => 'orders'))
                        ->join(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id', array('hd.hotel_name', 'hd.address'))
                        ->join(array('oa' => 'order_address'), 'o.order_id=oa.order_id', array('oa.landmark', 'oa.Location', 'oa.address_line1', 'oa.address_line2', 'oa.pin'))
                        ->where('o.order_id=?', $orderid);

                $orderResult = $this->getAdapter()->fetchAll($select);

                foreach ($orderResult as $key => $val) {
                    $date = explode(" ", $val['order_date']);
                    $orderResult[$key]['order_date'] = $date[0];
                }

                if ($orderResult) {

                    $orderResult[0]['product_id'] = json_decode($orderResult[0]['product_id']);
                    $orderResult[0]['quantity'] = json_decode($orderResult[0]['quantity']);
                    $orderResult[0]['product_amount'] = json_decode($orderResult[0]['product_amount']);

                    $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->from(array('o' => 'orders'), array('o.order_id'))
                            ->join(array('p' => 'products'), 'o.hotel_id=p.hotel_id', array('p.name'))
                            ->where('p.product_id IN (?)', $orderResult[0]['product_id'])
                            ->where('o.order_id=?', $orderid);

                    $productResult = $this->getAdapter()->fetchAll($select);

                    $i = 0;
                    foreach ($productResult as $key => $value) {
//                        unset($value['order_id']);
                        $value['quantity'] = $orderResult[0]['quantity'][$i];
                        $value['product_amount'] = $orderResult[0]['product_amount'][$i];
                        $productResult[$key] = $value;
                        $i++;
                    }
                    $orderResult[0]['product_detail'] = $productResult;

                    unset($orderResult[0]['order_id']);
                    unset($orderResult[0]['hotel_id']);
                    unset($orderResult[0]['pay_status']);
                    unset($orderResult[0]['pay_type']);
                    unset($orderResult[0]['delivery_status']);
                    unset($orderResult[0]['delivery_type']);
                    unset($orderResult[0]['user_message']);
                    unset($orderResult[0]['user_id']);
                    unset($orderResult[0]['quantity']);
                    unset($orderResult[0]['product_id']);
                    unset($orderResult[0]['product_amount']);
                }

                return $orderResult;
            } catch (Exception $ex) {
                throw new Exception('Unable to access data :' . $ex);
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    public function updateDeliveryStatus() {
        if (func_num_args() > 0) {

            $deliveryguyid = func_get_arg(0);
            $orderid = func_get_arg(1);
            $deliverystatus = func_get_arg(2);

            $where = array();
            $data1 = array(
                'deliveryguy_id' => $deliveryguyid,
                'order_status' => $deliverystatus
            );
            $where[] = $this->getAdapter()->quoteInto('order_id = ?', $orderid);
            $update = $this->update($data1, $where);

            if ($update) {
                return $update;
            } else {
                return null;
            }
        }
    }

}
?>


