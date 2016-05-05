<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class GroceryController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function grocerySummaryAction() {
        $grocerysummaryModel = Application_Model_GroceryDetails::getInstance();
        $ReviewsModel = Application_Model_Reviews::getInstance();
        $grocerycategoryModel = Application_Model_GroceryCategory::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {

                case'allgrocery':
                    $grocerydetails = $grocerysummaryModel->selectAllGrocerysLocations();

                    if ($grocerydetails) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $grocerydetails;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
                case'getGroceryDetailsByAgentId':
                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agentgrocerydetails = $grocerysummaryModel->getGrocerydetails($agent_id);
                            if ($agentgrocerydetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentgrocerydetails;
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

                case'changegrocerystatus':
                    if ($this->getRequest()->isPost()) {

                        $grocery_id = $this->getRequest()->getPost('grocery_id');

                        if ($grocery_id) {
                            $updatestatus = $grocerysummaryModel->getstatusChangeOfGrocery($grocery_id);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['grocery_id'] = $grocery_id;
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

                case'grocerydelete':
                    if ($this->getRequest()->isPost()) {

                        $grocery_id = $this->getRequest()->getPost('grocery_id');

                        if ($grocery_id) {
                            $updatestatus = $grocerysummaryModel->groceryDelete($grocery_id);

                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['grocery_id'] = $grocery_id;
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
                case'getGroceryDetailsByGroceryId':
                    if ($this->getRequest()->isPost()) {

                        $grocery_id = $this->getRequest()->getPost('grocery_id');

                        if ($grocery_id) {
                            $grocerydetails = $grocerysummaryModel->getGrocerydetailsByGroceryId($grocery_id);
                            if ($grocerydetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $grocerydetails;
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

                case'updategrocerydetails':
                    if ($this->getRequest()->isPost()) {
                        $grocery_id = $this->getRequest()->getPost('grocery_id');
                        $primary_phone = $this->getRequest()->getPost('primary_phone');
                        if (!empty($primary_phone)) {
                            $data['grocery_contact_number'] = $primary_phone;
                        }
                         $selectlocation = $this->getRequest()->getPost('selectlocation');
                        if (!empty($selectlocation)) {
                            $data['grocery_location'] = $selectlocation;
                        }
                        

                        $secondary_phone = $this->getRequest()->getPost('secondary_phone');
                        if (!empty($secondary_phone)) {
                            $data['Secondary_phone'] = $secondary_phone;
                        }

                        $grocery_name = $this->getRequest()->getPost('grocery_name');
                        if (!empty($grocery_name)) {
                            $data['Grocery_name'] = $grocery_name;
                        }
                        $open_time = $this->getRequest()->getPost('open_time');
                        if (!empty($open_time)) {
                            $data['Open_time'] = $open_time;
                        }

                        $grocery_status = $this->getRequest()->getPost('grocery_status');
                        if (!empty($grocery_status)) {
                            $data['grocery_status'] = $grocery_status;
                        }

                        $closing_time = $this->getRequest()->getPost('closing_time');
                        if (!empty($closing_time)) {
                            $data['Closing_time'] = $closing_time;
                        }
                        $notice = $this->getRequest()->getPost('notice');
                        if (!empty($notice)) {
                            $data['Notice'] = $notice;
                        }
                        $grocery_image = $this->getRequest()->getPost('Grocery_image');
                        if (!empty($grocery_image)) {
                            $data['Grocery_image'] = $grocery_image;
                        }

                        $deliverycharge = $this->getRequest()->getPost('deliverycharge');
                        if (!empty($deliverycharge)) {
                            $data['Deliverycharge'] = $deliverycharge;
                        }

                        $minorder = $this->getRequest()->getPost('minorder');
                        if (!empty($minorder)) {
                            $data['Minorder'] = $minorder;
                        }
                        $address = $this->getRequest()->getPost('address');
                        if (!empty($address)) {
                            $data['Address'] = $address;
                        }

                        if ($grocery_id) {

                            $updatestatus = $grocerysummaryModel->updateGroceryDetails($grocery_id, $data);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $updatestatus;
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

                case'addgrocerydetails':
                    if ($this->getRequest()->isPost()) {
                        $data['grocery_contact_number'] = $this->getRequest()->getPost('primary_phone');
                        $data['Secondary_phone'] = $this->getRequest()->getPost('secondary_phone');
                        $data['Grocery_name'] = $this->getRequest()->getPost('grocery_name');
                        $data['Open_time'] = $this->getRequest()->getPost('open_time');
                        $data['Closing_time'] = $this->getRequest()->getPost('closing_time');
                        $data['Notice'] = $this->getRequest()->getPost('notice');
                        $data['Address'] = $this->getRequest()->getPost('address');
                        $data['Minorder'] = $this->getRequest()->getPost('minorder');
                        $data['Deliverycharge'] = $this->getRequest()->getPost('deliverycharge');
                        $data['grocery_status'] = $this->getRequest()->getPost('grocery_status');
                        $data['grocery_location'] = $this->getRequest()->getPost('grocery_location');
                        $data['agent_id'] = $this->getRequest()->getPost('agent_id');
                        if ($data['agent_id']) {
                            $updatestatus = $grocerysummaryModel->insertGroceryDetails($data);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['grocery_id'] = $updatestatus;
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
                case'getHotelReviewsByAgentId':
                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agentgrocerydetails = $ReviewsModel->getAllHotelReviews($agent_id);
                            if ($agentgrocerydetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentgrocerydetails;
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
                case'getGroceryReviewsByAgentId':
                    if ($this->getRequest()->isPost()) {

                        $agent_id = $this->getRequest()->getPost('agent_id');

                        if ($agent_id) {
                            $agentgrocerydetails = $ReviewsModel->getAllGroceryReviews($agent_id);
                            if ($agentgrocerydetails) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $agentgrocerydetails;
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

                case'changereviewstatus':
                    if ($this->getRequest()->isPost()) {

                        $review_id = $this->getRequest()->getPost('review_id');

                        if ($review_id) {
                            $updatestatus = $ReviewsModel->getstatustodeactivate($review_id);
                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['review_id'] = $review_id;
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

                case'reviewdelete':
                    if ($this->getRequest()->isPost()) {

                        $review_id = $this->getRequest()->getPost('review_id');

                        if ($review_id) {
                            $updatestatus = $ReviewsModel->deleteReviews($review_id);

                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['review_id'] = $review_id;
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
                // added by sowmya 2/5/2016
                case'groceryCategory':
                    $grocerydetails = $grocerycategoryModel->selectAllCategorys();

                    if ($grocerydetails) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $grocerydetails;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
                // added by sowmya 2/5/2016
                case'addGroceryCategory':
                    if ($this->getRequest()->isPost()) {
                        $data['cat_name'] = $this->getRequest()->getPost('cat_name');
                        $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
                        $data['cat_status'] = $this->getRequest()->getPost('cat_status');

                        $updatestatus = $grocerycategoryModel->addCategory($data);
                        if ($updatestatus) {
                            $response->message = 'successfull';
                            $response->code = 200;
                            $response->data = $updatestatus;
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

                    echo json_encode($response, true);
                    die;
                    break;
                    break;
                // added by sowmya 2/5/2016
                case'getgrocerycategoryById':
                    if ($this->getRequest()->isPost()) {
                        $categoryid = $this->getRequest()->getParam('categoryid');                   
                        $updatestatus = $grocerycategoryModel->getCategoryById($categoryid);
                        if ($updatestatus) {
                            $response->message = 'successfull';
                            $response->code = 200;
                            $response->data = $updatestatus;
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

                    echo json_encode($response, true);
                    die;
                    break;
                case'grocerycategorydelete':
                    if ($this->getRequest()->isPost()) {

                        $categoryid = $this->getRequest()->getParam('categoryid');                      
                        if ($categoryid) {
                            $updatestatus = $grocerycategoryModel->categorydelete($categoryid);

                            if ($updatestatus) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data['category_id'] = $categoryid;
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
                case'updateGroceryCategory':
                    if ($this->getRequest()->isPost()) {
                        $data['cat_name'] = $this->getRequest()->getPost('cat_name');
                        $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
                        $category_id = $this->getRequest()->getPost('category_id');
                        $categoryname = $this->getRequest()->getPost('categorybtn');

                        if ($category_id) {
                            $result = $grocerycategoryModel->updateCategory($data, $category_id);
                            if ($categoryname == 'cat_name') {

                                if ($result) {
                                    $response->message = 'successfull';
                                    $response->code = 200;
                                    $response->data = $updatestatus;
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
                    } else {

                        $response->message = 'Invalid Request';
                        $response->code = 401;
                        $response->data = "No Method Passed";
                        echo json_encode($response, true);
                    }
            }
        }
    }

}
