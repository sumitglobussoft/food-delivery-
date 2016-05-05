<?php

require_once 'Zend/Controller/Action.php';

class Admin_NewsletterController extends Zend_Controller_Action {

    public function init() {
    
    }

    public function sendNewsletterAction() {
//        $objCore = Engine_Core_Core::getInstance();
//        $objSecuity = Engine_Vault_Security::getInstance();
//        $this->_appSetting = $objCore->getAppSetting();
//        $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
//        $response28 = new stdClass();
//        $url = $this->_appSetting->hostlink . 'newsletter/get-all-news-letter';
//        $response28 = $objCurlHandler->cur($url);
//        if ($response28) {
//            if ($response28->code == 200) {
//                $this->view->newsletter = $response28->data;
//            } elseif ($response28->code == 198) {
////                echo "Code: 198  - Error in response";
//            } else {
//                echo "Unknown error";
//            }
//        }
//
//        $objNewsletterlogModel = Admin_Model_NewsletterLog::getInstance();
//        $NewsletterDetail = $objNewsletterlogModel->getNewsletterDetail();
//        $this->view->newsletterdata = $NewsletterDetail;
    }



    public function addNewsletterAction() {
        $objNewsletterModel = new Admin_Model_NewsletterLog();
        if ($this->getRequest()->isPost()) {
            $description = $this->getRequest()->getParam('description');
            $Subject = $this->getRequest()->getParam('subject');
            $date = time();
            //print($description);die();
            if (isset($description) && isset($Subject) && isset($date)) {
                $data = array(
                    'newsletter_subject' => $Subject,
                    'content' => $description,
                    'added_date' => $date
                );
                $collection = $objNewsletterModel->AddNewsletter($data);
                //echo"<pre>";print_r($collection);echo"</pre>";die("test");
                $this->view->msg = " Newsletter added succesfully.";
            }
        }
    }

    public function newsletterAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $method = $this->getRequest()->getPost('method');
//        $objNewsletterModel = new Admin_Model_NewsletterSubscribers();
//        $objNewsletterlogModel = new Admin_Model_NewsletterLog();
        if ($method) {
            switch ($method) {
//                case 'changestatus':
//                    $newsid = $this->_request->getParam('newsId');
//                    $status = $objNewsletterModel->changeNewsletterStatus($newsid);
//                    if ($status) {
//                        echo $status;
//                    } else {
//                        echo 0;
//                    }
//                    break;

                case "sendnewsletter":

                    $mailer = Engine_Mailer_MandrillApp_Mailer::getInstance();
//                    $objCurlHandler = Engine_Utilities_CurlRequestHandler::getInstance();
//                    $objCore = Engine_Core_Core::getInstance();
//                    $this->_appSetting = $objCore->getAppSetting();

                    if ($this->getRequest()->isPost()) {

                        $email = $this->getRequest()->getPost('emailobj');
                        $contentofMail = $this->getRequest()->getPost('contentofMail');
//                        $template_name = 'newsletter_jewelspark';
//                         $to = $email;
                        $username = "avinashsupport@gmail.com";
                        $subject = "Avinash Newsletter";
                        if (isset($email) && !empty($email)) {
                            foreach ($email as $to) {
//                                $unsubscribe = $this->_appSetting->hostLink . '/unsubscribe-newsletter/' . $to;
//                                $mergevars = array(
//                                    array(
//                                        'name' => 'content',
//                                        'content' => $contentofMail
//                                    ),
//                                    array(
//                                        'name' => 'useremail',
//                                        'content' => $to
//                                    ),
//                                );
                                $result = $mailer->sendMail("$to", $username, $subject, $contentofMail);
//                                $result = $mailer->sendtemplate($template_name, $to, $username, $subject, $mergevars);
                            }
                            if ($result[0]['status'] == "sent") {
                                echo 1;
                            }
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                    break;


                default :
                    break;
            }
        }
    }

    public function manageNewslettersAction() {
        $objNewsletterModel = new Admin_Model_NewsletterLog();
        $all_newsletters = $objNewsletterModel->getNewsletterDetail();
        $this->view->data = $all_newsletters;
    }

    public function editNewsletterAction() {
        $newsletterId = $this->getRequest()->getParam('newsletterId');
        if (is_numeric($newsletterId)) {
            $objNewsletterModel = new Admin_Model_NewsletterLog();
            $newsletter_details = $objNewsletterModel->getNewsletterDetailbyId($newsletterId);
            $this->view->data = $newsletter_details;
            if ($this->getRequest()->isPost()) {
                $description = $this->getRequest()->getParam('description');
                $Subject = $this->getRequest()->getParam('subject');
                if (isset($description) && isset($Subject)) {
                    $data = array(
                        'newsletter_subject' => $Subject,
                        'content' => $description
                    );
                    $collection = $objNewsletterModel->UpdateNewsletter($data, $newsletterId);

                    $this->view->Msg = " Newsletter Updated succesfully.";
                    $newsletter_details = $objNewsletterModel->getNewsletterDetailbyId($newsletterId);
                    $this->view->data = $newsletter_details;
                }
            }
        }
    }

}
