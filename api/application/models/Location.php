<?php

class Application_Model_Location extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'location';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Application_Model_Location();
        }
        return self::$_instance;
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch countrys from db
     * date : 13/1/2015;
     */

    public function getCountrys() {
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('location_type=?', 0)
                    ->where('location_status=?', 1);
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch states from db
     * date : 13/1/2015;
     */

    public function getStates() {
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('location_type=?', 1)
                    ->where('location_status=?', 1);
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    /*
     * Dev: sreekanth
     * Desc: fetch all states from db
     * date : 3/5/2016;
     */

    public function getallStates() {
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('location_type=?', 1);

            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch citys from db
     * date : 13/1/2015;
     */

    public function getCitys() {
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('location_type=?', 2)
                    ->where('location_status=?', 1);
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch citys from db
     * date : 13/1/2015;
     */

    public function getLocations() {
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('location_type=?', 3)
                    ->where('location_status=?', 1);
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch locations under citys
     * date : 13/1/2015;
     */

    public function getLocationsByCitys() {
        if (func_num_args() > 0) {
            $locationid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('parent_id=?', $locationid)
                        ->where('location_type=?', 3)
                        ->where('location_status=?', 1);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        } else {
            
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: to get city name by city id 
     * date : 15/1/2015;
     */

    public function getCityNameByCityId() {
        if (func_num_args() > 0) {
            $cityid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('location_id=?', $cityid)
                        ->where('location_type=?', 2)
                        ->where('location_status=?', 1);
                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        } else {
            
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch states by country id
     * date : 13/1/2015;
     */

    public function getStatesByCountrys() {
        if (func_num_args() > 0) {
            $locationid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('parent_id=?', $locationid)
                        ->where('location_type=?', 1)
                        ->where('location_status=?', 1);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        } else {
            
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch citysby state id
     * date : 13/1/2015;
     */

    public function getCitysByStates() {
        if (func_num_args() > 0) {
            $locationid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('parent_id=?', $locationid)
                        ->where('location_type=?', 2)
                        ->where('location_status=?', 1);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        } else {
            
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch restaurants based on city Id, state Id, Country Id,Location Id( AND WHERE)
     * date : 2/2/2016;
     */

    public function getHotelsByLocationsIds() {
        if (func_num_args() > 0) {
            $countryid = func_get_arg(0);
            $stateid = func_get_arg(1);
            $cityid = func_get_arg(2);
            $locationid = func_get_arg(3);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('parent_id=?', $countryid)
                        ->where('location_type=?', 1)
                        ->where('location_id=?', $stateid)
                        ->where('location_status=?', 1);
                $result1 = $this->getAdapter()->fetchRow($select);

                if ($result1['location_id'] && $result1['location_id'] == $stateid) {
                    $select = $this->select()
                            ->from($this)
                            ->where('parent_id=?', $result1['location_id'])
                            ->where('location_type=?', 2)
                            ->where('location_id=?', $cityid)
                            ->where('location_status=?', 1);
                    $result2 = $this->getAdapter()->fetchRow($select);

                    if ($result2['location_id'] && $result2['location_id'] == $cityid) {
                        $select = $this->select()
                                ->from($this)
                                ->where('parent_id=?', $result2['location_id'])
                                ->where('location_type=?', 3)
                                ->where('location_id=?', $locationid)
                                ->where('location_status=?', 1);
                        $result3 = $this->getAdapter()->fetchRow($select);

                        if ($result3['location_id'] && $result3['location_id'] == $locationid) {
                            $select = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('hd' => 'hotel_details'))
                                    ->where('hotel_location=?', $result3['location_id'])
                                    ->where('hotel_status=?', 1);
                            $result4 = $this->getAdapter()->fetchAll($select);
                        } else {
                            return null;
                        }
                    } else {
                        return null;
                    }
                } else {

                    return null;
                }
                if ($result4) {
                    return $result4;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        } else {
            
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: add locations in db
     * date : 13/1/2015;
     */

    public function addLocationByParentIds() {
        if (func_num_args() > 0) {
            $location = func_get_arg(0);
            $stateid = func_get_arg(1);
            $country = func_get_arg(2);
            if ($location['parent_id']) {
                try {
                    $select = $this->select()
                            ->from($this)
                            ->where('location_type=?', 1)
                            ->where('location_id=?', $stateid);
                    $result = $this->getAdapter()->fetchRow($select);
                    if ($result['parent_id'] == $country) {
                        try {
                            $select = $this->select()
                                    ->from($this)
                                    ->where('location_type=?', 2)
                                    ->where('location_id=?', $location['parent_id']);
                            $result = $this->getAdapter()->fetchRow($select);
                            if ($result['parent_id'] == $stateid) {
                                try {
                                    $row = $this->insert($location);
                                    if ($row) {
                                        return $row;
                                    } else {
                                        return null;
                                    }
                                } catch (Exception $e) {
                                    throw new Exception('Unable To insert data :' . $e);
                                }
                            } else {
                                return null;
                            }
                        } catch (Exception $e) {
                            throw new Exception('Unable To retrieve data :' . $e);
                        }
                    } else {
                        return null;
                    }
                } catch (Exception $e) {
                    throw new Exception('Unable To retrieve data :' . $e);
                }
            } else {
                return null;
            }
        }
    }

    /*
     * Dev: sowmya
     * Desc: fetch countrys from db
     * date : 29/4/2016;
     */

    public function getCountry() {
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('location_type=?', 0);
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    /*
     * Dev: sowmya
     * Desc: fetch citys from db
     * date : 29/4/2015;
     */

    public function getCity() {
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('location_type=?', 2);
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    public function addcountry() {
        if (func_num_args() > 0) {
            $country = func_get_arg(0);
            try {
                $row = $this->insert($country);
                if ($row) {
                    return $row;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

    public function changeLocationStatus() {
        if (func_num_args() > 0):
            $locationid = func_get_arg(0);
            try {
                $data = array('location_status' => new Zend_DB_Expr('IF(location_status=1, 0, 1)'));
                $result = $this->update($data, 'location_id = "' . $locationid . '"');
            } catch (Exception $e) {
                throw new Exception($e);
            }
            if ($result):
                return $result;
            else:
                return 0;
            endif;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    public function updateLocation() {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $id = func_get_arg(1);
            try {
                $result1 = $this->update($data, 'location_id = "' . $id . '"');

                if ($result1) {
                    return $result1;
                } else {
                    return null;
                }
            } catch (Exception $e) {

                throw new Exception('Unable To update data :' . $e);
            }
        }
    }

    public function getLocationsByLocationId() {
        if (func_num_args() > 0) {
            $location = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('location_id=?', $location);
                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

    public function countryDelete() {
        if (func_num_args() > 0):
            $lid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('location_id = ?' => $lid));
                $db->delete('location', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $lid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    /*
     * Dev: sreekanth
     * Desc: fetch all states from db
     * date : 3/5/2016;
     */

    public function getallcities() {
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('location_type=?', 2);

            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    /*
     * Dev: sreekanth
     * Desc: fetch all states from db
     * date : 3/5/2016;
     */

    public function getAllLocations() {
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('location_type=?', 3);

            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    /*
     * Dev: sowmya
     * Desc: fetch grocery based on city Id, state Id, Country Id,Location Id( AND WHERE)
     * date : 5/5/2016;
     */

    public function getGroceryByLocationsIds() {
        if (func_num_args() > 0) {
            $countryid = func_get_arg(0);
            $stateid = func_get_arg(1);
            $cityid = func_get_arg(2);
            $locationid = func_get_arg(3);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('parent_id=?', $countryid)
                        ->where('location_type=?', 1)
                        ->where('location_id=?', $stateid)
                        ->where('location_status=?', 1);
                $result1 = $this->getAdapter()->fetchRow($select);

                if ($result1['location_id'] && $result1['location_id'] == $stateid) {
                    $select = $this->select()
                            ->from($this)
                            ->where('parent_id=?', $result1['location_id'])
                            ->where('location_type=?', 2)
                            ->where('location_id=?', $cityid)
                            ->where('location_status=?', 1);
                    $result2 = $this->getAdapter()->fetchRow($select);

                    if ($result2['location_id'] && $result2['location_id'] == $cityid) {
                        $select = $this->select()
                                ->from($this)
                                ->where('parent_id=?', $result2['location_id'])
                                ->where('location_type=?', 3)
                                ->where('location_id=?', $locationid)
                                ->where('location_status=?', 1);
                        $result3 = $this->getAdapter()->fetchRow($select);

                        if ($result3['location_id'] && $result3['location_id'] == $locationid) {
                            $select = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('gd' => 'grocery_details'))
                                    ->joinLeft(array('gc' => 'grocery_category'), 'gd.category_id= gc.category_id')
                                    ->where('grocery_location=?', $result3['location_id'])
                                    ->where('grocery_status=?', 1);
                            $result4 = $this->getAdapter()->fetchAll($select);
                        } else {
                            return null;
                        }
                    } else {
                        return null;
                    }
                } else {

                    return null;
                }
                if ($result4) {
                    return $result4;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        } else {
            
        }
    }

}

?>