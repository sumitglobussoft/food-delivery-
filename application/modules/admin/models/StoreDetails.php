<?php

/*
 * Dev : Sowmya
 * Date: 20/4/2016
 * Desc: store_details Modal
 */

class Admin_Model_StoreDetails extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'store_details';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Admin_Model_StoreDetails();
        return self::$_instance;
    }

    /*
     * Dev : Sowmya
     * Date: 20/4/2015
     * Desc: TO get all stores in db
     */

    public function getAllStore() {
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
     * Date:20/4/2015
     * Desc: TO select all stores in db
     */

    public function selectAllStore() {
        try {

            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('gd' => 'store_details'))
                    ->joinLeft(array('a' => 'agents'), 'gd.agent_id= a.agent_id', array('a.agent_id', 'a.loginname'));
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
     * Date: 20/4/2015
     * Desc: TO get all stores based on Agent
     */

    public function getAllStoreBasedOnAgent() {
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
     * Date:20/4/2015
      function :function to get all store details by id */

    public function getStoreDetailsByID() {
        if (func_num_args() > 0) {
            $id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('sd' => 'store_details'))
                        ->joinLeft(array('a' => 'agents'), 'sd.agent_id= a.agent_id', array('a.agent_id', 'a.loginname'))
                        ->joinLeft(array('l' => 'location'), 'sd.store_location= l.location_id', ['areaName' => 'l.name'])     //area*
                        ->joinLeft(array('l1' => 'location'), 'l1.location_id= l.parent_id', ['cityName' => 'l1.name'])          //city*
                        ->joinLeft(array('l2' => 'location'), 'l2.location_id= l1.parent_id', ['stateName' => 'l2.name'])        //state*
                        ->joinLeft(array('l3' => 'location'), 'l3.location_id= l2.parent_id', ['countryName' => 'l3.name'])        //country*
                        ->where('sd.store_id = ?', $id);

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
     * Date: 20/4/2015
     * desc:activate and deactive of the store_id */

    public function getstatustodeactivate() {
        if (func_num_args() > 0):
            $store_id = func_get_arg(0);
            try {
                $data = array('store_status' => new Zend_DB_Expr('IF(store_status=1, 0, 1)'));
                $result = $this->update($data, 'store_id = "' . $store_id . '"');
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
     * Date:20/4/2015
     * desc: to delete store */

    public function storedelete() {
        if (func_num_args() > 0):
            $store_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('store_id = ?' => $store_id));
                $db->delete('store_details', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $store_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    //dev:Sowmya
    //desc: to update edited store details based on store id
    //date:20/4/2015
    public function updateStoreDetails() {

        if (func_num_args() > 0) {
            $storeid = func_get_arg(0);
            $data = func_get_arg(1);
            try {
                $result = $this->update($data, 'store_id =' . $storeid);
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
     * Desc: to insert store details 
     * Date : 20/4/2015
     * 
     */

    public function insertStoreDetails() {

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

    /* Dev : Sowmya
     * Date: 20/4/2015
     * desc: to delete store by agent id */

    public function storeDeleteByAgentId() {
        if (func_num_args() > 0):
            $agent_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('agent_id = ?' => $agent_id));
                $db->delete('store_details', $where);
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
      function :function to get all store details by location */

    public function getStoreDetailsByLocation() {
        if (func_num_args() > 0) {
            $id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('sd' => 'store_details'))
                        ->where('sd.store_location = ?', $id);

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
     * desc:  to update store location column when we delete location from location table */

    public function updatelocationDelete() {
        if (func_num_args() > 0):
            $id = func_get_arg(0);
            try {
                $data = array('store_location' => '0');
                $result = $this->update($data, 'store_location = "' . $id . '"');
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