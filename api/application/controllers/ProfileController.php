<?php

/*
 * Dev : Sibani Mishra
 * Date: 4/5/2016
 */

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class ProfileController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function userAccountSettingsAction() {
        $users = Application_Model_Users::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {

                case'changepassword':

                    if ($this->getRequest()->isPost()) {

                        $postData = $this->getRequest()->getParams();

                        $userId = "";
                        if (isset($postData['user_id'])) {
                            $userId = $postData['user_id'];
                        }

                        $oldpassword = ""; //SEND ALL 3 PASSWORDS WITH MD5 FORMAT WHILE HITTING URL
                        if (isset($postData['oldPassword'])) {
                            $oldpassword = $postData['oldPassword'];
                        }

                        $newpassword = "";
                        if (isset($postData['newPassword'])) {
                            $newpassword = $postData['newPassword'];
                        }

                        $renewpassword = "";
                        if (isset($postData['reNewPassword'])) {
                            $renewpassword = $postData['reNewPassword'];
                        }

                        if ($userId != '') {

                            $checkoldPassword = $users->authenticateByUserID($userId, md5(sha1($oldpassword)));

                            if ($checkoldPassword) {

                                if ($oldpassword != '' && $newpassword != '' && $renewpassword != '') {

                                    if ($newpassword == $renewpassword) {

                                        if ($oldpassword != $newpassword) {

                                            $Updatepassword = $users->updateUserCreds($userId, $newpassword);

                                            if ($Updatepassword) {
                                                $response->code = 200;
                                                $response->message = "Update Successful";
                                                $response->data = $Updatepassword;
                                            } else {
                                                $response->code = 100;
                                                $response->message = "Invalid Password format";
                                                $response->data = null;
                                            }
                                        } else {
                                            $response->code = 100;
                                            $response->message = "New password cannot be same as old password";
                                            $response->data = null;
                                        }
                                    } else {
                                        $response->code = 100;
                                        $response->message = "Password didnot match";
                                        $response->data = null;
                                    }
                                } else {
                                    $response->code = 100;
                                    $response->message = "You missed something";
                                    $response->data = null;
                                }
                            } else {
                                $response->code = 401;
                                $response->message = "Your old Passowrd is incorrect";
                                $response->data = null;
                            }
                        } else {
                            $response->code = 401;
                            $response->message = "You need to login to change password";
                            $response->data = null;
                        }
                        echo json_encode($response, true);
                        break;
                    }
            }
        }
    }

}
