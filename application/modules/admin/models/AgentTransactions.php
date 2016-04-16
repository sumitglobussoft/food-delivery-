<?php

class Admin_Model_AgentTransactions extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'agent_transactions';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_AgentTransactions();
        }
        return self::$_instance;
    }

    //dev:sowmya
    //desc: all agent transaction details
    //date:4/4/2016
    public function getAllAgenttransaction() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('at' => 'agent_transactions'))
                    ->joinLeft(array('a' => 'agents'), 'at.agent_id= a.agent_id', array('a.loginname', 'a.email'))
                     ->order('tx_date DESC');
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    //dev:sowmya
    //desc: to delete agent transaction
    //date:4/4/2016

    public function transDelete() {
        if (func_num_args() > 0):
            $agent_tx_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('agent_tx_id = ?' => $agent_tx_id));
                $db->delete('agent_transactions', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $agent_tx_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    //dev:sowmya
    //desc: to delete agent transaction by id
    //date:11/4/2016

    public function agentDeleteByAgentId() {
        if (func_num_args() > 0):
            $agent_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('agent_id = ?' => $agent_id));
                $db->delete('agent_transactions', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $agent_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }
}
