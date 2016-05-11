<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_SettingsController extends Zend_Controller_Action {

    public function init() {
        
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch countrys from db
     * date : 13/1/2015;
     */

    public function countriesDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $locationsModel = Admin_Model_Location::getInstance();

        $countrys = $locationsModel->getCountrys();
        if ($countrys) {

            $this->view->countriesdetails = $countrys;
        }

        if ($this->getRequest()->isPost()) {

            $data['name'] = $this->getRequest()->getPost('name');
            $data['location_status'] = $this->getRequest()->getPost('location_status');
            $data['location_type'] = 0;
            $data['parent_id'] = 0;

            $result = $locationsModel->addLocation($data);
            if ($result) {
                $this->redirect('/admin/countries-details');
            }
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch states from db
     * date : 13/1/2015;
     */

    public function statesDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $locationsModel = Admin_Model_Location::getInstance();

        $states = $locationsModel->getStates();
        if ($states) {
            $this->view->statesdetails = $states;
        }
        $countrieslist = $locationsModel->getCountrys();
        if ($countrieslist) {
            $this->view->countrieslist = $countrieslist;
        }
        if ($this->getRequest()->isPost()) {
            $country = $this->getRequest()->getPost('coutries');
            $data['name'] = $this->getRequest()->getPost('statename');
            $data['location_status'] = $this->getRequest()->getPost('location_status');
            $data['location_type'] = 1;
            if ($country) {
                $data['parent_id'] = $country;
            }

            $result = $locationsModel->addLocation($data);
            if ($result) {

                $this->redirect('/admin/states-details');
            }
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch citys from db
     * date : 13/1/2015;
     */

    public function cityDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $locationsModel = Admin_Model_Location::getInstance();
        $citys = $locationsModel->getCitys();
        if ($citys) {
            $this->view->citiesdetails = $citys;
        }
        $countrieslist = $locationsModel->getCountrys();
        if ($countrieslist) {
            $this->view->countrieslist = $countrieslist;
        }

        if ($this->getRequest()->isPost()) {
            $state = $this->getRequest()->getPost('state');
            $country = $this->getRequest()->getPost('country');
            $data['name'] = $this->getRequest()->getPost('cityname');
            $data['location_status'] = $this->getRequest()->getPost('location_status');
            $data['location_type'] = 2;
            $data['parent_id'] = $state;
            $result = $locationsModel->addLocationByParentID($data, $country);
            if ($result) {
                if (is_null($result)) {
                    $this->redirect('/admin/city-details');
                } else {
                    $this->redirect('/admin/city-details');
                }
            }
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch locations from db
     * date : 13/1/2015;
     */

    public function locationDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $locationsModel = Admin_Model_Location::getInstance();
        $locations = $locationsModel->getLocations();
        if ($locations) {
            $this->view->locationdetails = $locations;
        }
        $countrieslist = $locationsModel->getCountrys();
        if ($countrieslist) {
            $this->view->countrieslist = $countrieslist;
        }
        if ($this->getRequest()->isPost()) {
            $country = $this->getRequest()->getPost('country');
            $state = $this->getRequest()->getPost('state');
            $city = $this->getRequest()->getPost('city');
            $data['name'] = $this->getRequest()->getPost('locationname');
            $data['location_status'] = $this->getRequest()->getPost('location_status');
            $data['location_type'] = 3;
            if ($city) {
                $data['parent_id'] = $city;
            }
            $result = $locationsModel->addLocationByParentIds($data, $state, $country);
            if ($result) {
                $this->redirect('/admin/location-details');
            }
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch locations from db
     * date : 13/1/2015;
     */

    public function locationsettingsHandlerAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $locationsModel = Admin_Model_Location::getInstance();
        $cuisinesModel = Admin_Model_FamousCuisines::getInstance();
        $categoryModel = Admin_Model_MenuCategory::getInstance();
        $storeCategoryModel = Admin_Model_StoreCategory::getInstance();
        $hotelcuisinesModel = Admin_Model_HotelCuisines::getInstance();
        if ($this->getRequest()->isPost()) {
            $method = $this->getRequest()->getParam('method');

            switch ($method) {
                case 'FetchSatesByCountryId':
                    $usercountry = $this->getRequest()->getParam('countryid');
                    $ok = $locationsModel->FetchSatesByCountryId($usercountry);
                    if ($ok) {
                        $arr['code'] = 200;
                        $arr['data'] = $ok;
                        echo json_encode($arr);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['message'] = 'no states available for this country';
                        echo json_encode($arr);
                        die();
                    }
                    break;
                case 'FetchCityByStateId':
                    $stateid = $this->getRequest()->getParam('stateid');
                    $result = $locationsModel->FetchCityByStateId($stateid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['message'] = 'no citys available for this state';
                        echo json_encode($arr);
                        die();
                    }
                    break;

                case 'FetchCityByStateId':
                    $cityid = $this->getRequest()->getParam('cityid');
                    $result = $locationsModel->FetchLocationByCityId($cityid);
                    if ($result) {
                        $arr['code'] = 200;
                        $arr['data'] = $result;
                        echo json_encode($arr);
                        die();
                    } else {
                        $arr['code'] = 198;
                        $arr['message'] = 'no location available for this city';
                        echo json_encode($arr);
                        die();
                    }
                    break;

                case 'locationactive':
                    $locationid = $this->getRequest()->getParam('locationid');
                    $result = $locationsModel->changeLocationStatus($locationid);
                    if ($result) {
                        echo $locationid;
                    } else {
                        echo "error";
                    }
                    break;

                case 'getlocation':
                    $locationid = $this->getRequest()->getParam('locationid');
                    $result = $locationsModel->getLocationsByLocationId($locationid);
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
// added by sowmya 2/4/2016
                case 'cuisinedeactive':
                    $cuisineid = $this->getRequest()->getParam('cuisineid');
                    $result = $cuisinesModel->changeCuisineStatus($cuisineid);
                    if ($result) {
                        echo $cuisineid;
                    } else {
                        echo "error";
                    }
                    break;
// added by sowmya 2/4/2016
                case 'cuisineactive':
                    $cuisineid = $this->getRequest()->getParam('cuisineid');
                    $result = $cuisinesModel->changeCuisineStatus($cuisineid);
                    if ($result) {
                        echo $cuisineid;
                    } else {
                        echo "error";
                    }
                    break;
                case 'categorydeactive':
                    $categoryid = $this->getRequest()->getParam('categoryid');
                    $result = $categoryModel->changeCategoryStatus($categoryid);
                    if ($result) {
                        echo $categoryid;
                    } else {
                        echo "error";
                    }
                    break;
// added by sowmya 2/4/2016
                case 'categoryactive':
                    $categoryid = $this->getRequest()->getParam('categoryid');
                    $result = $categoryModel->changeCategoryStatus($categoryid);
                    if ($result) {
                        echo $categoryid;
                    } else {
                        echo "error";
                    }
                    break;
//added by sowmya 5/4/2016
                case 'categorydelete':
                    $categoryid = $this->getRequest()->getParam('categoryid');
                    $result = $categoryModel->categorydelete($categoryid);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
//added by sowmya 5/4/2016
                case 'getcategory':
                    $categoryid = $this->getRequest()->getParam('categoryid');
                    $result = $categoryModel->getCategoryById($categoryid);
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
//added by sowmya 5/4/2016
                case 'cuisinedelete':
                    $cuisineid = $this->getRequest()->getParam('cuisineid');
                    $result = $cuisinesModel->Cuisinedelete($cuisineid);
                    if ($result) {
                        $result2 = $hotelcuisinesModel->Cuisinedelete($cuisineid);
                        echo $result;
                        echo $result2;
                    } else {
                        echo "error";
                    }
                    break;
//added by sowmya 5/4/2016
                case 'getcuisine':
                    $cuisineid = $this->getRequest()->getParam('cuisineid');
                    $result = $cuisinesModel->getCuisineById($cuisineid);
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
                // added by sowmya 23/4/2016
                case 'storecategorydeactive':
                    $categoryid = $this->getRequest()->getParam('categoryid');
                    $result = $storeCategoryModel->changeCategoryStatus($categoryid);
                    if ($result) {
                        echo $categoryid;
                    } else {
                        echo "error";
                    }
                    break;
// added by sowmya 23/4/2016
                case 'storecategoryactive':
                    $categoryid = $this->getRequest()->getParam('categoryid');
                    $result = $storeCategoryModel->changeCategoryStatus($categoryid);
                    if ($result) {
                        echo $categoryid;
                    } else {
                        echo "error";
                    }
                    break;
//added by sowmya 23/4/2016
                case 'storecategorydelete':
                    $categoryid = $this->getRequest()->getParam('categoryid');
                    $result = $storeCategoryModel->categorydelete($categoryid);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
//added by sowmya 23/4/2016
                case 'getstorecategory':
                    $categoryid = $this->getRequest()->getParam('categoryid');
                    $result = $storeCategoryModel->getCategoryById($categoryid);
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
                //added by sowmya 25/4/2016
                //edit by sreekanth 9-5-2016 desc: deleting child items if parent is deleted
                case 'citydelete':
                    $locationid = $this->getRequest()->getParam('locationid');
                    $result = $locationsModel->cityDelete($locationid);
                    $locationsModel->countries_childlocation_delete($locationid);
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
                //added by sowmya 25/4/2016
                //edit by sreekanth 9-5-2016 desc: deleting child items if parent is deleted
                case 'statedelete':
                    $locationid = $this->getRequest()->getParam('locationid');
                    $result = $locationsModel->stateDelete($locationid);
                    $countries_childcity_id = $locationsModel->countries_childcity_delete($locationid);
                    if ($countries_childcity_id) {
                        foreach ($countries_childcity_id as $value1) {
                            $countries_childcity_id = $value1['location_id'];
                            $locationsModel->countries_childlocation_delete($countries_childcity_id);
                            $result2 = $hotelModel->updatelocationDelete($countries_childcity_id);
                            $result3 = $storeModel->updatelocationDelete($countries_childcity_id);
                        }
                    }
                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
                //added by sowmya 25/4/2016
                //desc: deleting child items if parent is deleted
                case 'countrydelete':
                    $locationid = $this->getRequest()->getParam('locationid');
                    $country_delete = $locationsModel->countryDelete($locationid);
                    $countries_childstate_delete = $locationsModel->countries_childstate_delete($locationid);
                    if ($countries_childstate_delete) {
                        foreach ($countries_childstate_delete as $value) {
                            $countries_childstate_id = $value['location_id'];
                            $countries_childcity_id = $locationsModel->countries_childcity_delete($countries_childstate_id);

                            if ($countries_childcity_id) {
                                foreach ($countries_childcity_id as $value1) {
                                    $countries_childcity_id = $value1['location_id'];
                                    $locationsModel->countries_childlocation_delete($countries_childcity_id);
                                    $result2 = $hotelModel->updatelocationDelete($countries_childcity_id);
                                    $result3 = $storeModel->updatelocationDelete($countries_childcity_id);
                                }
                            }
                        }
                    }
                    if ($country_delete) {
                        echo $country_delete;
                        die;
                    } else {
                        echo "error";
                    }
                    break;
                //added by sowmya 25/4/2016
                case 'locationdelete':
                    $locationid = $this->getRequest()->getParam('locationid');
                    $result2 = $hotelModel->updatelocationDelete($locationid);
                    $result3 = $storeModel->updatelocationDelete($locationid);

                    $result = $locationsModel->locationDelete($locationid);


                    if ($result) {
                        echo $result;
                    } else {
                        echo "error";
                    }
                    break;
            }
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: to edit locations
     * date : 28/1/2016;
     */

    public function editLocationAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $locationsModel = Admin_Model_Location::getInstance();
        if ($this->getRequest()->isPost()) {
            $data['name'] = $this->getRequest()->getPost('location');
            $location_id = $this->getRequest()->getPost('location_id');
            $locationname = $this->getRequest()->getPost('locationbtn');

            if ($location_id) {
                $result = $locationsModel->updateLocation($data, $location_id);
                if ($locationname == 'country') {
                    if ($result) {
                        $this->redirect('/admin/countries-details');
                    } else {
                        $this->redirect('/admin/countries-details');
                    }
                } else if ($locationname == 'state') {
                    if ($result) {
                        $this->redirect('/admin/states-details');
                    } else {
                        $this->redirect('/admin/states-details');
                    }
                } else if ($locationname == 'city') {
                    if ($result) {
                        $this->redirect('/admin/city-details');
                    } else {
                        $this->redirect('/admin/city-details');
                    }
                } else if ($locationname == 'location') {
                    if ($result) {
                        $this->redirect('/admin/location-details');
                    } else {
                        $this->redirect('/admin/location-details');
                    }
                } else {
                    $this->redirect('/admin/countries-details');
                }
            } else {
                $this->redirect('/admin/countries-details');
            }
        } else {
            $this->redirect('/admin/countries-details');
        }
    }

    /*
     * Dev: sowmya
     * Desc: fetch cuisines
     * date : 2/4/2016
     */

    public function cuisinesDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $cuisinesModel = Admin_Model_FamousCuisines::getInstance();
        $hotelModel = Admin_Model_HotelDetails::getInstance();
        $hotelcuisinesModel = Admin_Model_HotelCuisines::getInstance();
        $cuisines = $cuisinesModel->getCuisinesHotelBased();
        if ($cuisines) {

            $this->view->cuisinesdetails = $cuisines;
        }
        $hotel = $hotelModel->selectAllHotels();
        if ($hotel) {

            $this->view->hotellist = $hotel;
        }

        if ($this->getRequest()->isPost()) {

            $data['Cuisine_name'] = $this->getRequest()->getPost('cuisinename');
            $data['cuisine_status'] = $this->getRequest()->getPost('cuisine_status');
            $cuisine_id = $cuisinesModel->addCuisines($data);
            $hotelcuisinesdata['cuisine_id'] = $cuisine_id;
            $hotelcuisinesdata['hotel_id'] = $this->getRequest()->getPost('hotels');
            $result2 = $hotelcuisinesModel->addCuisinesDetails($hotelcuisinesdata);
            if ($result2) {
                $this->redirect('/admin/cuisines-details');
            }
        }
    }

    /*
     * Dev: sowmya
     * Desc: edit cuisines
     * date : 2/4/2016
     */

    public function editCuisinesAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $cuisinesModel = Admin_Model_FamousCuisines::getInstance();
        if ($this->getRequest()->isPost()) {
            $data['Cuisine_name'] = $this->getRequest()->getPost('cuisine');
            $cuisine_id = $this->getRequest()->getPost('cuisine_id');
            $Cuisine_name = $this->getRequest()->getPost('cuisinebtn');
            if ($cuisine_id) {
                $result = $cuisinesModel->updateCuisines($data, $cuisine_id);
                if ($Cuisine_name == 'cuisine') {
                    if ($result) {
                        $this->redirect('/admin/cuisines-details');
                    } else {
                        $this->redirect('/admin/cuisines-details');
                    }
                }
            }
        }
    }

    /*
     * Dev: sowmya
     * Desc: fetch category
     * date : 2/4/2016
     */

    public function categoryDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $categoryModel = Admin_Model_MenuCategory::getInstance();
        $category = $categoryModel->selectAllCategorys();
        if ($category) {
            $this->view->categorydetails = $category;
        }
        if ($this->getRequest()->isPost()) {
            $data['cat_name'] = $this->getRequest()->getPost('categoryname');
            $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
            $data['cat_status'] = $this->getRequest()->getPost('cat_status');
            $result = $categoryModel->addCategory($data);
            if ($result) {
                $this->redirect('/admin/category-details');
            }
        }
    }

    /*
     * Dev: sowmya
     * Desc: edit category
     * date : 2/4/2016
     */

    public function editCategoryAction() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $categoryModel = Admin_Model_MenuCategory::getInstance();
        if ($this->getRequest()->isPost()) {
            $data['cat_name'] = $this->getRequest()->getPost('category');
            $data['cat_desc'] = $this->getRequest()->getPost('catdesc');
            $category_id = $this->getRequest()->getPost('category_id');
            $categoryname = $this->getRequest()->getPost('categorybtn');

            if ($category_id) {
                $result = $categoryModel->updateCategory($data, $category_id);
                if ($categoryname == 'category') {
                    if ($result) {
                        $this->redirect('/admin/category-details');
                    } else {
                        $this->redirect('/admin/category-details');
                    }
                }
            }
        }
    }

    /*
     * Dev: sowmya
     * Desc: edit profile
     * date :19/4/2016
     */

    public function editProfileAction() {

        $objCountry = Admin_Model_Country::getInstance();
        $usermetaModel = Admin_Model_Usermeta::getInstance();
        $userModel = Admin_Model_Users::getInstance();
        $user_id = $this->view->session->storage->user_id;
        $countryCodeDetails = $objCountry->getAllCountryCode();
        if ($countryCodeDetails) {
            $this->view->countryCodeDetails = $countryCodeDetails;
        }
        if ($this->_request->isPost()) {
            $userid = $user_id;
            $userdata['uname'] = $this->getRequest()->getPost('uname');
            $userdata['email'] = $this->getRequest()->getPost('email');
            $userdata['status'] = 1;
            $usermetadata['first_name'] = $this->getRequest()->getPost('first_name');
            $usermetadata['last_name'] = $this->getRequest()->getPost('last_name');
            $usermetadata['phone'] = $this->getRequest()->getPost('phone');
            $usermetadata['city'] = $this->getRequest()->getPost('city');
            $usermetadata['state'] = $this->getRequest()->getPost('state');
            $usermetadata['country'] = $this->getRequest()->getPost('country');
            $usermetadata['contact_country_code'] = $this->getRequest()->getPost('contact_country_code');
            $coverphoto = $_FILES["fileToUpload"]["name"];

            $dirpath = getcwd() . "/assets/userimages/$userid/";
            if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777, true);
            }
            if (!empty($coverphoto)) {
                $imagepath = $dirpath . $coverphoto;
                $savepath = "/assets/userimages/$userid/$coverphoto";
                $imageTmpLoc = $_FILES["fileToUpload"]["tmp_name"];
                $ext = pathinfo($coverphoto, PATHINFO_EXTENSION);
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
                    echo json_encode("Something went wrong image upload");
                } else {
                    $imagemoveResult = (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imagepath));
                    if ($imagemoveResult) {
                        $link = $this->_appSetting->hostLink;
                        $usermetadata['profilepic_url'] = $link . $savepath;
                        $result1 = $userModel->updateUserdetails($userid, $userdata);
                        $result2 = $usermetaModel->updateUsermetadetails($userid, $usermetadata);
                        if ($result1 || $result2) {
                            $this->redirect('/admin/edit-profile');
                        } else {
                            $this->view->errormessage = 'user details not updated properly';
                        }
                    } else {
                        $result1 = $userModel->updateUserdetails($userid, $userdata);
                        $result2 = $usermetaModel->updateUsermetadetails($userid, $usermetadata);
                    }
                }
            } else {
                $result1 = $userModel->updateUserdetails($userid, $userdata);
                $result2 = $usermetaModel->updateUsermetadetails($userid, $usermetadata);
            }
        }
        $result = $userModel->getAdminDetails();

        if ($result) {
            $this->view->admindetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    public function changePasswordAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $userModel = Admin_Model_Users::getInstance();
        $userId = $this->view->session->storage->user_id;

        if ($this->_request->isPost()) {

            $old_password = $this->getRequest()->getPost('password');
            $new_password = $this->getRequest()->getPost('password1');
            $retype_password = $this->getRequest()->getPost('password2');
            if ($old_password != '' && $new_password != '' && $retype_password != '') {
                if ($old_password != $new_password) {
                    $old_password = sha1(md5($old_password));
                    $new_password = sha1(md5($new_password));
                    $retype_password = sha1(md5($retype_password));
                    $data = array('password' => $new_password);
                    $wherecondition = "user_id = '" . $userId . "' and password = '" . $old_password . "'";
                    $Updatepassword = $userModel->updateUsercredsWhere($data, $wherecondition);

                    if ($Updatepassword) {
                        $this->view->successMsg = "Password Changed Successfully";
                    } else {
                        $this->view->errorMsg = "Invalid Password";
                    }
                } else {
                    $this->view->errorMsg = "* Current and New Password should not be same";
                }
            } else {
                $this->view->errorMsg = "Please Enter all Passwords";
            }
        }
    }

    /*
     * Dev: sowmya
     * Desc: fetch  store category
     * date : 23/4/2016
     */

    public function storeCategoryDetailsAction() {
        $adminModel = Admin_Model_Users::getInstance();
        $result = $adminModel->getAdminDetails(); // showing image
        if ($result) {
            $this->view->admindetails = $result;
        }
        $categoryModel = Admin_Model_StoreCategory::getInstance();
        $category = $categoryModel->selectAllCategorys();
        if ($category) {
            $this->view->categorydetails = $category;
        }
        if ($this->getRequest()->isPost()) {
            $data['cat_name'] = $this->getRequest()->getPost('categoryname');
            $data['cat_desc'] = $this->getRequest()->getPost('cat_desc');
            $data['cat_status'] = $this->getRequest()->getPost('cat_status');
            $result = $categoryModel->addCategory($data);
            if ($result) {
                $this->redirect('/admin/store-category-details');
            }
        }
    }

    /*
     * Dev: sowmya
     * Desc: edit category
     * date : 2/4/2016
     */

    public function editStoreCategoryAction() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $categoryModel = Admin_Model_StoreCategory::getInstance();
        if ($this->getRequest()->isPost()) {
            $data['cat_name'] = $this->getRequest()->getPost('category');
            $data['cat_desc'] = $this->getRequest()->getPost('catdesc');
            $category_id = $this->getRequest()->getPost('category_id');
            $categoryname = $this->getRequest()->getPost('categorybtn');

            if ($category_id) {
                $result = $categoryModel->updateCategory($data, $category_id);
                if ($categoryname == 'category') {
                    if ($result) {
                        $this->redirect('/admin/store-category-details');
                    } else {
                        $this->redirect('/admin/store-category-details');
                    }
                }
            }
        }
    }

}
