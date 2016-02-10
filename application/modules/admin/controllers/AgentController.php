<?php

require_once 'Zend/Controller/Action.php';

class Admin_AgentController extends Zend_Controller_Action {

    public function init() {
     
    }

    /*
     * DEV: priyanka varanasi
     * Date : 24/12/2015
     * Desc :edit agent Details
     * 
     */

    public function editAgentDetailsAction() {
        $agentsModel = Admin_Model_Agents::getInstance();
        $agentid = $this->getRequest()->getParam('agentid');

        if ($this->getRequest()->isPost()) {
            $loginname = $this->getRequest()->getPost('loginname');
            if (!empty($loginname)) {
                $data['loginname'] = $loginname;
            }

            $first_name = $this->getRequest()->getPost('first_name');
            if (!empty($first_name)) {
                $data['first_name'] = $first_name;
            }
            $last_name = $this->getRequest()->getPost('last_name');
            if (!empty($last_name)) {
                $data['last_name'] = $last_name;
            }

            $email = $this->getRequest()->getPost('email');
            if (!empty($email)) {
                $data['email'] = $email;
            }
            $city = $this->getRequest()->getPost('city');
            if (!empty($city)) {
                $data['city'] = $city;
            }
            $agentstatus = $this->getRequest()->getPost('agent_status');
            if (!empty($agentstatus)) {
                $data['agent_status'] = $agentstatus;
            }

            $address = $this->getRequest()->getPost('address');
            if (!empty($address)) {
                $data['address'] = $address;
            }

            $membership = $this->getRequest()->getPost('membership');
            if (!empty($membership)) {
                $data['membership'] = $membership;
            }

            $updatestatus = $agentsModel->updateAgentsdetails($agentid, $data);

            if ($updatestatus) {
                $this->redirect('/admin/agent-details');
            }
        }
        $agentdetails = $agentsModel->getAgentsDetailsByAgentID($agentid);

        if ($agentdetails) {
            $this->view->agentdetails = $agentdetails;
        }
    }

    /*
     * DEV: priyanka varanasi
     * Date : 24/12/2015
     * Desc :add agent details
     * 
     */

    public function addAgentsAction() {
        $agentsModel = Admin_Model_Agents::getInstance();


        if ($this->getRequest()->isPost()) {
            $data['loginname'] = $this->getRequest()->getPost('loginname');
            $data['first_name'] = $this->getRequest()->getPost('first_name');
            $data['last_name'] = $this->getRequest()->getPost('last_name');
            $data['email'] = $this->getRequest()->getPost('email');
            $data['password'] = sha1(md5($this->getRequest()->getPost('password')));
            $data['agent_status'] = $this->getRequest()->getPost('agent_status');
            $data['role'] = 1;
            $data['city'] = $this->getRequest()->getPost('city');
            $data['address'] = $this->getRequest()->getPost('address');
            $data['reg_date'] = date('Y-m-d H-i-s');
            $data['membership'] = 2;
            if ($data) {

                $insertid = $agentsModel->addAgentdetails($data);
                if ($insertid) {
                    $this->redirect('/admin/agent-details');
                }
            }
        }
    }

    /*
     * DEV: priyanka varanasi
     * Date : 24/12/2015
     * Desc :agent details
     * 
     */

    public function agentDetailsAction() {

        $agentsModel = Admin_Model_Agents::getInstance();
        $result = $agentsModel->getAgentsDetails();

        if ($result) {
            $this->view->agentdetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

}
