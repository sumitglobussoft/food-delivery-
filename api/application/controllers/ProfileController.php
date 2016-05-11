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

    /*
     * DEV :sowmya
     * Desc : functionality of profile module of agent panel
     * Date : 5/5/2016
     */

    public function profileSummaryAction() {
        $location = Application_Model_location::getInstance();
        $menu_category = Application_Model_MenuCategory::getInstance();
        $famouscuisines = Application_Model_FamousCuisines::getInstance();
        $hotelModel = Application_Model_HotelDetails::getInstance();
        $hotelCuisinesModel = Application_Model_HotelCuisines::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {
                /*
                 * DEV :sowmya
                 * Desc : to add country
                 * Date : 5/5/2016
                 */
                case'addcountry':

                    if ($this->getRequest()->isPost()) {
                        $data['name'] = $this->getRequest()->getPost('name');
                        $data['location_status'] = $this->getRequest()->getPost('location_status');
                        $data['location_type'] = $this->getRequest()->getPost('location_type');
                        $data['parent_id'] = $this->getRequest()->getPost('parent_id');
                        $addcountry = $location->addcountry($data);

                        if ($addcountry) {
                            $response->code = 200;
                            $response->message = "added Successful";
                            $response->data = $addcountry;
                        } else {
                            $response->code = 100;
                            $response->message = "Invalid Password format";
                            $response->data = null;
                        }
                        echo json_encode($response, true);
                    }
                    break;
                /*
                 * DEV :sowmya
                 * Desc : to change location status
                 * Date : 5/5/2016
                 */
                case'locationactive':

                    if ($this->getRequest()->isPost()) {
                        $locationid = $this->getRequest()->getPost('locationid');
                        $addcountry = $location->changeLocationStatus($locationid);

                        if ($addcountry) {
                            $response->code = 200;
                            $response->message = "added Successful";
                            $response->data = $locationid;
                        } else {
                            $response->code = 100;
                            $response->message = "Invalid Password format";
                            $response->data = null;
                        }
                        echo json_encode($response, true);
                    }
                    break;
                /*
                 * DEV :sowmya
                 * Desc : to update country
                 * Date : 5/5/2016
                 */
                case 'editcountry':
                    $data['name'] = $this->getRequest()->getPost('name');
                    $locationid = $this->getRequest()->getPost('location_id');
                    $result = $location->updateLocation($data, $locationid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;
                /*
                 * DEV :sowmya
                 * Desc : to delete country 
                 * Date : 5/5/2016
                 */
                case 'countrydelete':
                    $locationid = $this->getRequest()->getPost('locationid');
                    $result = $location->countryDelete($locationid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        echo "error";
                    }
                    break;
                /*
                 * DEV :sowmya
                 * Desc : to get location details
                 * Date : 5/5/2016
                 */
                case 'getlocation':
                    $locationid = $this->getRequest()->getParam('locationid');
                    $result = $location->getLocationsByLocationId($locationid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;

                /*
                 * DEV :sowmya
                 * Desc : to get hotel category details
                 * Date : 5/5/2016
                 */
                case 'getCategories':
                    $result = $menu_category->selectAllCategory();
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;

                //Dev:sreekanth
                //Date: 4-may-16
                //get hotel categories By CategoryId
                case 'getcategoriesByCategoryId':
                    $categoryid = $this->getRequest()->getParam('categoryid');
                    $result = $menu_category->getcategoriesByCategoryId($categoryid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;
//Dev:sreekanth
//Date: 5-may-16
                //edit hotel category
                case 'editcategory':
                    $data['cat_name'] = $this->getRequest()->getPost('categoryname');
                    $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
                    $categoryid = $this->getRequest()->getPost('category_id');
                    $result = $menu_category->updateCategory($data, $categoryid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;

//Dev:sreekanth
//Date: 5-may-16
                // to delete hotel category
                case 'hotelcategorydelete':
                    $categoryid = $this->getRequest()->getPost('categoryid');
                    $result = $menu_category->hotelcategorydelete($categoryid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        echo "error";
                    }
                    break;

//Dev:sreekanth
//Date: 5-may-16
                // to add hotel category
                case 'addhotelcategory':
                    $data['cat_name'] = $this->getRequest()->getPost('categoryname');
                    $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
                    $data['cat_status'] = $this->getRequest()->getPost('cat_status');
                    $result = $menu_category->addhotelcategory($data);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;
                //Dev:sreekanth
                //Date: 5-may-16
                // desc :to get hotel cuisines
                case 'getCuisines':
                    $cuisines = $famouscuisines->selectAllCuisines();
                    $hotel = $hotelModel->selectAllHotels();
                    if ($cuisines) {
                        $data[0] = $cuisines;
                        $data[1] = $hotel;
                        $arr['code'] = 200;
                        $arr['data'] = $data;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['cuisines'] = $cuisines;
                        $arr['hotel'] = $hotel;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;

                //Dev:sreekanth
//Date: 6-may-16
                // to delete hotel cuisines
                case 'hotelcuisinedelete':
                    $cuisine_id = $this->getRequest()->getPost('cuisine_id');
                    $result = $famouscuisines->hotelcuisinedelete($cuisine_id);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        echo "error";
                    }
                    break;

//Dev:sreekanth
//Date: 5-may-16
                // add  cuisines details
                case 'addCuisinesDetails':
                    $data['Cuisine_name'] = $this->getRequest()->getPost('Cuisine_name');
                    $data['cuisine_status'] = $this->getRequest()->getPost('cuisine_status');
                    $result = $famouscuisines->addCuisinesDetails($data);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;
//Dev:sreekanth
//Date: 5-may-16
                // to add hotel cuisines
                case 'addhotelcuisines':
                    $data['cuisine_id'] = $this->getRequest()->getPost('cuisine_id');
                    $data['hotel_id'] = $this->getRequest()->getPost('hotel_id');
                    $result = $hotelCuisinesModel->addhotelcuisines($data);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;

                //Dev:sreekanth
//Date: 5-may-16
//edit hotel cuisines
                case 'edithotelcuisines':
                    $data['Cuisine_name'] = $this->getRequest()->getPost('Cuisine_name');
                    $cuisineid = $this->getRequest()->getPost('cuisine_id');
                    $result = $famouscuisines->updateHotelCuisines($data, $cuisineid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr, true);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['data'] = null;
                        echo json_encode($arr, true);
                        die();
                    }
                    break;
            }
        }
    }

}
