<?php

/*
 * Dev: Priyanka Varanasi
 * Date:5/02/2016
 * Desc:Function for All methods for hotel cuisines table
 */


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_HotelCuisines extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'hotel_cuisines';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_HotelCuisines();
        return self::$_instance;
    }

    public function insertHotelCuisines() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);

            foreach ($data as $value) {
                $result[] = $this->insert($value);
            }
            if ($result) {
                return $result;
            } else {
                return null;
            }
        } else {
            throw new Exception("argument not passed");
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch locations under citys
     * date : 13/1/2015;
     */

    public function getCuisinesByHotelId() {
        if (func_num_args() > 0) {
            $hotelid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hc' => 'hotel_cuisines'))
                        ->join(array('fc' => 'famous_cuisines'), 'hc.cuisine_id=fc.cuisine_id')
                        ->where('hotel_id=?', $hotelid)
                        ->where('fc.cuisine_status=?', 1);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        } else {
            
        }
    }
    
    

}
