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

class Application_Model_FamousCuisines extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'famous_cuisines';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_FamousCuisines();
        return self::$_instance;
    }

    /*
     * Dev : Priyanka Varanasi
     * Date: 5/2/2015
     * Desc: To fetch the list of cuisines
     */
    /*
     * Dev : Sibani Mishra
     * Date: 4/1/2016
     * Desc: To fetch the list of cuisines on the basis of Location And city id
     */

    function getCuisines() {

        $select = $this->select()
                ->from($this)
                ->where('cuisine_status=?', 1);

//        $select = $this->select()
//                ->setIntegrityCheck(false)
//                ->from(array('o' => 'orders'))
//                ->join(array('u' => 'users'), 'o.user_id=u.user_id')
//                ->join(array('hd' => 'hotel_details'), 'o.order_from_hotel=hd.id', array('hd.id', 'hd.hotel_name', 'hd.agent_id'))
//                ->join(array('dsl' => 'delivery_status_log'), 'o.order_id= dsl.order_id')
//                ->join(array('dg' => 'delivery_guys'), 'dsl.delivery_guy_id=dg.del_guy_id')
//                ->where('hd.agent_id=?', $agent_id);
        $result = $this->getAdapter()->fetchAll($select);

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

}
