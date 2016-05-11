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
        $result = $this->getAdapter()->fetchAll($select);

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    //Dev=sreekanth
//date= 6-may-2016
    public function selectAllCuisines() {
        try {
            $select = $this->select()
                    ->from(array('f' => 'famous_cuisines'))
                    ->setIntegrityCheck(false)
                    ->joinLeft(array('hc' => 'hotel_cuisines'), 'f.cuisine_id= hc.cuisine_id')
                    ->joinLeft(array('hd' => 'hotel_details'), 'hd.id= hc.hotel_id', array('hd.id', 'hd.hotel_name'));
            $result = $this->getAdapter()->fetchAll($select);
            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    //Dev=sreekanth
//date= 6-may-2016
    public function getstatusChangeOfHotelcuisine() {
        if (func_num_args() > 0):
            $cuisineid = func_get_arg(0);
            try {
                $data = array('cuisine_status' => new Zend_DB_Expr('IF(cuisine_status=1, 0, 1)'));
                $result = $this->update($data, 'cuisine_id = "' . $cuisineid . '"');
            } catch (Exception $e) {
                throw new Exception($e);
            }
            if ($result):
                return $result;
            else:
                return 0;
            endif;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

//Dev=sreekanth
//date= 5-may-2016
    public function hotelcuisinedelete() {
        if (func_num_args() > 0):
            $cuisine_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('cuisine_id = ?' => $cuisine_id));
                $db->delete('famous_cuisines', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $cuisine_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

//Dev=sreekanth
//date= 6-may-2016
    public function addCuisinesDetails() {
        if (func_num_args() > 0) {
            $Cuisines = func_get_arg(0);

            try {
                $row = $this->insert($Cuisines);
                if ($row) {
                    return $row;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To insert data :' . $e);
            }
        }
    }

//Dev=sreekanth
//date= 4-may-2016
    public function updateHotelCuisines() {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $cuisine_id = func_get_arg(1);
            try {
                $result1 = $this->update($data, 'cuisine_id = "' . $cuisine_id . '"');

                if ($result1) {
                    return $result1;
                } else {
                    return null;
                }
            } catch (Exception $e) {

                throw new Exception('Unable To update data :' . $e);
            }
        }
    }

}
