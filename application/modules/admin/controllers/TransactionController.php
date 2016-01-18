<?php

require_once 'Zend/Controller/Action.php';

class Admin_TransactionController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function allTransactionAction() {
        $usertransactionModel = Admin_Model_UserTransactions::getInstance();
        $result = $usertransactionModel->getAllUsertransaction();

        if ($result) {
            $successfullArr = $pendingArr = $failedArr = $cancelArr = array();
            foreach ($result as $key => $value) {
//               echo "-----".$key;
//               echo '<pre>'; print_r($value);die;
                if ($value['tx_status'] == 1) {
                    $successfullArr[] = $value;
                } else if ($value['tx_status'] == 2) {
                    $pendingArr[] = $value;
                } else if ($value['tx_status'] == 3) {
                    $failedArr[] = $value;
                }else if($value['tx_status'] == 4) {
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
        
        $this->view->usertransaction = $result;
    }

}
