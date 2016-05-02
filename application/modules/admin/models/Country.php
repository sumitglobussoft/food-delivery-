<?php

/*
 * Dev:sowmya
 * Date:18/04/2016
 * Desc:Function for All methods for country table
 */

class Admin_Model_Country extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'country';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_Country();
        return self::$_instance;
    }

    //dev:sowmya
    //desc: to get all country code
    //date:11/4/2016

    public function getAllCountryCode() {
        try {
            $select = $this->select()
                    ->from($this);
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
        if ($result) {
            return $result;
        }
    }

}
