<?php

/*
 * Dev: sowmya
 * Date:8/4/2016
 * Desc:Function for All methods for hotel cuisines table
 */


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model_HotelCuisines extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'hotel_cuisines';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_HotelCuisines();
        return self::$_instance;
    }

    // added by sowmya 2/4/2016
    public function insertHotelCuisines() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);


            try {
                $row = $this->insert($data);
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

    /*
     * Dev: sowmya 2/4/2016
     * Desc: fetch locations under citys
     * date : 2/4/2016
     */

    public function getCuisinesByHotelId() {
        if (func_num_args() > 0) {
            $hotelid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hc' => 'hotel_cuisines'))
                        ->join(array('fc' => 'famous_cuisines'), 'hc.cuisine_id=fc.cuisine_id', array('fc.cuisine_id', 'fc.Cuisine_name'))
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

    /*
     * Dev: sowmya 5/4/2016
     * Desc: insert in db
     * date : 2/4/2016
     */

    public function addCuisinesDetails() {
        if (func_num_args() > 0) {
            $hotelcuisinesdata = func_get_arg(0);
            try {
                $id = $this->insert($hotelcuisinesdata);
                if ($id) {
                    return $id;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To insert data :' . $e);
            }
        }
    }

    /*
     * Dev : sowmya
     * Date:11/4/2016
     * Desc: TO delete cuisines
     */

    public function Cuisinedelete() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('cuisine_id = ?' => $uid));
                $db->delete('hotel_cuisines', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $uid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    /*
     * Dev : sowmya
     * Date:11/4/2016
     * Desc: TO delete cuisines by hotel id
     */

    public function deleteCuisinesByHotelId() {
        if (func_num_args() > 0):
            $hotel_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('hotel_id = ?' => $hotel_id));
                $db->delete('hotel_cuisines', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $hotel_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

}
