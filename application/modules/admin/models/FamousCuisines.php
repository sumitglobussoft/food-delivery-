<?php

/*
 * Dev: Priyanka Varanasi
 * Date:5/02/2016
 * Desc:Function for All methods for famous cuisines table
 */


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model_FamousCuisines extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'famous_cuisines';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_FamousCuisines();
        return self::$_instance;
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 5/2/2015
     * Desc: To fetch the list of cuisines
     */

    function getCuisines() {

        $select = $this->select()
                ->from($this)
                ->where('cuisine_status=?', 1);

        $result = $this->getAdapter()->fetchAll($select);

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }
    /*
     * Dev : Sowmya
     * Date: 28/3/2016
     * Desc: To fetch the name of cuisines
     */
    function getcusinesById($string2) {
         $select = $this->select()
                ->from($this)
                ->where('cuisine_id=?', $string2);

        $result = $this->getAdapter()->fetchAll($select);

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

}
