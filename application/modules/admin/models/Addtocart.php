<?php

/*
 * Dev:sowmya
 * Date:11/04/2016
 * Desc:Function for All methods for addtocart table
 */


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model_Addtocart extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'addtocart';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_Addtocart();
        return self::$_instance;
    }
    //dev:sowmya
    //desc: to delete addtocart by user id
    //date:11/4/2016

    public function addToCartDeleteByUserId() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('user_id = ?' => $uid));
                $db->delete('addtocart', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $uid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }
     //dev:sowmya
    //desc: to delete addtocart by hotel id
    //date:11/4/2016

    public function addToCartDeleteByHotelId() {
        if (func_num_args() > 0):
            $hotel_id= func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('hotel_id = ?' => $hotel_id));
                $db->delete('addtocart', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $hotel_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }
}

