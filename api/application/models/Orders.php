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
     * DEV :sowmya
     * Desc : get All Orders By ID
     * Date : 21/3/2016
     */
    public function GetOrderProducts() {
        if (func_num_args() > 0) {
            $agent_id = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('o' => 'orders'))
                         ->join(array('u' => 'users'),'o.user_id=u.user_id')
                        ->join(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id',array('hd.id','hd.hotel_name','hd.agent_id'))                    
                        ->where('hd.agent_id=?', $agent_id);     
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

            $data = func_get_arg(0);
            $order_id = func_get_arg(1);
            try {
                $result = $this->update($data, 'order_id =' . $order_id);
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
     * DEV :sowmya
     * Desc : get All Orders By ID
     * Date : 21/3/2016
     */

    public function GetAgentProduct() {
        if (func_num_args() > 0) {
            $order_id = func_get_arg(0);
            try {
                $select = $this->select()
                ->from(array('o' => 'orders'))
                ->setIntegrityCheck(false)
                ->joinLeft(array('u' => 'users'), 'o.user_id= u.user_id', array('u.uname', 'u.email'))
               ->joinLeft(array('hd' => 'hotel_details'), 'o.hotel_id=hd.id',array('hd.id','hd.hotel_name','hd.agent_id'))   
                ->where('order_id = ?', $order_id);
                $result = $this->getAdapter()->fetchRow($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        
            if ($result) {
                return $result;
            }
        }
    }
}
?>


