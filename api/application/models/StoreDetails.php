<?php

/*
 * Dev : sowmya
 * Date: 2/5/2016
 * Desc: Store Modal
 */

class Application_Model_StoreDetails extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'store_details';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_StoreDetails();
        return self::$_instance;
    }

    /*
     * Dev : sowmya
     * Date: 26/4/2016
     * Desc: TO select all store in db
     */

    public function selectAllStore() {

        try {

            $select = $this->select()
                    ->from($this);
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            } else {

                return null;
            }
        } catch (Exception $e) {
            throw new Exception('Unable to access data :' . $e);
        }
    }

    //dev:sowmya
    //desc: to fetch agent stores
    //date:2/4/2016
    public function getStoredetails() {
        if (func_num_args() > 0) {
            $agent_id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('gd' => 'store_details'), array('gd.agent_id', 'gd.store_address', 'gd.store_contact_number', 'gd.Secondary_phone', 'gd.store_name', 'gd.store_image', 'gd.Open_time', 'gd.Closing_time', 'gd.store_status', 'gd.Notice', 'gd.store_id', 'gd.store_rating'))
                        ->joinLeft(array('ag' => 'agents'), 'gd.agent_id= ag.agent_id')
                        ->where('gd.agent_id=?', $agent_id);

                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                } else {

                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

    //dev:sowmya
    //desc:activate and deactive of store
    //date:5/5/2016
    public function getstatusChangeOfStore() {
        if (func_num_args() > 0):
            $storeid = func_get_arg(0);
            try {
                $data = array('store_status' => new Zend_DB_Expr('IF(store_status=1, 0, 1)'));
                $result = $this->update($data, 'store_id = "' . $storeid . '"');
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

    //dev:sowmya
    //desc: to delete store
    //date:5/5/2016

    public function storeDelete() {
        if (func_num_args() > 0):
            $storeid = func_get_arg(0);

            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('store_id = ?' => $storeid));
                $delete = $db->delete('store_details', $where);
                if ($delete) {
                    return $delete;
                }
            } catch (Exception $e) {
                throw new Exception($e);
            }

        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    //dev:sowmya
    //desc:to fetch store details by store id
    //date:12/4/2016
    public function getStoredetailsByStoreId() {
        if (func_num_args() > 0) {
            $store_id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('gd' => 'store_details'))
                        ->joinLeft(array('ag' => 'agents'), 'gd.agent_id= ag.agent_id')
                        ->joinLeft(array('gc' => 'store_category'), 'gd.category_id= gc.category_id')
                        ->joinLeft(array('l' => 'location'), 'gd.store_location= l.location_id', ['areaName' => 'l.name'])     //area*
                        ->joinLeft(array('l1' => 'location'), 'l1.location_id= l.parent_id', ['cityName' => 'l1.name'])          //city*
                        ->joinLeft(array('l2' => 'location'), 'l2.location_id= l1.parent_id', ['stateName' => 'l2.name'])        //state*
                        ->joinLeft(array('l3' => 'location'), 'l3.location_id= l2.parent_id', ['countryName' => 'l3.name'])        //country*
                        ->where('gd.store_id=?', $store_id);
                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                } else {

                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

//dev:sowmya
    //desc: to update edited store details based on store id
    //date:2/5/2016
    public function updateStoreDetails() {

        if (func_num_args() > 0) {
            $storeid = func_get_arg(0);
            $data = func_get_arg(1);
            try {
                $result = $this->update($data, 'store_id =' . $storeid);
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    /*
     * dev:sowmya
     * Desc: to insert store details 
     *  date:2/5/2016
     * 
     */

    public function insertStoreDetails() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $responseId = $this->insert($data);
                if ($responseId) {
                    return $responseId;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev: sowmya
     * Date : 5/5/2016
     * Desc : TO get all menu details from all stores
     */

    public function GetStoresAndMenu() {

        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('hd' => 'store_details'))
                    ->join(array('pr' => 'products'), 'hd.id= pr.store_id')
                    ->joinLeft(array('cat' => 'menu_category'), 'pr.category_id= cat.category_id');
            $result = $this->getAdapter()->fetchAll($select);

            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
    }

    public function getRestaurentsByLocationid() {
        if (func_num_args() > 0) {
            $locationid = func_get_arg(0);
            $cityid = func_get_arg(1);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hd' => 'store_details'))
                        ->join(array('l' => 'location'), 'hd.store_location=l.location_id')
                        ->where('hd.store_location=?', $locationid)
                        ->where('l.parent_id=?', $cityid)
                        ->where('l.location_type=?', 3)
                        ->where('hd.store_status=?', 1);

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

    public function getRestaurentsBycityId() {
        if (func_num_args() > 0) {
            $cityid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hd' => 'store_details'))
                        ->join(array('l' => 'location'), 'hd.store_location=l.location_id')
                        ->where('hd.store_location=?', $cityid)
                        ->where('l.location_type=?', 2)
                        ->where('hd.store_status=?', 1);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
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
     * 
     * Dev : sowmya
     *  Date : 5 May 2016
     */

//
//    public function getcategoriesByStoreId() {
//
//        if (func_num_args() > 0) {
//            $store_id = func_get_arg(0);
//
//            try {
//
//                $selectMenu = $this->select()
//                        ->from(array('gd' => 'store_details'), array('gd.store_id'))
//                        ->setIntegrityCheck(false)
//                        ->joinLeft(array('cat' => 'store_category'), 'gd.category_id=cat.category_id')
//                        ->where('gd.store_id=?', $store_id);
//                $resultMenu = $this->getAdapter()->fetchAll($selectMenu);
//
//                $categorys = array();
//
//                if ($resultMenu) {
//                    $categorys['menuList'] = $resultMenu;
//                } else {
//                    $categorys['menuList'] = array();
//                }
//                if (!empty($categorys['menuList'])) {
//                    return $categorys;
//                } else {
//                    return null;
//                }
//            } catch (Exception $e) {
//                throw new Exception('Unable to access data :' . $e);
//            }
//        } else {
//
//            throw new Exception('Argument Not Passed');
//        }
//    }
//
    /*
     * Dev : sowmya
     * Date:5/5/2016
     * Desc: TO select all stores 
     */

    public function selectAllStoresLocations() {

        try {
            $select = $this->select()
                    ->from(array('hd' => 'store_details'))
                    ->setIntegrityCheck(false)
                    ->joinLeft(array('loc' => 'location'), 'hd.store_location= loc.location_id');
            //->joinLeft(array('ag' => 'agents'), 'hd.agent_id= ag.agent_id');
            $result = $this->getAdapter()->fetchAll($select);
            if ($result) {
                $i = 0;
                foreach ($result as $value) {
                    if ($value['location_type'] == 0) {
                        $result[$i]['store_country'] = $value['name'];
                        $result[$i]['store_state'] = '';
                        $result[$i]['store_city'] = '';
                        $result[$i]['store_location'] = '';
                    } else if ($value['location_type'] == 1) {
                        $select = $this->select()
                                ->setIntegrityCheck(false)
                                ->from(array('loc' => 'location'))
                                ->where('loc.location_id=?', $value['parent_id']);
                        $result1 = $this->getAdapter()->fetchRow($select);
                        $result[$i]['store_state'] = $value['name'];
                        $result[$i]['store_country'] = $result1['name'];
                        $result[$i]['store_city'] = '';
                        $result[$i]['store_location'] = '';
                    } else if ($value['location_type'] == 2) {
                        $select = $this->select()
                                ->setIntegrityCheck(false)
                                ->from(array('loc' => 'location'))
                                ->where('loc.location_id=?', $value['parent_id']);
                        $result2 = $this->getAdapter()->fetchRow($select);
                        $result[$i]['store_city'] = $value['name'];
                        $result[$i]['store_state'] = $result2['name'];
                        if ($result2['parent_id']) {
                            $select = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('loc' => 'location'))
                                    ->where('loc.location_id=?', $result2['parent_id']);
                            $result3 = $this->getAdapter()->fetchRow($select);
                            $result[$i]['store_country'] = $result3['name'];
                            $result[$i]['store_location'] = '';
                        }
                    } else if ($value['location_type'] == 3) {
                        $select = $this->select()
                                ->setIntegrityCheck(false)
                                ->from(array('loc' => 'location'))
                                ->where('loc.location_id=?', $value['parent_id']);
                        $result4 = $this->getAdapter()->fetchRow($select);
                        $result[$i]['store_location'] = $value['name'];
                        $result[$i]['store_city'] = $result4['name'];
                        if ($result4['parent_id']) {
                            $select = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('loc' => 'location'))
                                    ->where('loc.location_id=?', $result4['parent_id']);
                            $result5 = $this->getAdapter()->fetchRow($select);
                            $result[$i]['store_state'] = $result5['name'];
                            if ($result5['parent_id']) {
                                $select = $this->select()
                                        ->setIntegrityCheck(false)
                                        ->from(array('loc' => 'location'))
                                        ->where('loc.location_id=?', $result5['parent_id']);
                                $result6 = $this->getAdapter()->fetchRow($select);
                                $result[$i]['store_country'] = $result6['name'];
                            }
                        }
                    } else {
                        
                    }
                    $i++;
                }
                if ($result) {

                    return $result;
                }
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception('Unable to access data :' . $e);
        }
    }

    public function searchByNames() {
        if (func_num_args() > 0) {
            $name = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('store_name LIKE ?', '%' . $name . '%');

                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                } else {

                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }
        } else {

            throw new Exception('Argument Not Passed');
        }
    }

    public function updatestores() {
        if (func_num_args() > 0) {

            $store_id = func_get_arg(0);
            $avaragestarratings = func_get_arg(1);
            try {
                $data = array(
                    'store_rating' => $avaragestarratings,
                );

                $result = $this->update($data, 'store_id = "' . $store_id . '"');
            } catch (Exception $ex) {
                throw new Exception('Unable To retrieve data :' . $ex);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function getstorenamebasedReviewandratings() {
        if (func_num_args() > 0) {
            $storelocationid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this, array('store_name', 'store_rating', 'store_address', 'store_contact_number', 'store_image', 'Open_time', 'Closing_time', 'Notice', 'Deliverycharge'))
                        ->where('store_location=?', $storelocationid)
                        ->order('store_rating DESC');

                $result = $this->getAdapter()->fetchAll($select);
                return $result;
            } catch (Exception $ex) {
                throw new Exception('Unable To retrieve data :' . $ex);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev : Sibani Mishra  
     * Desc : Getting Category Details Based on Stores 
     */

    public function getcategoriesByStoreId() {
        if (func_num_args() > 0) {

            $store_id = func_get_arg(0);

            try {

                $query1 = $this->select()
                        ->from($this, array('categories' => new Zend_Db_Expr("trim(leading '[' from  trim(trailing ']' from REPLACE(category_id,'\"','')))")))
                        ->where('store_id=?', $store_id);
                $categories = $this->getAdapter()->fetchRow($query1);

                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('sd' => 'store_details'), array('sd.store_id'))
                        ->join(array('sc' => 'store_category'), 'sc.category_id IN (' . $categories['categories'] . ') ', array('sc.category_id', 'sc.cat_name'))
                        ->where('store_id=?', $store_id);

                $categoryResult = $this->getAdapter()->fetchAll($select);


//                $select = $this->select()
//                        ->setIntegrityCheck(false)
//                        ->from(array('sc' => 'store_category'), array('sc.category_id'))
//                        ->join(array('p' => 'products'), 'sc.category_id=', array('sc.cat_name'))
//                        ->where('store_id=?', $store_id);
//                
                return $categoryResult;
            } catch (Exception $ex) {
                throw new Exception('Unable to access data :' . $ex);
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    /*
     * Dev : Sibani Mishra
     * Date: 5/6/2016
     * Desc: TO select all Categories based on Store Location
     */

    public function getCategory() {
        if (func_num_args() > 0) {

            $store_location = func_get_arg(0);

            try {

                $query1 = $this->select()
                        ->from($this, array('categories' => new Zend_Db_Expr("trim(leading '[' from  trim(trailing ']' from REPLACE(category_id,'\"','')))")))
                        ->where('store_location=?', $store_location);
                $categories = $this->getAdapter()->fetchAll($query1);

//                $cat = array_merge($categories[0],$categories[1]);
//                $cat = array_map("getCategory", $categories);

                $cat = implode(",", array_map(function($temp) {
                            return $temp['categories'];
                        }, $categories));


                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('sd' => 'store_details'), array('sd.store_location'))
                        ->join(array('sc' => 'store_category'), 'sc.category_id IN (' . $cat . ') ', array('sc.category_id', 'sc.cat_name'))
                        ->group(array("sc.cat_name"))
                        ->where('store_location=?', $store_location);

                $result = $this->getAdapter()->fetchAll($select);
                return $result;
            } catch (Exception $ex) {
                throw new Exception('Unable to access data :' . $ex);
            }
        } else {

            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev: Sibani Mishra
     * Desc: fetch Stores based on categories.
     * date : 5/7/2016
     */

    public function getstoresname() {
        if (func_num_args() > 0) {

            $store_location = func_get_arg(0);

            $store_category_id = func_get_arg(1);


            try {

                $cat = implode(",", array_map(function($temp) {
                            return $temp;
                        }, $store_category_id));


                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('sd' => 'store_details'), array('sd.store_id', 'sd.store_location', 'sd.store_address', 'sd.store_contact_number', 'sd.Secondary_phone', 'sd.store_name', 'sd.store_rating', 'sd.store_image', 'sd.Open_time', 'sd.Closing_time', 'sd.store_status', 'sd.Notice', 'sd.Deliverycharge'))
                        ->where('sd.store_location=?', $store_location);

                $getstoresdetails = $this->getAdapter()->fetchAll($select);

                $storeIds = array();
                foreach ($getstoresdetails as $key => $val) {
                    $storeIds[] = $val['store_id'];
                }


                $store_id = implode(",", array_map(function($temp) {
                            return $temp;
                        }, $storeIds));

                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('sd' => 'store_details'), array('sd.store_id', 'sd.store_location', 'sd.store_address', 'sd.store_contact_number', 'sd.Secondary_phone', 'sd.store_name', 'sd.store_rating', 'sd.store_image', 'sd.Open_time', 'sd.Closing_time', 'sd.store_status', 'sd.Notice', 'sd.Deliverycharge', 'sd.category_id as stor_cat_id'))
                        ->join(array('sc' => 'store_category'), 'sc.category_id IN(' . $cat . ')', array('sc.cat_name', 'sc.category_id'))
                        ->where('sd.store_id IN (?)', $storeIds);

                $getdetailsofcategories = $this->getAdapter()->fetchAll($select);

                $storeDetail = array();

                foreach ($getdetailsofcategories as $key => $value) {

                    $getdetailsofcategories[$key]['stor_cat_id'] = json_decode($value['stor_cat_id']);

                    if (!in_array($value['category_id'], $getdetailsofcategories[$key]['stor_cat_id']))
                        unset($getdetailsofcategories[$key]);
                }

                $prevId = array();
                foreach ($getdetailsofcategories as $key => $value) {
                    if (!in_array($value['store_id'], $prevId)) {
                        $i = 0;
                        $j = 0;
                        foreach ($getdetailsofcategories as $subKey => $subValue) {
                            if ($getdetailsofcategories[$key]['store_id'] == $subValue['store_id']) {

                                if ($i == 0) {
                                    $storeDetail[$key]['store_id'] = $subValue['store_id'];
                                    $storeDetail[$key]['store_location'] = $subValue['store_location'];
                                    $storeDetail[$key]['store_address'] = $subValue['store_address'];
                                    $storeDetail[$key]['store_contact_number'] = $subValue['store_contact_number'];
                                    $storeDetail[$key]['Secondary_phone'] = $subValue['Secondary_phone'];
                                    $storeDetail[$key]['store_name'] = $subValue['store_name'];
                                    $storeDetail[$key]['store_rating'] = $subValue['store_rating'];
                                    $storeDetail[$key]['store_image'] = $subValue['store_image'];
                                    $storeDetail[$key]['Open_time'] = $subValue['Open_time'];
                                    $storeDetail[$key]['Closing_time'] = $subValue['Closing_time'];
                                    $storeDetail[$key]['store_status'] = $subValue['store_status'];
                                    $storeDetail[$key]['Notice'] = $subValue['Notice'];
                                    $storeDetail[$key]['Deliverycharge'] = $subValue['Deliverycharge'];
                                    $storeDetail[$key]['category_details'][$j]['category_id'] = $subValue['category_id'];
                                    $storeDetail[$key]['category_details'][$j]['category_name'] = $subValue['cat_name'];
                                } else {
                                    $storeDetail[$key]['category_details'][$j]['category_id'] = $subValue['category_id'];
                                    $storeDetail[$key]['category_details'][$j]['category_name'] = $subValue['cat_name'];
                                    unset($getdetailsofcategories[$subKey]);
                                }

                                $j++;
                                $i++;
                            }
                        }
                        $prevId[] = $value['store_id'];
                    }
                }

                return $storeDetail;
            } catch (Exception $ex) {
                throw new Exception('Unable To retrieve data :' . $ex);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

}

?>