<?php

require_once 'Zend/Controller/Action.php';

class Admin_TransactionController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * DEV: priyanka varanasi
     * Date : 6/2/2015
     * Desc :admin transaction details
     * 
     */

    public function adminUserTransactionsAction() {

        $usertransactionModel = Admin_Model_UserTransactions::getInstance();
        $result = $usertransactionModel->getAllUsertransaction();

        if ($result) {
            $successfullArr = $pendingArr = $failedArr = $cancelArr = array();
            foreach ($result as $key => $value) {

                if ($value['tx_status'] == 1) {
                    $successfullArr[] = $value;
                } else if ($value['tx_status'] == 2) {
                    $pendingArr[] = $value;
                } else if ($value['tx_status'] == 3) {
                    $failedArr[] = $value;
                } else if ($value['tx_status'] == 4) {
                    $cancelArr[] = $value;
                }
            }
            $this->view->successfullStatus = $successfullArr;
            $this->view->pendingStatus = $pendingArr;
            $this->view->failedStatus = $failedArr;
            $this->view->cancelStatus = $cancelArr;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV: sowmya
     * Date : 4/4/2015
     * Desc :admin agent details
     * 
     */

    public function adminAgentTransactionsAction() {
        $AgenttransactionModel = Admin_Model_AgentTransactions::getInstance();
        $result = $AgenttransactionModel->getAllAgenttransaction();

        if ($result) {
            $successfullArr = $pendingArr = $failedArr = $cancelArr = array();
            foreach ($result as $key => $value) {

                if ($value['tx_status'] == 1) {
                    $successfullArr[] = $value;
                } else if ($value['tx_status'] == 2) {
                    $pendingArr[] = $value;
                } else if ($value['tx_status'] == 3) {
                    $failedArr[] = $value;
                } else if ($value['tx_status'] == 4) {
                    $cancelArr[] = $value;
                }
            }
            $this->view->successfullStatus = $successfullArr;
            $this->view->pendingStatus = $pendingArr;
            $this->view->failedStatus = $failedArr;
            $this->view->cancelStatus = $cancelArr;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV: sowmya
     * Date : 4/4/2015
     * Desc :admin product details
     * 
     */

    public function adminProductTransactionsAction() {
        $ProducttransactionModel = Admin_Model_ProductTransactions::getInstance();
        $result = $ProducttransactionModel->getAllProducttransaction();

        if ($result) {
            $successfullArr = $pendingArr = $failedArr = $cancelArr = array();
            foreach ($result as $key => $value) {

                if ($value['tx_status'] == 1) {
                    $successfullArr[] = $value;
                } else if ($value['tx_status'] == 2) {
                    $pendingArr[] = $value;
                } else if ($value['tx_status'] == 3) {
                    $failedArr[] = $value;
                } else if ($value['tx_status'] == 4) {
                    $cancelArr[] = $value;
                }
            }
            $this->view->successfullStatus = $successfullArr;
            $this->view->pendingStatus = $pendingArr;
            $this->view->failedStatus = $failedArr;
            $this->view->cancelStatus = $cancelArr;
        } else {
            echo 'controller error occured';
        }
    }

}
