<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class TransactionController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function agentTransactionsAction() {

        $AgenttransactionModel = Application_Model_AgentTransactions::getInstance();
        $response = new stdClass();
        if ($this->getRequest()->isPost()) {
            $agent_id = $this->getRequest()->getPost('agent_id');
            $usertransactions = $AgenttransactionModel->getAllAgenttransaction($agent_id);
            if ($usertransactions) {
                $response->message = 'Successfull';
                $response->code = 200;
                $response->data = $usertransactions;
            } else {
                $response->message = 'Could not Serve the Response';
                $response->code = 197;
                $response->data = NUll;
            }
            echo json_encode($response, true);
            die();
        } else {
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
            echo json_encode($response, true);
            die();
        }
    }
    /*
     * Dev : Sowmya
     * Date: 5/5/2016
     * Desc: agent transactions Action
     */

    public function transactionProcessAction() {

        $Agenttranscation = Application_Model_AgentTransactions::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {

                /*
                 * DEV :sowmya
                 * Desc : to delete stores
                 * Date : 5/5/2016
                 */
                case'payementdelete':
                    if ($this->getRequest()->isPost()) {

                        $deleteid = $this->getRequest()->getPost('deleteid');

                        if ($deleteid) {
                            $updatestatus = $Agenttranscation->transDelete($deleteid);

                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['agent_tx_id'] = $deleteid;
                            } else {
                                $response->message = 'Could Not Serve The Request';
                                $response->code = 197;
                                $response->data = null;
                            }
                        } else {
                            $response->message = 'Could Not Serve The Request';
                            $response->code = 401;
                            $response->data = NULL;
                        }
                    } else {
                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = Null;
                    }
                    echo json_encode($response, true);
                    die;

                    break;
            }
        } else {

            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = "No Method Passed";
            echo json_encode($response, true);
            die();
        }
    }

}
