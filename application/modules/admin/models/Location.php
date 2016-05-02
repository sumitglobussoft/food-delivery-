<?php

class Admin_Model_Location extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'location';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_Location();
        }
        return self::$_instance;
    }

    /*
     * Dev: priyanka varanasi
     * Desc: add locations in db
     * date : 13/1/2015;
     */

    public function addLocation() {
        if (func_num_args() > 0) {
            $location = func_get_arg(0);

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
        }
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
                    ->where('location_type=?', 0);
//                    ->where('location_status=?', 1);
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
     * Dev: priyanka varanasi
     * Desc: fetch citys from db
     * date : 13/1/2015;
     */

    public function getLocations() {
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
     * Dev: priyanka varanasi
     * Desc: fetch citys from db
     * date : 13/1/2015;
     */

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

    /*
     * Dev: priyanka varanasi
     * Desc: fetch state by  country id
     * date : 13/1/2015;
     */

    public function FetchSatesByCountryId() {
        if (func_num_args() > 0) {
            $location = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('location_type=?', 1)
                        ->where('parent_id=?', $location);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch state by  country id
     * date : 13/1/2015;
     */

    public function FetchCityByStateId() {
        if (func_num_args() > 0) {
            $location = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('location_type=?', 2)
                        ->where('parent_id=?', $location);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: fetch state by  country id
     * date : 13/1/2015;
     */

    public function FetchLocationByCityId() {
        if (func_num_args() > 0) {
            $location = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('location_type=?', 3)
                        ->where('parent_id=?', $location);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

    /*
     * Dev: priyanka varanasi
     * Desc: add locations in db
     * date : 13/1/2015;
     */

    public function addLocationByParentID() {
        if (func_num_args() > 0) {
            $location = func_get_arg(0);
            $parent = func_get_arg(1);
            if ($location['parent_id']) {
                try {
                    $select = $this->select()
                            ->from($this)
                            ->where('location_type=?', 1)
                            ->where('location_id=?', $location['parent_id']);
                    $result = $this->getAdapter()->fetchRow($select);
                    if ($result['parent_id'] == $parent) {
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
            }
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

    //dev:sowmya
    //desc: to delete city
    //date:25/4/2016

    public function cityDelete() {
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

    //dev:sowmya
    //desc: to delete location
    //date:25/4/2016

    public function locationDelete() {
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

    //dev:sowmya
    //desc: to delete country
    //date:25/4/2016

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

    //dev:sowmya
    //desc: to delete state
    //date:25/4/2016

    public function stateDelete() {
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

}

?>