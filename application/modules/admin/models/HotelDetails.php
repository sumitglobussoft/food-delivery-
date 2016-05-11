<?php

/*
 * Dev : Sowmya
 * Date: 5/4/2016
 * Desc: hotel_details Modal
 */

class Admin_Model_HotelDetails extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'hotel_details';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Admin_Model_HotelDetails();
        return self::$_instance;
    }

    /*
     * Dev : Sowmya
     * Date: 19/4/2015
     * Desc: TO get all hotels in db
     */

    public function getAllHotels() {
        try {

            $select = $this->select()
                    ->from($this);
            $result = $this->getAdapter()->fetchAll($select);
            if ($result) {
                return $result;
            } else {

                return null;
            }
        } catch (Exception $e) {
            throw new Exception('Unable to access data :' . $e);
        }
    }

    /*
     * Dev : Sowmya
     * Date: 5/4/2015
     * Desc: TO select all hotels in db
     */

    public function selectAllHotels() {
        try {

            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('hd' => 'hotel_details'))
                    ->joinLeft(array('a' => 'agents'), 'hd.agent_id= a.agent_id', array('a.agent_id', 'a.loginname'));
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            } else {

                return null;
            }
        } catch (Exception $e) {
            throw new Exception('Unable to access data :' . $e);
        }
    }

    /*
     * Dev : Sowmya
     * Date: 18/3/2015
     * Desc: TO get all hotels based on Agent
     */

    public function getAllHotelsBasedOnAgent() {
        if (func_num_args() > 0) {
            $agentId = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('agent_Id = ?', $agentId);
                $result = $this->getAdapter()->fetchAll($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        }
    }

    /*
     * Dev : Sowmya
     * Date: 5/4/2015
      function :function to get all hotel details by id */

    public function getHotelDetailsByID() {
        if (func_num_args() > 0) {
            $id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hd' => 'hotel_details'))
                        ->joinLeft(array('a' => 'agents'), 'hd.agent_id= a.agent_id', array('a.agent_id', 'a.loginname'))
                        ->joinLeft(array('l' => 'location'), 'hd.hotel_location= l.location_id', ['areaName' => 'l.name'])     //area*
                        ->joinLeft(array('l1' => 'location'), 'l1.location_id= l.parent_id', ['cityName' => 'l1.name'])          //city*
                        ->joinLeft(array('l2' => 'location'), 'l2.location_id= l1.parent_id', ['stateName' => 'l2.name'])        //state*
                        ->joinLeft(array('l3' => 'location'), 'l3.location_id= l2.parent_id', ['countryName' => 'l3.name'])
                        ->where('hd.id = ?', $id);

                $result = $this->getAdapter()->fetchRow($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        }
    }

    /* Dev : Sowmya
     * Date: 5/4/2015
     * desc:activate and deactive of the user */

    public function getstatustodeactivate() {
        if (func_num_args() > 0):
            $id = func_get_arg(0);
            try {
                $data = array('hotel_status' => new Zend_DB_Expr('IF(hotel_status=1, 0, 1)'));
                $result = $this->update($data, 'id = "' . $id . '"');
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

    /* Dev : Sowmya
     * Date: 5/4/2015
     * desc: to delete hotel */

    public function hoteldelete() {
        if (func_num_args() > 0):
            $id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('id = ?' => $id));
                $db->delete('hotel_details', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    //dev:Sowmya
    //desc: to update edited hotel details based on hotel id
    //date:7/4/2015
    public function updateHotelDetails() {

        if (func_num_args() > 0) {
            $hotelid = func_get_arg(0);
            $data = func_get_arg(1);
            try {
                $result = $this->update($data, 'id =' . $hotelid);
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    /*
     * Dev: Sowmya
     * Desc: to insert hotel details 
     * Date : 7/4/2015
     * 
     */

    public function insertHotelDetails() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $responseId = $this->insert($data);
                if ($responseId) {
                    return $responseId;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev : sowmya
     * Date: 8/4/2016
     * Desc: TO select all Cuisines based on Hotel Location
     */

    public function getCuisines() {
        if (func_num_args() > 0) {
            $hotel_location = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hd' => 'hotel_details'))
                        ->join(array('hc' => 'hotel_cuisines'), 'hd.id=hc.hotel_id', array('hc.cuisine_id'))
                        ->join(array('fc' => 'famous_cuisines'), 'hc.cuisine_id=fc.cuisine_id', array('fc.Cuisine_name'))
                        ->where('hotel_location=?', $hotel_location)
                        ->group(array("hc.cuisine_id", "fc.Cuisine_name")); //remove same rows.
                $result = $this->getAdapter()->fetchAll($select);


                return $result;
            } catch (Exception $ex) {
                throw new Exception('Unable to access data :' . $ex);
            }
        } else {

            throw new Exception('Argument Not Passed');
        }
    }

    /* Dev : Sowmya
     * Date: 11/4/2015
     * desc: to delete hotel by agent id */

    public function hotelDeleteByAgentId() {
        if (func_num_args() > 0):
            $agent_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('agent_id = ?' => $agent_id));
                $db->delete('hotel_details', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $agent_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    /*
     * Dev : Sowmya
     * Date: 23/4/2015
      desc:function :function to get all hotel details by location */

    public function getHotelDetailsByLocation() {
        if (func_num_args() > 0) {
            $id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hd' => 'hotel_details'))
                        ->where('hd.hotel_location = ?', $id);

                $result = $this->getAdapter()->fetchAll($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        }
    }

    /* dev:sreekanth
     * date:10-5-2016
     * desc:  to update hotel location column when we delete location from location table */

    public function updatelocationDelete() {
        if (func_num_args() > 0):
            $id = func_get_arg(0);
            try {
                $data = array('hotel_location' => '0');
                $result = $this->update($data, 'hotel_location = "' . $id . '"');
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

}

?>