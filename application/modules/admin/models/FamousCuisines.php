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

    /*
     * Dev : sowmya
     * Date: 2/4/2016
     * Desc: To fetch the list of cuisines based on hotel 
     */

    function getCuisinesHotelBased() {

        $select = $this->select()
                ->from(array('f' => 'famous_cuisines'))
                ->setIntegrityCheck(false)
                ->joinLeft(array('hc' => 'hotel_cuisines'), 'f.cuisine_id= hc.cuisine_id')
                ->joinLeft(array('hd' => 'hotel_details'), 'hd.id= hc.hotel_id', array('hd.id', 'hd.hotel_name'));


        $result = $this->getAdapter()->fetchAll($select);

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    /*
     * Dev: sowmya
     * Desc: add cuisine in db
     * date : 13/1/2015;
     */

    public function addCuisines() {
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

    public function changeCuisineStatus() {
        if (func_num_args() > 0):
            $cuisine_id = func_get_arg(0);
            try {
                $data = array('cuisine_status' => new Zend_DB_Expr('IF(cuisine_status=1, 0, 1)'));
                $result = $this->update($data, 'cuisine_id = "' . $cuisine_id . '"');
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

    /*
     * Dev : sowmya
     * Date: 5/4/2016
     * Desc: TO delete cuisines
     */

    public function Cuisinedelete() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('cuisine_id = ?' => $uid));
                $db->delete('famous_cuisines', $where);
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
     * Date: 6/4/2016
     * Desc: TO editall categorys in db
     */

    public function updateCuisines() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $id = func_get_arg(1);
            try {
                $result1 = $this->update($data, 'cuisine_id = "' . $id . '"');

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

    /*
     * Dev : sowmya
     * Date: 6/4/2016
     * Desc: TO get all Cuisine by id
     */

    public function getCuisineById() {
        if (func_num_args() > 0) {
            $cuisine_id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('cuisine_id=?', $cuisine_id);
                $result = $this->getAdapter()->fetchRow($select);
                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

}
