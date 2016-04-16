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

}
