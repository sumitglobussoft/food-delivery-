<?php

/*
 * Dev : Sowmya
 * Date: 20/4/2016
 * Desc: grocery_details Modal
 */

class Admin_Model_GroceryDetails extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'grocery_details';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Admin_Model_GroceryDetails();
        return self::$_instance;
    }
 /*
     * Dev : Sowmya
     * Date: 20/4/2015
     * Desc: TO get all grocerys in db
     */

    public function getAllGrocery() {
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
     * Desc: TO select all grocerys in db
     */

    public function selectAllGrocery() {
        try {

            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('gd' => 'grocery_details'))
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
     * Desc: TO get all grocerys based on Agent
     */

    public function getAllGroceryBasedOnAgent() {
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
      function :function to get all grocery details by id */

    public function getGroceryDetailsByID() {
        if (func_num_args() > 0) {
            $id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('gd' => 'grocery_details'))
                        ->joinLeft(array('a' => 'agents'), 'gd.agent_id= a.agent_id', array('a.agent_id', 'a.loginname'))
                        ->where('gd.grocery_id = ?', $id);

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
     * desc:activate and deactive of the grocery_id */

    public function getstatustodeactivate() {
        if (func_num_args() > 0):
            $grocery_id = func_get_arg(0);
            try {
                $data = array('grocery_status' => new Zend_DB_Expr('IF(grocery_status=1, 0, 1)'));
                $result = $this->update($data, 'grocery_id = "' . $grocery_id . '"');
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
     * desc: to delete grocery */

    public function grocerydelete() {
        if (func_num_args() > 0):
            $grocery_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('grocery_id = ?' => $grocery_id));
                $db->delete('grocery_details', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $grocery_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    //dev:Sowmya
    //desc: to update edited grocery details based on grocery id
    //date:20/4/2015
    public function updateGroceryDetails() {

        if (func_num_args() > 0) {
            $groceryid = func_get_arg(0);
            $data = func_get_arg(1);
            try {
                $result = $this->update($data, 'grocery_id =' . $groceryid);
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
     * Desc: to insert grocery details 
     * Date : 20/4/2015
     * 
     */

    public function insertGroceryDetails() {

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
     * desc: to delete grocery by agent id */

    public function groceryDeleteByAgentId() {
        if (func_num_args() > 0):
            $agent_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('agent_id = ?' => $agent_id));
                $db->delete('grocery_details', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $agent_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

}

?>