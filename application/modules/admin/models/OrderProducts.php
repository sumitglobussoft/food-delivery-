<?php
  /*
   * Dev :sowmya
   * Date: 11/4/2016
   * Desc: Order products Modal Design
   */

class Admin_Model_OrderProducts extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'order_products';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_OrderProducts();
        return self::$_instance;
    }
    
}