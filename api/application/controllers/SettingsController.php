<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session/Namespace.php';

class SettingsController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    /*
     * DEV :Priyanka Varanasi
     * Desc : To fetch citys, states, countries and locations to search restuarents
     * Date : 13/1/2016
     */

    public function getLocationsAction() {
        $locationsmodal = Application_Model_Location::getInstance();
        $countrymodal = Application_Model_Country::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {
            switch ($method) {

                case'getcitys':

                    $cityslist = $locationsmodal->getCitys();
                    if ($cityslist) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $cityslist;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;


                case'getcountrys':

                    $countrieslist = $locationsmodal->getCountrys();
                    if ($countrieslist) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $countrieslist;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

//   =================================== get states &cities action===== by sreekanth-===============================

                case'getstates':

                    $countrieslist = $locationsmodal->getallStates();
                    if ($countrieslist) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $countrieslist;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'getcities':

                    $countrieslist = $locationsmodal->getallcities();
                    if ($countrieslist) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $countrieslist;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'getlocations':

                    $countrieslist = $locationsmodal->getAllLocations();
                    if ($countrieslist) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $countrieslist;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

//   =================================== get states &cities action===== by sreekanth-=======END========================


                case'getStatesByCountrys':

                    if ($this->getRequest()->isPost()) {
                        $location_id = $this->getRequest()->getPost('country_id');
                        if ($location_id) {
                            $locationslist = $locationsmodal->getStatesByCountrys($location_id);
                            if ($locationslist) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $locationslist;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'getcitysbystates':

                    if ($this->getRequest()->isPost()) {
                        $location_id = $this->getRequest()->getPost('state_id');
                        if ($location_id) {
                            $locationslist = $locationsmodal->getCitysByStates($location_id);
                            if ($locationslist) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $locationslist;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'getlocation':

                    if ($this->getRequest()->isPost()) {
                        $location_id = $this->getRequest()->getPost('location_id');
                        if ($location_id) {
                            $locationslist = $locationsmodal->getLocationsByCitys($location_id);
                            if ($locationslist) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $locationslist;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
                //added by sowmya 12/4/2016
                case'getHotelLocation':

                    if ($this->getRequest()->isPost()) {
                        $hotelid = $this->getRequest()->getPost('hotel_id');
                        if ($hotelid) {
                            $locationslist = $locationsmodal->getLocationByParentIds($hotelid);
                            if ($locationslist) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $locationslist;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
                //added by sowmya 27/4/2016
                case'countryCodeDetails':

                    $countrieslist = $countrymodal->getAllCountryCode();
                    if ($countrieslist) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $countrieslist;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
                //added by sowmya 29/4/2016
                case'getcity':

                    $cityslist = $locationsmodal->getCity();
                    if ($cityslist) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $cityslist;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
                //added by sowmya 29/4/2016
                case'getcountry':

                    $countrieslist = $locationsmodal->getCountry();
                    if ($countrieslist) {
                        $response->message = 'Successfull';
                        $response->code = 200;
                        $response->data = $countrieslist;
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
            }
        } else {
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
        }
        echo json_encode($response, true);
        die();
    }

    /*
     * DEV :Priyanka Varanasi
     * Desc : To fetch restuarents based on citys or locations
     * Date : 13/1/2016
     */

    public function getRestaurantsListAction() {

        $locationsmodal = Application_Model_Location::getInstance();
        $hoteldetailsModal = Application_Model_HotelDetails::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {
            switch ($method) {

                case'bylocationid':
                    if ($this->getRequest()->isPost()) {
                        $location_id = $this->getRequest()->getPost('location_id');
                        $citylocation_id = $this->getRequest()->getPost('city_id');
                        if ($location_id && $citylocation_id) {
                            $restuarentslist = $hoteldetailsModal->getRestaurentsByLocationid($location_id, $citylocation_id);
                            if ($restuarentslist) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $restuarentslist;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'bycityid':

                    if ($this->getRequest()->isPost()) {
                        $location_id = $this->getRequest()->getPost('location_id');
                        if ($location_id) {

                            $restuarentslist = $hoteldetailsModal->getRestaurentsBycityId($location_id);
                            if ($restuarentslist) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $restuarentslist;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'getcityname':
                    if ($this->getRequest()->isPost()) {

                        $citylocation_id = $this->getRequest()->getPost('city_id');
                        if ($citylocation_id) {
                            $cityname = $locationsmodal->getCityNameByCityId($citylocation_id);
                            if ($cityname) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $cityname;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'getRestaurantsListByLocations':
                    if ($this->getRequest()->isPost()) {

                        $countryid = $this->getRequest()->getPost('country_id');

                        $stateid = $this->getRequest()->getPost('state_id');

                        $cityid = $this->getRequest()->getPost('city_id');

                        $locationid = $this->getRequest()->getPost('location_id');

                        if ($countryid && $stateid && $cityid && $locationid) {

                            $HotelsList = $locationsmodal->getHotelsByLocationsIds($countryid, $stateid, $cityid, $locationid);

                            if ($HotelsList) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $HotelsList;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        } else {
                            $response->message = 'Parametre missing';
                            $response->code = 197;
                            $response->data = NUll;
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'addNewlocation':
                    if ($this->getRequest()->isPost()) {

                        $countryid = $this->getRequest()->getPost('country_id');
                        $stateid = $this->getRequest()->getPost('state_id');
                        $location['parent_id'] = $this->getRequest()->getPost('parent_id');
                        $location['location_status'] = $this->getRequest()->getPost('location_status');
                        $location['location_type'] = $this->getRequest()->getPost('location_type');
                        $location['name'] = $this->getRequest()->getPost('name');
                        if ($countryid && $stateid && $location['parent_id']) {
                            $location_id = $locationsmodal->addLocationByParentIds($location, $stateid, $countryid);
                            if ($location_id) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $location_id;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        } else {
                            $response->message = 'Parametre missing';
                            $response->code = 197;
                            $response->data = NUll;
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                    $result = $locationsModel->addLocationByParentIds($data, $state, $country);
            }
        } else {
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
        }
        echo json_encode($response, true);
        die();
    }

    /*
     * DEV :Priyanka Varanasi
     * Desc : To fetch restaurent menu products
     * Date : 15/1/2016
     */

    public function restaurantInfoCardAction() {

        $locationsmodal = Application_Model_Location::getInstance();
        $hoteldetailsModal = Application_Model_HotelDetails::getInstance();
        $productdetailsModal = Application_Model_Products::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {
            switch ($method) {

                case'getmenulist':
                    if ($this->getRequest()->isPost()) {
                        $hotel_id = $this->getRequest()->getPost('hotel_id');
                        if ($hotel_id) {
                            $restuarentsmenudetails = $productdetailsModal->getRestaurentsMenuDetails($hotel_id);


                            if ($restuarentsmenudetails) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $restuarentsmenudetails;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;

                case'gethotelinfo':
                    if ($this->getRequest()->isPost()) {
                        $hotel_id = $this->getRequest()->getPost('hotel_id');
                        if ($hotel_id) {
                            $restuarentsmenudetails = $hoteldetailsModal->getHoteldetailsByHotelId($hotel_id);
                            if ($restuarentsmenudetails) {
                                $response->message = 'Successfull';
                                $response->code = 200;
                                $response->data = $restuarentsmenudetails;
                            } else {
                                $response->message = 'Could not Serve the Response';
                                $response->code = 197;
                                $response->data = NUll;
                            }
                        }
                    } else {
                        $response->message = 'Could not Serve the Response';
                        $response->code = 197;
                        $response->data = NUll;
                    }

                    echo json_encode($response, true);
                    die();
                    break;
            }
        } else {
            $response->message = 'Could not Serve the Response';
            $response->code = 197;
            $response->data = NUll;
        }
        echo json_encode($response, true);
        die();
    }

    /*
     * DEV :Priyanka Varanasi
     * Desc : To fetch cart products based on logged user
     * Date : 27/1/2016
     */

    public function loggedUserCartAction() {
        $Addtocart = Application_Model_Addtocart::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');
        if ($method) {

            switch ($method) {
                case'userscart':
                    if ($this->getRequest()->isPost()) {
                        $user_id = $this->getRequest()->getPost('user_id');
                        if ($user_id) {
                            $userscartproducts = $Addtocart->getCartProductsByLoggedIds($user_id);
                            if ($userscartproducts) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $userscartproducts;
                            } else {
                                $response->message = 'No Data Found';
                                $response->code = 197;
                                $response->data = Null;
                            }
                        } else {
                            $response->message = 'parameter doesnot pass';
                            $response->code = 198;
                            $response->data = Null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;
                    break;
            }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = "No Method Passed";
            echo json_encode($response, true);
            die();
        }
    }

    /*
     * DEV :Priyanka Varanasi
     * Desc : service used for search functionality of hotels
     * Date : 4/2/2016
     */

    public function searchHotelsByAction() {
        $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
        $hotelcuisinesModel = Application_Model_HotelCuisines::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {

                case'hotelname':

                    if ($this->getRequest()->isPost()) {

                        $name = $this->getRequest()->getPost('name');

                        if ($name) {
                            $hotelslist = $hotelssummaryModel->searchByNames($name);
                            if ($hotelslist) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $hotelslist;
                            } else {
                                $response->message = 'No Data Found';
                                $response->code = 197;
                                $response->data = Null;
                            }
                        } else {
                            $response->message = 'parameter doesnot pass';
                            $response->code = 198;
                            $response->data = Null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;
                    break;

                case'insertCuisines':

                    if ($this->getRequest()->isPost()) {

                        $cuisines = $this->getRequest()->getPost('cuisines');
                        $cuisinesarray = (array) json_decode($cuisines, true);

                        if ($cuisinesarray) {
                            $result = $hotelcuisinesModel->insertHotelCuisines($cuisinesarray);
                            if ($result) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $result;
                            } else {
                                $response->message = 'No Data Found';
                                $response->code = 197;
                                $response->data = Null;
                            }
                        } else {
                            $response->message = 'parameter doesnot pass';
                            $response->code = 198;
                            $response->data = Null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;
                    break;

                /*
                 * DEV :Sibani Mishra
                 * Desc : service used for search functionality of hotels based on cuisines
                 * Date : 4/1/2016
                 */

                case 'selectcuisines':
                    if ($this->getRequest()->isPost()) {

                        $hotel_locations = $this->getRequest()->getPost('hotel_locations');
                        $cuisine_id = $this->getRequest()->getPost('cuisine_id');
                        $cuisine_id = json_decode($cuisine_id);


                        if (!empty($hotel_locations) && !empty($cuisine_id)) {

                            $hotelnames = $hotelssummaryModel->gethotalsname($hotel_locations, $cuisine_id);

                            if ($hotelnames) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $hotelnames;
                            } else {
                                $response->message = 'No Data Found';
                                $response->code = 197;
                                $response->data = Null;
                            }
                        } else {
                            $response->message = 'parameter Shouldnot be blank';
                            $response->code = 198;
                            $response->data = Null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }


                    echo json_encode($response, true);
                    die;
                    break;
                /*
                 * DEV :Sibani Mishra
                 * Desc : service used for search functionality of hotels based on cuisines
                 * Date : 4/1/2016
                 */


                case 'selectReviewsAndRatings':

                    if ($this->getRequest()->isPost()) {

                        $hotel_locations = $this->getRequest()->getPost('hotel_locations');

                        if (!empty($hotel_locations)) {

                            $hotelnames = $hotelssummaryModel->gethotalsnamebasedReviewandratings($hotel_locations);

                            if ($hotelnames) {
                                $response->message = 'successfull';
                                $response->code = 200;
                                $response->data = $hotelnames;
                            } else {
                                $response->message = 'No Data Found';
                                $response->code = 197;
                                $response->data = Null;
                            }
                        } else {
                            $response->message = 'HotelLocation Shouldnot be blank';
                            $response->code = 198;
                            $response->data = Null;
                        }
                    } else {
                        $response->message = 'Could Not Serve The Request';
                        $response->code = 401;
                        $response->data = NULL;
                    }
                    echo json_encode($response, true);
                    die;
                    break;
            }
        } else {
            $response->message = 'Invalid Request';
            $response->code = 401;
            $response->data = "No Method Passed";
            echo json_encode($response, true);
            die();
        }
    }

    /*
     * DEV  : Sibani Mishra
     * Desc : service used for give ratings and Reviews
     * Date : 4/21/2016
     */

    public function hotelsReviewsAction() {

        $users = Application_Model_Users::getInstance();
        $reviewsratings = Application_Model_Reviews::getInstance();
        $hotelssummaryModel = Application_Model_HotelDetails::getInstance();
        $response = new stdClass();
        $method = $this->getRequest()->getParam('method');

        if ($method) {

            switch ($method) {

                case'AddReviews':

                    if ($this->getRequest()->isPost()) {

                        $userid = $this->getRequest()->getPost('user_id');
                        $starratings = $this->getRequest()->getPost('star_rating');
                        $reviewdesc = $this->getRequest()->getPost('review_desc');
                        $hotelid = $this->getRequest()->getPost('hotel_id');

                        if ($userid != '') {

                            $Userscredentials = $users->validateByUserId($userid);

                            if ($Userscredentials) {

                                if ($hotelid != '' && $reviewdesc != '' && $starratings != '') {

                                    $addReview = $reviewsratings->isavailablereview($hotelid, $userid);

                                    if (empty($addReview)) {
                                        $data['user_id'] = $userid;
                                        $data['review_type'] = 0;
                                        $data['review_for_id'] = $hotelid;
                                        $data['review_rating'] = $starratings;
                                        $data['review_description'] = $reviewdesc;
                                        $data['review_status'] = 0;

                                        $addReview = $reviewsratings->addReview($data);

                                        if ($addReview) {

                                            $avgofStarRatings = $reviewsratings->getavgratingsofindividualHotel($hotelid);

                                            if ($avgofStarRatings) {

                                                $addavgRatetoindividualshotels = $hotelssummaryModel->updatehotels($hotelid, $avgofStarRatings);

                                                $Admincredentials = $users->validateByAdminId(2);

                                                if ($Admincredentials != '') {

                                                    $admin_id = $Admincredentials['user_id'];
                                                    $objNotification = Engine_Plugins_Functions::getInstance();
                                                    $sent_by = $userid;
                                                    $sent_to = $admin_id;
                                                    $noti_url = "/admin/notification";
                                                    $Noti_message = "New Review for Product is pending for You";

                                                    $addNotification = $objNotification->sendNotificationWithUrl($sent_by, $sent_to, $Noti_message, $noti_url);
                                                }
                                                $response->code = 200;
                                                $response->message = "Review Successfully Added";
                                                $response->data = $addReview;
                                            } else {
                                                $response->code = 100;
                                                $response->message = "Something went wrong";
                                                $response->data = null;
                                            }
                                        } else {
                                            $response->code = 100;
                                            $response->message = "Something went wrong..Review Not added, Try again.";
                                            $response->data = null;
                                        }
                                    } else {
                                        $response->code = 100;
                                        $response->message = "Review Already Added, You can add one review to one product.";
                                        $response->data = $addReview;
                                    }
                                } else {
                                    $response->code = 100;
                                    $response->message = "You missed something.";
                                    $response->data = null;
                                }
                            } else {
                                $response->code = 100;
                                $response->message = "Their is No user for this ID.";
                                $response->data = null;
                            }
                        } else {
                            $response->code = 100;
                            $response->message = "You need to login to Add Review.";
                            $response->data = null;
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Access Denied";
                        $response->data = null;
                    }
                    echo json_encode($response, true);
                    die;
                    break;

                case 'getReviews':

                    if ($this->getRequest()->isPost()) {

                        $hotelid = $this->getRequest()->getPost('hotel_id');

                        if ($hotelid != '') {

                            $hotelReviewDetails = $reviewsratings->gethotelsReviewsWithLimit($hotelid);

                            if ($hotelReviewDetails) {
                                $response->code = 200;
                                $response->message = "Suiccessful";
                                $response->data = $hotelReviewDetails;
                            } else {
                                $response->code = 200;
                                $response->message = "Something went wrong";
                            }
                        } else {
                            $response->code = 200;
                            $response->message = "Hotel ID should not be Null";
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Invalid request";
                        $response->data = null;
                    }
                    echo json_encode($response, true);
                    die;
                    break;
            }
        }
    }

}
