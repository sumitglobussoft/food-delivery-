<?php

/**
 * Coupons Controller
 * @author Sowmya <sowmya@globussoft.in>
 */
require_once 'Zend/Controller/Action.php';

class Admin_CouponsController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function addNewCouponAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $objModelCoupons = Admin_Model_Coupons::getInstance();
        if ($this->getRequest()->isPost()) {

            $availability = $this->getRequest()->getPost('availability');
            $availabilityValue = $this->getRequest()->getPost('availabilityno');
            $discountType = $this->getRequest()->getPost('discounttype');
            $flatDiscount = $this->getRequest()->getPost('flatdiscount');
            $percentageDiscount = $this->getRequest()->getPost('percentagediscount');
            $availableFrom = $this->getRequest()->getPost('availablefromdate');
            $availableTo = $this->getRequest()->getPost('availableuptodate');

            $validFrom = strtotime(str_replace("-", "", $availableFrom));
            $validTo = strtotime(str_replace("-", "", $availableTo));

            $data = array();

            if ($availability == 'on') {
                $data['availability'] = 1;
                $data['availability_value'] = $availabilityValue;
            } else {
                $data['availability'] = 0;
                $data['availability_value'] = 0;
            }

            if ($discountType == 0) {
                $data['discount_type'] = 0;
                $data['discount_value'] = $percentageDiscount;
            } elseif ($discountType == 1) {
                $data['discount_type'] = 1;
                $data['discount_value'] = $flatDiscount;
            }
            $data['coupon_valid_from'] = $validFrom;
            $data['coupon_valid_upto'] = $validTo;
            $data['coupon_status'] = 1;

            $data['coupon_code'] = $this->getRequest()->getPost('couponCode');

            $where = "coupon_code = '" . $data['coupon_code'] . "'";
            $result = $objModelCoupons->getCouponWhere($where);
            if ($result == '') {
                $added = $objModelCoupons->addNewCoupon($data);
                if ($added) {
                    $this->view->successMsg = "New coupon '" . $data['coupon_code'] . "' added successfully.";
                } else {
                    $this->view->errorMsg = "Something went wrong. Please try again later..";
                }
            } else {
                $this->view->errorMsg = "Specific coupon code already exists.";
            }
        }
    }

    public function manageCouponsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $objModelCoupons = Admin_Model_Coupons::getInstance();
        $allCoupons = $objModelCoupons->getCoupons();
        $this->view->allcoupons = $allCoupons;
    }

    public function editCouponAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $objModelCoupons = Admin_Model_Coupons::getInstance();
        $couponId = $this->getRequest()->getParam('couponId');

        $where = "coupon_id = '" . $couponId . "'";
        $result = $objModelCoupons->getCouponWhere($where);
        if ($result) {
            $this->view->couponDetails = $result;
        } else {
            $this->view->couponErrorMsg = "No Coupon found with the given Coupon ID.";
        }

        if ($this->getRequest()->isPost()) {
            $availability = $this->getRequest()->getPost('availability');
            $availabilityValue = $this->getRequest()->getPost('availabilityno');
            $discountType = $this->getRequest()->getPost('discounttype');
            $flatDiscount = $this->getRequest()->getPost('flatdiscount');
            $percentageDiscount = $this->getRequest()->getPost('percentagediscount');
            $availableFrom = $this->getRequest()->getPost('availablefromdate');
            $availableTo = $this->getRequest()->getPost('availableuptodate');

            $validFrom = strtotime(str_replace("-", "", $availableFrom));
            $validTo = strtotime(str_replace("-", "", $availableTo));

            $data = array();

            if ($availability == 'on') {
                $data['availability'] = 1;
                $data['availability_value'] = $availabilityValue;
            } else {
                $data['availability'] = 0;
                $data['availability_value'] = 0;
            }

            if ($discountType == 0) {
                $data['discount_type'] = 0;
                $data['discount_value'] = $percentageDiscount;
            } elseif ($discountType == 1) {
                $data['discount_type'] = 1;
                $data['discount_value'] = $flatDiscount;
            }
            $data['coupon_valid_from'] = $validFrom;
            $data['coupon_valid_upto'] = $validTo;
            $data['coupon_code'] = $this->getRequest()->getPost('couponCode');

            $whereForCoupon = 'coupon_id=' . $couponId;
            $result = $objModelCoupons->getCouponWhere($whereForCoupon);
            if ($result) {
                $updated = $objModelCoupons->updateCouponDetails($data, $whereForCoupon);
                if ($updated) {
                    $updatedResult = $objModelCoupons->getCouponWhere($whereForCoupon);
                    $this->view->couponDetails = $updatedResult;
                    $this->view->successMsg = "Coupon updated successfully.";
                }
            }
        }
    }

    public function couponsLogAction() {
        $adminproducts = Admin_Model_Products::getInstance();
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $objModelCouponUsers = Admin_Model_CouponUsers::getInstance();
        $couponsLog = $objModelCouponUsers->getCouponsLog();
        $j = 0;
//        ---------code to convert json encoded product_id's to product names-----------
        foreach ($couponsLog as $value) {
            $value1 = json_decode($value['product_id'], true);
            for ($i = 0; $i < count($value1); $i++) {
                $productname = $value1[$i];
                $productname = $adminproducts->getProductsById($productname);
                $productnames[$i] = $productname['name'];
            }
            $couponsLog[$j]['product_id'] = $productnames;
            $j++;
        }
//        -------------------------------------------------------------------------------------
//        $couponsLog = array_map(function($coupon) {
//            $coupon['product_id'] = explode(',', str_replace('"', '', rtrim(ltrim($coupon['product_id'], '['), ']')));
//            return $coupon;
//        }, $couponsLog);
        $this->view->couponsLog = $couponsLog;
    }

    public function couponsAjaxHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $objModelCoupons = Admin_Model_Coupons::getInstance();
        $objModelCouponUsers = Admin_Model_CouponUsers::getInstance();
        $method = $this->getRequest()->getPost('method');
        switch ($method) {
            case 'checkForCouponCode':
                $couponCode = $this->getRequest()->getPost('couponCode');
                $mode = $this->getRequest()->getPost('modeName');
                $originalCouponCode = $this->getRequest()->getPost('originalCouponCode');
                $wherForCoupon = "coupon_code='" . $couponCode . "'";
                $couponResult = $objModelCoupons->getCouponWhere($wherForCoupon);
                if ($mode === 'edit') {
                    if ($couponCode == $originalCouponCode) {
                        echo "true";
                        break;
                    } else if ($couponResult) {
                        echo "false";
                    } else {
                        echo "true";
                    }
                } else if ($couponResult) {
                    echo "false";
                } else {
                    echo "true";
                }
                break;

            case "changeCouponStatus":
                $couponId = $this->getRequest()->getParam('couponId');
                $changed = $objModelCoupons->getstatustodeactivate($couponId);
                if ($changed) {
                    echo $couponId;
                } else {
                    echo "error";
                }
                break;

            case 'deleteCoupon':
                $couponId = $this->getRequest()->getParam('couponId');
                $result = $objModelCoupons->coupondelete($couponId);

                if ($result) {
                    echo $result;
                } else {
                    echo "error";
                }
                break;
            case 'deleteCouponUser':
                $couponId = $this->getRequest()->getParam('couponuserId');
                $result = $objModelCouponUsers->couponuserdelete($couponId);

                if ($result) {
                    echo $result;
                } else {
                    echo "error";
                }
                break;
            default:
                break;
        }
    }

}
