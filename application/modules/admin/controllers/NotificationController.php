<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_NotificationController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*     * @since  4/1/2016
     * @author sowmya    
     * Description:  Notification Details
     */

    public function notificationLogAction() {

        $objNotificationModel = Admin_Model_Notification::getInstance();
        $NotificationDetail = $objNotificationModel->getNotificationDetail();
        $this->view->data = $NotificationDetail;
    }

    /*     * @since  4/1/2016
     * @author sowmya    
     * Description: Notification Ajax Handler
     */

    public function notificationAjaxHandlerAction() {
        
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $userId = $this->view->session->storage->user_id;
        $method = $this->getRequest()->getPost('method');
        $objNotificationModel = new Admin_Model_Notification();
        if ($method) {

            switch ($method) {

                case 'deletenotification':
                    $notificationId = $this->_request->getParam('notificationId');
                    $notificationdel = $objNotificationModel->deletenotificationDetail($notificationId);
                    if ($notificationdel) {
                        echo $notificationdel;
                    } else {
                        echo "Error";
                    }
                    break;

                case 'sendNotification':
           
                    if ($this->getRequest()->getPost()) {

                        $message = $this->getRequest()->getPost('Message');
                        $userid = $this->getRequest()->getPost('UserID');
                        $date = time();
                        if (isset($message) && isset($userid) && isset($date)) {
                            foreach ($userid as $uid) {
                                $status = true;
                                $data = array(
                                    'sent_by' => $userId,
                                    'sent_to' => $uid,
                                    'notification_message' => $message,
                                    'sent_date' => $date,
                                    'status' => 0
                                );
                                $status = $status && $objNotificationModel->AddNotification($data);
                            }
                            if ($status) {
                                echo 'Notification sent to selected Users.';
                            } else {
                                echo 'Sending failed PLease try again.';
                            }
                        }
                    }
                    break;
                case 'agentNotification':
                    $objNotificationModel = Admin_Model_Notification::getInstance();
                    if ($this->getRequest()->getPost()) {
                        $message = $this->getRequest()->getPost('Message');
                        $agentid = $this->getRequest()->getPost('AgentID');
                        $date = time();
                        if (isset($message) && isset($agentid) && isset($date)) {
                            foreach ($agentid as $mid) {
                                $status = true;
                                $data = array(
                                    'sent_to' => $mid,
                                    'sent_by' => $userId,
                                    'notification_message' => $message,
                                    'sent_date' => $date,
                                    'status' => 0
                                );
                                $status = $status && $objNotificationModel->AddNotification($data);
                            }
                            if ($status) {
                                echo 'Notification sent to selected Agent.';
                            } else {
                                echo 'Sending failed PLease try again.';
                            }
                        }
                    }
                    break;
                case "getuserNotification":
                    $where = "sent_to = '" . $userId . "' and status = 0";
                    $NotificationDetail = $objNotificationModel->getNotificationWhere($where);
                    $data = [];
                    $data[0] = count($NotificationDetail);
                    $data[1] = $NotificationDetail;
                    echo json_encode($data);
                    break;
                case "changeNotificationStatus":
                    $notification = $this->getRequest()->getPost('NotificationId');
                    $status = $objNotificationModel->changeAdminNotificationStatus($notification);
                    echo json_encode($status);
                    break;
                case "adminNotificationWithLimit":
                    $start = $this->getRequest()->getPost('start');
                    $where = "sent_to = '" . $userId . "'";
                    $NotificationDetail = $objNotificationModel->getNotificationWithLimit($where, $start);
                    echo json_encode($NotificationDetail);
                    break;
                default :
                    break;
            }
        }
    }

    /*     * @since  4/1/2016
     * @author sowmya   
     * Description: Send Notification to User
     */

    public function sendUserNotificationAction() {

        $objUserModel = Admin_Model_Users::getInstance();
        $where = 'role = 1 and status = 1';
        $UserDetail = $objUserModel->getUsersWhere($where);
        $this->view->data = $UserDetail;
    }

    public function sendAgentNotificationAction() {

        $objAgentsModel = Admin_Model_Agents::getInstance();
        $AgentsDetails = $objAgentsModel->getAgentsDetails();
        $this->view->data = $AgentsDetails;
    }

    public function notificationAction() {
        
    }

}

?>
