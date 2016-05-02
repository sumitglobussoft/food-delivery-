<?php

class Admin_Model_Agents extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'agents';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_Agents();
        }
        return self::$_instance;
    }

    public function updateAgentsdetails() {
        if (func_num_args() > 0) {
            $agentId = func_get_arg(0);
            $agentdata = func_get_arg(1);

            try {
                $result1 = $this->update($agentdata, 'agent_id = "' . $agentId . '"');
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

    public function addAgentdetails() {
        if (func_num_args() > 0) {
            $agentdata = func_get_arg(0);

            try {
                $row = $this->insert($agentdata);
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

    public function getAgentsDetails() {
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

    //dev:priyanka varanasi
    //desc:activate and deactive of the agent
    //date:16/12/2015
    public function getstatustodeactivate() {
        if (func_num_args() > 0):
            $userid = func_get_arg(0);
            try {
                $data = array('agent_status' => new Zend_DB_Expr('IF(agent_status=1, 0, 1)'));
                $result = $this->update($data, 'agent_id = "' . $userid . '"');
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

    //dev:priyanka varanasi
    //desc: to delete agent
    //date:16/12/2015

    public function agentdelete() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('agent_id = ?' => $uid));
                $db->delete('agents', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $uid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

//dev:sowmya
    //desc: get agent details by agent id
    //date:20/4/2016
    public function getAgentsDetailsByAgentID() {
        if (func_num_args() > 0) {
            $agent_id = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('a' => 'agents'))
                        ->joinLeft(array('c' => 'country'), 'c.country_id= a.contact_country_code', array('c.country_id', 'c.phonecode'))
                        ->where('agent_id=?', $agent_id);

                $result = $this->getAdapter()->fetchRow($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        } else {

            throw new Exception('Argument Not Passed');
        }
    }

}
