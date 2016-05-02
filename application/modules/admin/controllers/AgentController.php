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
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $agentsModel = Admin_Model_Agents::getInstance();
        $agentid = $this->getRequest()->getParam('agentid');

        $objCountry = Admin_Model_Country::getInstance();
        $countryCodeDetails = $objCountry->getAllCountryCode();
        if ($countryCodeDetails) {
            $this->view->countryCodeDetails = $countryCodeDetails;
        }
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
                $data['addresss'] = $address;
            }

            $membership = $this->getRequest()->getPost('membership');
            if (!empty($membership)) {
                $data['membership'] = $membership;
            }
            $phone = $this->getRequest()->getPost('phone');
            if (!empty($phone)) {
                $data['phone'] = $phone;
            }

            $contact_country_code = $this->getRequest()->getPost('contact_country_code');
            if (!empty($contact_country_code)) {
                $data['contact_country_code'] = $contact_country_code;
            }
            $coverphoto = $_FILES["fileToUpload"]["name"];

            $dirpath = getcwd() . "/assets/agentimages/$agentid/";
            if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
            }
            if (!empty($coverphoto)) {
                $imagepath = $dirpath . $coverphoto;
                $savepath = "/assets/agentimages/$agentid/$coverphoto";
                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                    if ($imagemoveResult) {
                        $link = $this->_appSetting->hostLink;
                        $data['profilepic_url'] = $link . $savepath;
                        $updatestatus = $agentsModel->updateAgentsdetails($agentid, $data);
                        if ($updatestatus) {
                            $this->redirect('/admin/agent-details');
                        } else {
                            $this->view->errormessage = 'agent details not updated properly';
                        }
                    } else {
                        $updatestatus = $agentsModel->updateAgentsdetails($agentid, $data);
                    }
                }
            } else {
                $updatestatus = $agentsModel->updateAgentsdetails($agentid, $data);
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
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $agentsModel = Admin_Model_Agents::getInstance();


        $objCountry = Admin_Model_Country::getInstance();
        $countryCodeDetails = $objCountry->getAllCountryCode();
        if ($countryCodeDetails) {
            $this->view->countryCodeDetails = $countryCodeDetails;
        }
        if ($this->getRequest()->isPost()) {
//            $data['agent_id'] = $agent_id;
            $data['loginname'] = $this->getRequest()->getPost('loginname');
            $data['first_name'] = $this->getRequest()->getPost('first_name');
            $data['last_name'] = $this->getRequest()->getPost('last_name');
            $data['email'] = $this->getRequest()->getPost('email');
            $data['password'] = (md5($this->getRequest()->getPost('password')));
            $data['agent_status'] = $this->getRequest()->getPost('agent_status');
            $data['role'] = 4;
            $data['city'] = $this->getRequest()->getPost('city');
            $data['addresss'] = $this->getRequest()->getPost('address');
            $data['reg_date'] = date('Y-m-d H-i-s');
            $data['membership'] = 2;
            $data['phone'] = $this->getRequest()->getPost('phone');
            $data['contact_country_code'] = $this->getRequest()->getPost('contact_country_code');
            if ($data) {
                $insertid = $agentsModel->addAgentdetails($data);

                if ($insertid) {
                    $coverphoto = $_FILES["fileToUpload"]["name"];
                    $dirpath = getcwd() . "/assets/agentimages/$insertid/";
                    if (!file_exists($dirpath)) {
                        mkdir($dirpath, 0777, true);
                    }
                    if (!empty($coverphoto)) {
                        $imagepath = $dirpath . $coverphoto;
                        $savepath = "/assets/agentimages/$insertid/$coverphoto";
                        $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                        $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                        if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                            echo json_encode("Something went wrong image upload");
                        } else {
                            $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                            if ($imagemoveResult) {
                                $link = $this->_appSetting->hostLink;
                                $data['profilepic_url'] = $link . $savepath;
                                $result3 = $agentsModel->updateAgentsdetails($insertid, $data);
                                if ($result3) {
                                    $this->redirect('/admin/agent-details');
                                } else {
                                    $this->view->errormessage = 'agent image not updated ';
                                }
                            } else {
                                $this->view->errormessage = 'agent image not updated ';
                            }
                        }
                    } else {
                        $this->redirect('/admin/agent-details');
                    }
                }
            }
        }
    }

//            if ($data) {
//
//                $insertid = $agentsModel->addAgentdetails($data);
//                if ($insertid) {
//                    $this->redirect('/admin/agent-details');
//                }
//            }
//        }
//    }

    /*
     * DEV: priyanka varanasi
     * Date : 24/12/2015
     * Desc :agent details
     * 
     */

    public function agentDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result1 = $adminModel->getAdminDetails(); // showing image
        if ($result1) {
            $this->view->admindetails = $result1;
        }
        $agentsModel = Admin_Model_Agents::getInstance();
        $result = $agentsModel->getAgentsDetails();

        if ($result) {
            $this->view->agentdetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    /*
     * DEV: sowmya
     * Date : 8/4/2016
     * Desc :view all agent Details
     * 
     */

    public function viewAgentDetailsAction() {
          $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $agentsModel = Admin_Model_Agents::getInstance();
        $agentid = $this->getRequest()->getParam('agentid');
        $agentdetails = $agentsModel->getAgentsDetailsByAgentID($agentid);
        if ($agentdetails) {
            $this->view->agentdetails = $agentdetails;
        }
    }

}
