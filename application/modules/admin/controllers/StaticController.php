<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_StaticController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function csvExportcsvAction() {
          $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if ($this->getRequest()->isPost()) {
            $tbl = $this->getRequest()->getPost('tbldata');
//            print_r($tbl); die("csv");
            $fp = fopen('assets/csv/file.csv', 'w');

            if (!empty($tbl)) {
                foreach ($tbl as $row) {
                    fputcsv($fp, $row);
                }
            }
        }
        fclose($fp);
    }

    public function setStatusActiveAction() {
        
        $usersModel = Admin_Model_Users::getInstance();

        $userId = $this->getRequest()->getPost('userId');
        
        $result = $usersModel->updateStatus($userId, 1);
        if ($result) {
//            $response->data = 'Updated Successfully';
//            $response->code = 200;
//            echo json_encode($response);
        } else {
//            $response->data = 'No change';
//            $response->code = 198;
//            echo json_encode($response);
        }
    }

}
