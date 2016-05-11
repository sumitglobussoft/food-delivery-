<?php

require_once 'Zend/Controller/Action.php';

class Admin_OrderController extends Zend_Controller_Action {

    public function init() {
        
    }

    /* dev : sowmya     
     * date : 29/3/2016
     * details: get all  hotel order details */

    public function orderDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $ordersModel = Admin_Model_Orders::getInstance();
        $result = $ordersModel->getAllHotelOrder();
//  echo '<pre>';print_r($result);die;
        if ($result) {
            $pendingArr = $adminArr = $cancelledArr = array();
            foreach ($result as $key => $value) {
                if ($value['order_status'] == 0) {
                    $pendingArr[] = $value;
                } elseif ($value['order_status'] == 1) {
                    $adminArr[] = $value;
                } else if ($value['order_status'] == 2) {
                    $deliveredArr[] = $value;
                } else if ($value['order_status'] == 6) {
                    $cancelledArr[] = $value;
                }
            }
            $this->view->pendingStatus = $pendingArr;
            $this->view->processStatus = $adminArr;
            $this->view->canceledStatus = $cancelledArr;
        } else {
            echo 'controller error occured';
        }
        $this->view->orderdetails = $result;
    }

    /*
     * DEV :sowmya
     * Desc : view hotel Order Details action
     * Date : 21/3/2016
     */

    public function viewOrderDetailsAction() {
        $adminproducts = Admin_Model_Products::getInstance();
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $order_id = $this->getRequest()->getParam('oId');
        $ordersModel = Admin_Model_Orders::getInstance();
        $result = $ordersModel->getAllOrdersById($order_id);
        $productID = json_decode($result['product_id'], true);
        $quantity = json_decode($result['quantity'], true);
        $amount = json_decode($result['product_amount'], true);
        $i = 0;
        foreach ($productID as $productname) {
            $productname = $adminproducts->getProductsById($productname);
            $productnames[$i] = $productname['name'];
            $i++;
        }
        if ($result) {
            $this->view->orderdetails = $result;
            $this->view->productnames = $productnames;
            $this->view->quantity = $quantity;
            $this->view->amount = $amount;
        }
    }

    /*
     * DEV :sowmya
     * Desc : edit Order Details action
     * Date : 31/3/2016
     */

    public function refundRequestAction() {
        
    }

    public function orderAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $objOrdersModel = Admin_Model_Orders::getInstance();
        $objFunctions = Engine_Utilities_Functions::getInstance();
        $userId = $this->view->session->storage->user_id;
        $method = $this->getRequest()->getPost('method');

        switch ($method) {
            case "approveRefundReason":
                $orderId = $this->getRequest()->getPost('orderId');
                $whereForOrderDetails = 'order_id = ' . $orderId;
                $orderDetails = $objOrdersModel->getOrderDetailsWhere($whereForOrderDetails);
                if ($orderDetails) {
                    $updateData = array('updated_date' => new Zend_Db_Expr('CONCAT(`updated_date`,",9-' . time() . '")'), 'order_status' => 9);
                    $updateResult = $objOrdersModel->updateOrderDetails($updateData, $whereForOrderDetails);
                    if ($updateResult) {
                        $notificationMSG = 'Your order #' . $orderId . ' has been refunded.';
                        $noti_url = "/my-orders";
//                        $notificationResult = $objFunctions->sendNotification($userId, $orderDetails['user_id'], $notificationMSG);
                        $notificationResult = $objFunctions->sendNotificationWithUrl($userId, $orderDetails['user_id'], $notificationMSG, $noti_url);
                        echo '1';
                    } else {
                        echo '0';
                    }
                } else {
                    echo '2';
                }
                break;

            case "approveCancelRequest":
                $orderId = $this->getRequest()->getPost('orderId');
                $whereForOrderDetails = ' o.order_id = ' . $orderId;
                $orderDetails = $objOrdersModel->getOrderDetailsWhere($whereForOrderDetails);
                if ($orderDetails) {
                    $updateData = array('updated_date' => new Zend_Db_Expr('CONCAT(`updated_date`,",12-' . time() . '")'), 'order_status' => 12);
                    $notificationMSGForCancel = 'Your order #' . $orderId . ' has been cancelled.';
                    $whereForUpdate = 'order_id=' . $orderId;
                    $updateResult = $objOrdersModel->updateOrderDetails($updateData, $whereForUpdate);
                    if ($updateResult) {
                        $noti_url = "/my-orders";
//                        $notificationResult = $objFunctions->sendNotification($userId, $orderDetails['user_id'], $notificationMSGForCancel);
                        $notificationResult = $objFunctions->sendNotificationWithUrl($userId, $orderDetails['user_id'], $notificationMSGForCancel, $noti_url);
                        echo '1';
                    } else {
                        echo '0';
                    }
                } else {
                    echo '2';
                }
                break;
            default :
                break;
        }
    }

    /**
     * To handle ajax call for order-listing
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     * @since 18-09-2015
     */
    public function orderListingAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $objOrdersModel = Admin_Model_Orders::getInstance();
        $objFunctions = Engine_Utilities_Functions::getInstance();
        $userId = $this->view->session->storage->user_id;
        $method = $this->getRequest()->getPost('method');

        switch ($method) {
            case "allOrders":

                $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);
                $sEcho = intval($_REQUEST['draw']);

                //GET TOTAL NUMBER OF NEW ORDERS
                $where = ' 1 ';
                $iTotalRecords = count($objOrdersModel->getAllOrders($where));
                $iTotalFilteredRecords = $iTotalRecords;

                $records = array();
                $records["data"] = array();

                $columns = array('o.order_id', 'o.order_date', 'email', 'name', 'o.total_amount', 'o.pay_type', 'o.order_status');

                $sortingOrder = "";
                if (isset($_REQUEST['order'])) {
                    $sortingOrder = $columns[$_REQUEST['order'][0]['column'] - 1] . " " . $_REQUEST['order'][0]['dir'];
                }

                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
                    if ($_REQUEST['customActionValue'] != '' && !empty($_REQUEST['orderId'])) {
                        $statusData = array('order_status' => new Zend_Db_Expr('CONCAT(`order_status`,",' . $_REQUEST['customActionValue'] . '-' . time() . '")'), 'order_status' => $_REQUEST['customActionValue']);
                        $whereForStatusUpdate = 'order_id IN (' . implode(',', $_REQUEST['orderId']) . ')';

                        $updateResult = $objOrdersModel->updateOrderDetails($statusData, $whereForStatusUpdate);
                        if ($updateResult) {
                            //NOTIFICATION TO USER FOR ORDER STATUS CHANGE
                            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
                        }
                    }
                }

                //FIRLTERING START FROM HERE
                $filteringRules = '';
                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {
                    if ($_REQUEST['order_id'] != '') {
                        $filteringRules[] = "( o.order_id LIKE '%" . $_REQUEST['order_id'] . "%' )";
                    }
                    if ($_REQUEST['order_date_from'] != '' && $_REQUEST['order_date_to'] != '') {
                        $filteringRules[] = "( o.order_date BETWEEN " . strtotime($_REQUEST['order_date_from']) . " AND " . strtotime($_REQUEST['order_date_to']) . " )";
                    } elseif ($_REQUEST['order_date_from'] != '') {
                        $filteringRules[] = "( o.order_date > " . strtotime($_REQUEST['order_date_from']) . " )";
                    } elseif ($_REQUEST['order_date_to'] != '') {
                        $filteringRules[] = "( o.order_date < " . strtotime($_REQUEST['order_date_to']) . " )";
                    }
                    if ($_REQUEST['order_customer_email'] != '') {
                        $filteringRules[] = "( u.email LIKE '%\"email\":\"%" . $_REQUEST['order_customer_email'] . "%\",\"phone\"%' )";
                    }
                    if ($_REQUEST['product_name'] != '') {
                        $filteringRules[] = "( o.name LIKE '%" . $_REQUEST['product_name'] . "%' )";
                    }
                    if ($_REQUEST['payment_type'] != '') {
                        $filteringRules[] = "( o.pay_type = '" . $_REQUEST['payment_type'] . "' )";
                    }
                    if ($_REQUEST['order_purchase_price_from'] != '' && $_REQUEST['order_purchase_price_to'] != '') {
                        $filteringRules[] = "( o.total_amount BETWEEN " . intval($_REQUEST['order_purchase_price_from']) . " AND " . intval($_REQUEST['order_purchase_price_to']) . " )";
                    } elseif ($_REQUEST['order_purchase_price_from'] != '') {
                        $filteringRules[] = "( o.total_amount > " . intval($_REQUEST['order_purchase_price_from']) . " )";
                    } elseif ($_REQUEST['order_purchase_price_to'] != '') {
                        $filteringRules[] = "( o.total_amount < " . intval($_REQUEST['order_purchase_price_to']) . " )";
                    }
                    if ($_REQUEST['order_status'] != '') {
                        $filteringRules[] = "( o.order_status = " . $_REQUEST['order_status'] . " )";
                    }

                    if (!empty($filteringRules)) {
                        $where.=" AND " . implode(" AND ", $filteringRules);
                        $iTotalFilteredRecords = count($objOrdersModel->getAllOrders($where));
                    }
                }

                $ordersResult = $objOrdersModel->getAllOrders($where, $sortingOrder, $iDisplayLength, $iDisplayStart);

                $status_list = array(
                    0 => array("primary" => "Pending"),
                    1 => array("primary" => "In-Process"),
                    2 => array("success" => "Delivered"),
                    3 => array("danger" => "Cancelled"),
                    4 => array("primary" => "Dispatch"),
                );

                foreach ($ordersResult as $ORkey => $ORvalue) {
                    $paymentType = $ORvalue['pay_type'] == 2 ? 'PayPal' : 'COD';

                    $records["data"][] = array(
                        '<input type="checkbox" name="id[]" value="' . $ORvalue['order_id'] . '">',
                        $ORvalue['order_id'],
                        ($ORvalue['order_date']),
                        $ORvalue['email'],
                        $ORvalue['name'],
                        '<i class="fa fa-rupee"></i>&nbsp;' . $ORvalue['total_amount'],
                        $paymentType,
                        '<span class="label label-sm label-' . (key($status_list[$ORvalue['order_status']])) . '">' . (current($status_list[$ORvalue['order_status']])) . '</span>',
                        '<a href="/admin/view-order/' . $ORvalue['order_id'] . '" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> View</a>',
                    );
                    $userDetails = '';
                }

                $records["draw"] = $sEcho;
                $records["recordsTotal"] = $iTotalRecords;
                $records["recordsFiltered"] = $iTotalFilteredRecords;


                echo json_encode($records);
                break;


            case "newOrders":
                $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);
                $sEcho = intval($_REQUEST['draw']);


                //GET TOTAL NUMBER OF NEW ORDERS
                $where = ' o.order_status IN (1,2,3,10) ';
                $iTotalRecords = count($objOrdersModel->getAllOrders($where));
                $iTotalFilteredRecords = $iTotalRecords;

                $records = array();
                $records["data"] = array();

                $columns = array('o.order_id', 'o.order_date', 'customer_email', 'product_name', 'o.finalprice', 't.tx_type', 'o.order_status');

                $sortingOrder = "";
                if (isset($_REQUEST['order'])) {
                    $sortingOrder = $columns[$_REQUEST['order'][0]['column'] - 1] . " " . $_REQUEST['order'][0]['dir'];
                }

                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
                    $notificationMSG = array();
                    if ($_REQUEST['customActionValue'] != '' && !empty($_REQUEST['orderId'])) {
                        $statusData = array('updated_date' => new Zend_Db_Expr('CONCAT(`updated_date`,",' . $_REQUEST['customActionValue'] . '-' . time() . '")'), 'order_status' => $_REQUEST['customActionValue']);
                        if ($_REQUEST['customActionValue'] == 5 || $_REQUEST['customActionValue'] == 10) {
                            $whereForStatusUpdate = 'order_id IN (' . implode(',', $_REQUEST['orderId']) . ') AND order_status IN (1,2)';

                            if ($_REQUEST['customActionValue'] == 5) {
                                $ordersDetailsForNotification = $objOrdersModel->getAllOrders($whereForStatusUpdate);
                                foreach ($ordersDetailsForNotification as $OIkey => $OIvalue) {
                                    $notificationMSG[][$OIvalue['user_id']] = 'Due to some reason, your order #' . $OIvalue['order_id'] . ' has been cancelled by Admin.';
                                }
                            } elseif ($_REQUEST['customActionValue'] == 10) {
                                $ordersDetailsForNotification = $objOrdersModel->getAllOrders($whereForStatusUpdate);
                                foreach ($ordersDetailsForNotification as $OIkey => $OIvalue) {
                                    $notificationMSG[][$OIvalue['user_id']] = 'Your order #' . $OIvalue['order_id'] . ' has been shipped. It will be delivered by ' . date('D, jS M Y', strtotime('+5 days', time()));
                                }
                            }
                        } elseif ($_REQUEST['customActionValue'] == 6) {
                            $whereForStatusUpdate = 'order_id IN (' . implode(',', $_REQUEST['orderId']) . ') AND order_status = 10';

                            $ordersDetailsToUpdate = $objOrdersModel->getAllOrders($whereForStatusUpdate);

                            foreach ($ordersDetailsToUpdate as $ODkey => $ODvalue) {
                                $transaction_ids.=$ODvalue['tx_id'] . ',';
                                $notificationMSG[][$ODvalue['user_id']] = 'Your order #' . $ODvalue['order_id'] . ' has been delivered.';
                            }
                        } elseif ($_REQUEST['customActionValue'] == 11) {
                            $whereForStatusUpdate = 'order_id IN (' . implode(',', $_REQUEST['orderId']) . ') AND order_status = 3';
                            $ordersDetailsToCancel = $objOrdersModel->getAllOrders($whereForStatusUpdate);
                            foreach ($ordersDetailsToCancel as $OIkey => $OIvalue) {
                                $notificationMSG[][$OIvalue['user_id']] = 'Your order #' . $OIvalue['order_id'] . ' has been cancelled.';
                            }
                        }

                        $updateResult = $objOrdersModel->updateOrderDetails($statusData, $whereForStatusUpdate);
                        if ($updateResult) {
                            //NOTIFICATION TO USER FOR ORDER STATUS CHANGE
                            if (!empty($notificationMSG)) {
                                $noti_url = "/my-orders";
                                foreach ($notificationMSG as $NMkey => $NMvalue) {
//                                    $notificationResult = $objFunctions->sendNotification($userId, key($NMvalue), current($NMvalue));
                                    $notificationResult = $objFunctions->sendNotificationWithUrl($userId, key($NMvalue), current($NMvalue), $noti_url);
                                }
                            }
                            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
                        }
                    }
                }

                //FIRLTERING START FROM HERE
                $filteringRules = '';
                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {
                    if ($_REQUEST['order_id'] != '') {
                        $filteringRules[] = "( o.order_id LIKE '%" . $_REQUEST['order_id'] . "%' )";
                    }
                    if ($_REQUEST['order_date_from'] != '' && $_REQUEST['order_date_to'] != '') {
                        $filteringRules[] = "( o.order_date BETWEEN " . strtotime($_REQUEST['order_date_from']) . " AND " . strtotime($_REQUEST['order_date_to']) . " )";
                    } elseif ($_REQUEST['order_date_from'] != '') {
                        $filteringRules[] = "( o.order_date > " . strtotime($_REQUEST['order_date_from']) . " )";
                    } elseif ($_REQUEST['order_date_to'] != '') {
                        $filteringRules[] = "( o.order_date < " . strtotime($_REQUEST['order_date_to']) . " )";
                    }
                    if ($_REQUEST['order_customer_email'] != '') {
                        $filteringRules[] = "( t.user_details LIKE '%\"useremail\":\"%" . $_REQUEST['order_customer_email'] . "%\",\"userphone\"%' )";
                    }
                    if ($_REQUEST['product_name'] != '') {
                        $filteringRules[] = "( o.productdetails LIKE '%" . $_REQUEST['product_name'] . "%' )";
                    }
                    if ($_REQUEST['payment_type'] != '') {
                        $filteringRules[] = "( t.tx_type = '" . $_REQUEST['payment_type'] . "' )";
                    }
                    if ($_REQUEST['order_purchase_price_from'] != '' && $_REQUEST['order_purchase_price_to'] != '') {
                        $filteringRules[] = "( o.finalprice BETWEEN " . intval($_REQUEST['order_purchase_price_from']) . " AND " . intval($_REQUEST['order_purchase_price_to']) . " )";
                    } elseif ($_REQUEST['order_purchase_price_from'] != '') {
                        $filteringRules[] = "( o.finalprice > " . intval($_REQUEST['order_purchase_price_from']) . " )";
                    } elseif ($_REQUEST['order_purchase_price_to'] != '') {
                        $filteringRules[] = "( o.finalprice < " . intval($_REQUEST['order_purchase_price_to']) . " )";
                    }
                    if ($_REQUEST['order_status'] != '') {
                        $filteringRules[] = "( o.order_status = " . $_REQUEST['order_status'] . " )";
                    }

                    if (!empty($filteringRules)) {
                        $where.=" AND " . implode(" AND ", $filteringRules);
                        $iTotalFilteredRecords = count($objOrdersModel->getAllOrders($where));
                    }
                }

                $ordersResult = $objOrdersModel->getAllOrders($where, $sortingOrder, $iDisplayLength, $iDisplayStart);

                $status_list = array(
                    1 => array("success" => "TXN Success"),
                    2 => array("primary" => "In Process"),
                    3 => array("warning" => "Cancel Request"),
                    10 => array("info" => "Shipping")
                );

                foreach ($ordersResult as $ORkey => $ORvalue) {
                    $productName = explode(',', $ORvalue['productdetails']);
                    $paymentType = $ORvalue['tx_type'] == 1 ? 'PayU Money' : 'COD';
                    $userDetails = json_decode($ORvalue['user_details'], true);
                    $checkBoxField = '';
                    if ($ORvalue['order_status'] != 1) {
                        $checkBoxField = '<input type="checkbox" name="id[]" value="' . $ORvalue['order_id'] . '">';
                    }
                    $records["data"][] = array(
                        $checkBoxField,
                        $ORvalue['order_id'],
                        date('d-m-y', $ORvalue['order_date']),
                        $userDetails['useremail'],
                        $productName[0],
                        '<i class="fa fa-rupee"></i>&nbsp;' . $ORvalue['finalprice'],
                        $paymentType,
                        '<span class="label label-sm label-' . (key($status_list[$ORvalue['order_status']])) . '">' . (current($status_list[$ORvalue['order_status']])) . '</span>',
                        '<a href="/admin/view-order/' . $ORvalue['order_id'] . '" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> View</a>',
                    );
                    $userDetails = '';
                }

                $records["draw"] = $sEcho;
                $records["recordsTotal"] = $iTotalRecords;
                $records["recordsFiltered"] = $iTotalFilteredRecords;

                echo json_encode($records);
                break;

            case "refundRequest":
                $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);
                $sEcho = intval($_REQUEST['draw']);


                //GET TOTAL NUMBER OF NEW ORDERS
                $where = ' o.order_status IN (7,8) ';
                $iTotalRecords = count($objOrdersModel->getAllOrders($where));
                $iTotalFilteredRecords = $iTotalRecords;

                $records = array();
                $records["data"] = array();

                $columns = array('o.order_id', 'o.order_date', 'customer_email', 'product_name', 'o.finalprice', 't.tx_type', 'o.order_status');

                $sortingOrder = "";
                if (isset($_REQUEST['order'])) {
                    $sortingOrder = $columns[$_REQUEST['order'][0]['column'] - 1] . " " . $_REQUEST['order'][0]['dir'];
                }

                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
                    $notificationMSG = array();
                    if ($_REQUEST['customActionValue'] != '' && !empty($_REQUEST['orderId'])) {
                        $statusData = array('updated_date' => new Zend_Db_Expr('CONCAT(`updated_date`,",' . $_REQUEST['customActionValue'] . '-' . time() . '")'), 'order_status' => $_REQUEST['customActionValue']);
                        if ($_REQUEST['customActionValue'] == 9) {
                            $whereForStatusUpdate = 'order_id IN (' . implode(',', $_REQUEST['orderId']) . ') AND order_status = 8';
                            $ordersDetailsToRefundDone = $objOrdersModel->getAllOrders($whereForStatusUpdate);
                            foreach ($ordersDetailsToRefundDone as $OIkey => $OIvalue) {
                                $notificationMSG[][$OIvalue['user_id']] = 'Your order #' . $OIvalue['order_id'] . ' has been refunded.';
                            }
                        }
                        //IMPORTANT: NOT YET COMPLETE, PAYMENT NEED TO BE DONE
                        $updateResult = $objOrdersModel->updateOrderDetails($statusData, $whereForStatusUpdate);
                        if ($updateResult) {
                            //NOTIFICATION TO USER FOR ORDER STATUS CHANGE
                            if (!empty($notificationMSG)) {
                                $noti_url = "/my-orders";
                                foreach ($notificationMSG as $NMkey => $NMvalue) {
//                                    $notificationResult = $objFunctions->sendNotification($userId, key($NMvalue), current($NMvalue));
                                    $notificationResult = $objFunctions->sendNotificationWithUrl($userId, key($NMvalue), current($NMvalue), $noti_url);
                                }
                            }
                            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
                        }
                    }
                }

                //FIRLTERING START FROM HERE
                $filteringRules = '';
                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {
                    if ($_REQUEST['order_id'] != '') {
                        $filteringRules[] = "( o.order_id LIKE '%" . $_REQUEST['order_id'] . "%' )";
                    }
                    if ($_REQUEST['order_date_from'] != '' && $_REQUEST['order_date_to'] != '') {
                        $filteringRules[] = "( o.order_date BETWEEN " . strtotime($_REQUEST['order_date_from']) . " AND " . strtotime($_REQUEST['order_date_to']) . " )";
                    } elseif ($_REQUEST['order_date_from'] != '') {
                        $filteringRules[] = "( o.order_date > " . strtotime($_REQUEST['order_date_from']) . " )";
                    } elseif ($_REQUEST['order_date_to'] != '') {
                        $filteringRules[] = "( o.order_date < " . strtotime($_REQUEST['order_date_to']) . " )";
                    }
                    if ($_REQUEST['order_customer_email'] != '') {
                        $filteringRules[] = "( t.user_details LIKE '%\"useremail\":\"%" . $_REQUEST['order_customer_email'] . "%\",\"userphone\"%' )";
                    }
                    if ($_REQUEST['product_name'] != '') {
                        $filteringRules[] = "( o.productdetails LIKE '%" . $_REQUEST['product_name'] . "%' )";
                    }
                    if ($_REQUEST['payment_type'] != '') {
                        $filteringRules[] = "( t.tx_type = '" . $_REQUEST['payment_type'] . "' )";
                    }
                    if ($_REQUEST['order_purchase_price_from'] != '' && $_REQUEST['order_purchase_price_to'] != '') {
                        $filteringRules[] = "( o.finalprice BETWEEN " . intval($_REQUEST['order_purchase_price_from']) . " AND " . intval($_REQUEST['order_purchase_price_to']) . " )";
                    } elseif ($_REQUEST['order_purchase_price_from'] != '') {
                        $filteringRules[] = "( o.finalprice > " . intval($_REQUEST['order_purchase_price_from']) . " )";
                    } elseif ($_REQUEST['order_purchase_price_to'] != '') {
                        $filteringRules[] = "( o.finalprice < " . intval($_REQUEST['order_purchase_price_to']) . " )";
                    }
                    if ($_REQUEST['order_status'] != '') {
                        $filteringRules[] = "( o.order_status = " . $_REQUEST['order_status'] . " )";
                    }

                    if (!empty($filteringRules)) {
                        $where.=" AND " . implode(" AND ", $filteringRules);
                        $iTotalFilteredRecords = count($objOrdersModel->getAllOrders($where));
                    }
                }

                $ordersResult = $objOrdersModel->getAllOrders($where, $sortingOrder, $iDisplayLength, $iDisplayStart);

                $status_list = array(
                    7 => array("success" => "Refund Request"),
                    8 => array("primary" => "Refund In-Process"),
                );

                foreach ($ordersResult as $ORkey => $ORvalue) {
                    $productName = explode(',', $ORvalue['productdetails']);
                    $paymentType = $ORvalue['tx_type'] == 1 ? 'PayU Money' : 'COD';
                    $userDetails = json_decode($ORvalue['user_details'], true);
                    $checkBoxField = '';
                    $reasonField = '';
                    if ($ORvalue['tx_type'] == 1) {
                        $checkBoxField = '<input type="checkbox" name="id[]" value="' . $ORvalue['order_id'] . '">';
                        $reasonField = '<a href="#modal-reason" data-toggle="modal" class="btn btn-xs default refund-reason" order-id="' . $ORvalue['order_id'] . '" refund-reason="' . $ORvalue['cancel_refund_reason'] . '"><i class="fa fa-search"></i>Reason</a>';
                    }

                    $records["data"][] = array(
                        $checkBoxField,
                        $ORvalue['order_id'],
                        date('d-m-y', $ORvalue['order_date']),
                        $userDetails['useremail'],
                        $productName[0],
                        '<i class="fa fa-rupee"></i>&nbsp;' . $ORvalue['finalprice'],
                        $paymentType,
                        '<span class="label label-sm label-' . (key($status_list[$ORvalue['order_status']])) . '">' . (current($status_list[$ORvalue['order_status']])) . '</span>',
                        '<a href="/admin/view-order/' . $ORvalue['order_id'] . '" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> View</a>'
                        . $reasonField,
                    );
                    $userDetails = '';
                }

                $records["draw"] = $sEcho;
                $records["recordsTotal"] = $iTotalRecords;
                $records["recordsFiltered"] = $iTotalFilteredRecords;
                header('Content-type: application/json');
                echo json_encode($records);
                break;


            case "cancelRequest":
                $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);
                $sEcho = intval($_REQUEST['draw']);


                //GET TOTAL NUMBER OF NEW ORDERS
                $where = ' o.order_status IN (3,11) AND t.tx_type=1';
                $iTotalRecords = count($objOrdersModel->getAllOrders($where));
                $iTotalFilteredRecords = $iTotalRecords;

                $records = array();
                $records["data"] = array();

                $columns = array('o.order_id', 'o.order_date', 'customer_email', 'product_name', 'o.finalprice', 't.tx_type', 'o.order_status');

                $sortingOrder = "";
                if (isset($_REQUEST['order'])) {
                    $sortingOrder = $columns[$_REQUEST['order'][0]['column'] - 1] . " " . $_REQUEST['order'][0]['dir'];
                }

                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
                    $notificationMSG = array();
                    if ($_REQUEST['customActionValue'] != '' && !empty($_REQUEST['orderId'])) {
                        $statusData = array('updated_date' => new Zend_Db_Expr('CONCAT(`updated_date`,",' . $_REQUEST['customActionValue'] . '-' . time() . '")'), 'order_status' => $_REQUEST['customActionValue']);
                        if ($_REQUEST['customActionValue'] == 12) {
                            $whereForStatusUpdate = 'order_id IN (' . implode(',', $_REQUEST['orderId']) . ') AND order_status  IN (3,11) ';
                            $ordersDetailsToCancel = $objOrdersModel->getAllOrders($whereForStatusUpdate);
                            foreach ($ordersDetailsToCancel as $OIkey => $OIvalue) {
                                $notificationMSG[][$OIvalue['user_id']] = 'Your order #' . $OIvalue['order_id'] . ' has been cancelled.';
                            }
                        }

                        $updateResult = $objOrdersModel->updateOrderDetails($statusData, $whereForStatusUpdate);
                        if ($updateResult) {
                            //NOTIFICATION TO USER FOR ORDER STATUS CHANGE
                            if (!empty($notificationMSG)) {
                                $noti_url = "/my-orders";
                                foreach ($notificationMSG as $NMkey => $NMvalue) {
//                                    $notificationResult = $objFunctions->sendNotification($userId, key($NMvalue), current($NMvalue));
                                    $notificationResult = $objFunctions->sendNotificationWithUrl($userId, key($NMvalue), current($NMvalue), $noti_url);
                                }
                            }
                            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
                        }
                    }
                }

                //FIRLTERING START FROM HERE
                $filteringRules = '';
                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {
                    if ($_REQUEST['order_id'] != '') {
                        $filteringRules[] = "( o.order_id LIKE '%" . $_REQUEST['order_id'] . "%' )";
                    }
                    if ($_REQUEST['order_date_from'] != '' && $_REQUEST['order_date_to'] != '') {
                        $filteringRules[] = "( o.order_date BETWEEN " . strtotime($_REQUEST['order_date_from']) . " AND " . strtotime($_REQUEST['order_date_to']) . " )";
                    } elseif ($_REQUEST['order_date_from'] != '') {
                        $filteringRules[] = "( o.order_date > " . strtotime($_REQUEST['order_date_from']) . " )";
                    } elseif ($_REQUEST['order_date_to'] != '') {
                        $filteringRules[] = "( o.order_date < " . strtotime($_REQUEST['order_date_to']) . " )";
                    }
                    if ($_REQUEST['order_customer_email'] != '') {
                        $filteringRules[] = "( t.user_details LIKE '%\"useremail\":\"%" . $_REQUEST['order_customer_email'] . "%\",\"userphone\"%' )";
                    }
                    if ($_REQUEST['product_name'] != '') {
                        $filteringRules[] = "( o.productdetails LIKE '%" . $_REQUEST['product_name'] . "%' )";
                    }
                    if ($_REQUEST['payment_type'] != '') {
                        $filteringRules[] = "( t.tx_type = '" . $_REQUEST['payment_type'] . "' )";
                    }
                    if ($_REQUEST['order_purchase_price_from'] != '' && $_REQUEST['order_purchase_price_to'] != '') {
                        $filteringRules[] = "( o.finalprice BETWEEN " . intval($_REQUEST['order_purchase_price_from']) . " AND " . intval($_REQUEST['order_purchase_price_to']) . " )";
                    } elseif ($_REQUEST['order_purchase_price_from'] != '') {
                        $filteringRules[] = "( o.finalprice > " . intval($_REQUEST['order_purchase_price_from']) . " )";
                    } elseif ($_REQUEST['order_purchase_price_to'] != '') {
                        $filteringRules[] = "( o.finalprice < " . intval($_REQUEST['order_purchase_price_to']) . " )";
                    }
                    if ($_REQUEST['order_status'] != '') {
                        $filteringRules[] = "( o.order_status = " . $_REQUEST['order_status'] . " )";
                    }

                    if (!empty($filteringRules)) {
                        $where.=" AND " . implode(" AND ", $filteringRules);
                        $iTotalFilteredRecords = count($objOrdersModel->getAllOrders($where));
                    }
                }

                $ordersResult = $objOrdersModel->getAllOrders($where, $sortingOrder, $iDisplayLength, $iDisplayStart);

                $status_list = array(
                    3 => array("warning" => "Cancel Request"),
                    11 => array("info" => "Cancel In-Process")
                );

                foreach ($ordersResult as $ORkey => $ORvalue) {
                    $productName = explode(',', $ORvalue['productdetails']);
                    $paymentType = $ORvalue['tx_type'] == 1 ? 'PayU Money' : 'COD';
                    $userDetails = json_decode($ORvalue['user_details'], true);
                    $checkBoxField = '';
                    $reasonField = '';
//                    if ($ORvalue['order_status'] != 1) {
                    $checkBoxField = '<input type="checkbox" name="id[]" value="' . $ORvalue['order_id'] . '">';
                    $reasonField = '<a href="#modal-reason" data-toggle="modal" class="btn btn-xs default cancel-reason" order-id="' . $ORvalue['order_id'] . '" cancel-reason="' . $ORvalue['cancel_refund_reason'] . '"><i class="fa fa-search"></i>Reason</a>';
//                    }
                    $records["data"][] = array(
                        $checkBoxField,
                        $ORvalue['order_id'],
                        date('d-m-y', $ORvalue['order_date']),
                        $userDetails['useremail'],
                        $productName[0],
                        '<i class="fa fa-rupee"></i>&nbsp;' . $ORvalue['finalprice'],
                        $paymentType,
                        '<span class="label label-sm label-' . (key($status_list[$ORvalue['order_status']])) . '">' . (current($status_list[$ORvalue['order_status']])) . '</span>',
                        '<a href="/admin/view-order/' . $ORvalue['order_id'] . '" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> View</a>' . $reasonField,
                    );
                    $userDetails = '';
                }

                $records["draw"] = $sEcho;
                $records["recordsTotal"] = $iTotalRecords;
                $records["recordsFiltered"] = $iTotalFilteredRecords;

                echo json_encode($records);
                break;
            default :
                break;
        }
    }

    public function viewOrderAction() {
        $objOrdersModel = Admin_Model_Orders::getInstance();
        $orderId = $this->getRequest()->getParam('orderId');

        $where = 'o.order_id=' . $orderId . ' AND  o.order_status !=0 ';
        $orderDetails = $objOrdersModel->getOrderDetailsWhere($where);
        if ($orderDetails) {
            $status_list = array(
                0 => array("primary" => "Pending"),
                1 => array("primary" => "In-Process"),
                2 => array("success" => "Delivered"),
                3 => array("danger" => "Cancelled"),
                4 => array("primary" => "Dispatch"),
            );

            $orderDetails['status_class'] = key($status_list[$orderDetails['order_status']]);
            $orderDetails['status'] = current($status_list[$orderDetails['order_status']]);
            $pay_status = array(
                0 => array("primary" => "Pending"),
                1 => array("success" => "Completed"),
                2 => array("primary" => "Failed"),
                3 => array("danger" => "Canceled"),
            );

            $orderDetails['pay_status_class'] = key($pay_status[$orderDetails['pay_status']]);
            $orderDetails['pay_status'] = current($pay_status[$orderDetails['pay_status']]);
            $delivery_status = array(
                0 => array("primary" => "Pending"),
                1 => array("success" => "Complete"),
                2 => array("danger" => "Returned/Canceled"),
                3 => array("primary" => "Unable to reach"),
            );

            $orderDetails['delivery_status_class'] = key($delivery_status[$orderDetails['delivery_status']]);
            $orderDetails['delivery_status'] = current($delivery_status[$orderDetails['delivery_status']]);
            $this->view->orderDetails = $orderDetails;
        } else {
            $this->view->orderErrorMsg = 'Sorry, no order detail found with the given Order-Id';
        }
    }

    /* dev : sowmya     
     * date : 29/3/2016
     * details: get all store order details */

    public function storeOrderDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $ordersModel = Admin_Model_Orders::getInstance();
        $result = $ordersModel->getAllStoreOrder();
        if ($result) {
            $pendingArr = $adminArr = $cancelledArr = array();
            foreach ($result as $key => $value) {
                if ($value['order_status'] == 0) {
                    $pendingArr[] = $value;
                } elseif ($value['order_status'] == 1) {
                    $adminArr[] = $value;
                } else if ($value['order_status'] == 2) {
                    $deliveredArr[] = $value;
                } else if ($value['order_status'] == 6) {
                    $cancelledArr[] = $value;
                }
            }
            $this->view->pendingStatus = $pendingArr;
            $this->view->processStatus = $adminArr;
            $this->view->canceledStatus = $cancelledArr;
        } else {
            echo 'controller error occured';
        }
        $this->view->orderdetails = $result;
    }
    
    /*
     * DEV :sowmya
     * Desc : view  store Order Details action
     * Date : 21/3/2016
     */

    public function viewStoreOrderDetailsAction() {
        $adminproducts = Admin_Model_Products::getInstance();
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $order_id = $this->getRequest()->getParam('oId');
        $ordersModel = Admin_Model_Orders::getInstance();
        $result = $ordersModel->getAllStoreOrdersById($order_id);
        $productID = json_decode($result['product_id'], true);
        $quantity = json_decode($result['quantity'], true);
        $amount = json_decode($result['product_amount'], true);
        $i = 0;
        foreach ($productID as $productname) {
            $productname = $adminproducts->getProductsById($productname);
            $productnames[$i] = $productname['name'];
            $i++;
        }
        if ($result) {
            $this->view->orderdetails = $result;
            $this->view->productnames = $productnames;
            $this->view->quantity = $quantity;
            $this->view->amount = $amount;
        }
    }
}
