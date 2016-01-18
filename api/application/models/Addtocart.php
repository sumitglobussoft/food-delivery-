<?php

/*
 * Dev:Sibani Mishra
 * Date:12/01/2016
 * Desc:Function for All methods for addtocart table
 */


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_Addtocart extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'addtocart';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_Addtocart();
        return self::$_instance;
    }

    public function insertOrderstoCart() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = $this->insert($data);
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new exception("argument not passed:" . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    public function RemoveAddtocartorder() {
        if (func_num_args() > 0) {
            $addtocartSerialNo = func_get_arg(0);

            try {

                $deleted = $this->delete('id= ' . $addtocartSerialNo);
                if ($deleted) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $ex) {
                echo $ex->getTraceAsString();
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    public function getaddtocart() {

        if (func_num_args() > 0) {
            $user_id = func_get_arg(0);

            try {
                $select = $this->select()
                        ->from(array('act' => 'addtocart'), array('act.id','act.product_id', 'act.user_id', 'act.hotel_id', 'act.quantity','act.cost','act.hotel_id'))
                        ->setIntegrityCheck(FALSE)
                        ->joinLeft(array('p' => 'products'), 'act.product_id=p.product_id', array('p.name', 'p.imagelink'))
                        ->where('act.user_id = ?', $user_id);

                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception("argument not passed: " . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }
    }
    
    /*
     * DEV : priyanka varanasi
     * Desc: TO check whether  same product exits or not
     * Date : 13/1/2015
     * 
     */
    
    public function checkProductifExists($param) {
           if (func_num_args() > 0) {
            $user_id = func_get_arg(0);
            $product_id = func_get_arg(1);
            $hotel_id = func_get_arg(2);

            try {
                $select = $this->select()
                         ->where('user_id = ?', $user_id)
                         ->where('hotel_id = ?', $hotel_id)
                         ->where('product_id = ?', $product_id);
                
                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception("argument not passed: " . $ex);
            }
        } else {
            throw new Exception("argument not passed");
        }   
    }

}
