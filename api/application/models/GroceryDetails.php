<?php

/*
 * Dev : Priyanka Varanasi
 * Date: 10/10/2015
 * Desc: Products Modal
 */

class Application_Model_GroceryDetails extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'grocery_details';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_GroceryDetails();
        return self::$_instance;
    }

    /*
     * Dev : sowmya
     * Date: 26/4/2016
     * Desc: TO select all grocery in db
     */

    public function selectAllGrocery() {

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

    //dev:priyanka varanasi
    //desc: to fetch agent grocerys
    //date:18/12/2015
    public function getGrocerydetails() {
        if (func_num_args() > 0) {
            $agent_id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('gd' => 'grocery_details'), array('gd.agent_id', 'gd.Address', 'gd.grocery_contact_number', 'gd.Secondary_phone', 'gd.Grocery_name', 'gd.Grocery_image', 'gd.Open_time', 'gd.Closing_time', 'gd.grocery_status', 'gd.Notice', 'gd.grocery_id', 'gd.Grocery_rating'))
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

    //dev:priyanka varanasi
    //desc:activate and deactive of grocery
    //date:18/12/2015
    public function getstatusChangeOfGrocery() {
        if (func_num_args() > 0):
            $groceryid = func_get_arg(0);
            try {
                $data = array('grocery_status' => new Zend_DB_Expr('IF(grocery_status=1, 0, 1)'));
                $result = $this->update($data, 'grocery_id = "' . $groceryid . '"');
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

    //dev:priyanka varanasi
    //desc: to delete grocery
    //date:18/12/2015

    public function groceryDelete() {
        if (func_num_args() > 0):
            $groceryid = func_get_arg(0);

            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('grocery_id = ?' => $groceryid));
                $delete = $db->delete('grocery_details', $where);
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
    //desc:to fetch grocery details by grocery id
    //date:12/4/2016
    public function getGrocerydetailsByGroceryId() {
        if (func_num_args() > 0) {
            $grocery_id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hd' => 'grocery_details'))
                        ->joinLeft(array('ag' => 'agents'), 'hd.agent_id= ag.agent_id')
                        ->joinLeft(array('l' => 'location'), 'hd.grocery_location= l.location_id')
                        ->where('hd.grocery_id=?', $grocery_id);
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

    //dev:priyanka varanasi
    //desc: to update edited grocery details based on grocery id
    //date:18/12/2015
    public function updateGroceryDetails() {

        if (func_num_args() > 0) {
            $groceryid = func_get_arg(0);
            $data = func_get_arg(1);
            try {
                $result = $this->update($data, 'grocery_id =' . $groceryid);
//                print_r($result);die;
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
     * Dev: priyanka Varanasi
     * Desc: to insert grocery details 
     * Date : 21/12/2015
     * 
     */

    public function insertGroceryDetails() {

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
     * Dev: Priyanka Varanasi
     * Date : 21/12/2015
     * Desc : TO get all menu details from all grocerys
     */

    public function GetGrocerysAndMenu() {

        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('hd' => 'grocery_details'))
                    ->join(array('pr' => 'products'), 'hd.id= pr.grocery_id')
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
                        ->from(array('hd' => 'grocery_details'))
                        ->join(array('l' => 'location'), 'hd.grocery_location=l.location_id')
                        ->where('hd.grocery_location=?', $locationid)
                        ->where('l.parent_id=?', $cityid)
                        ->where('l.location_type=?', 3)
                        ->where('hd.grocery_status=?', 1);

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
                        ->from(array('hd' => 'grocery_details'))
                        ->join(array('l' => 'location'), 'hd.grocery_location=l.location_id')
                        ->where('hd.grocery_location=?', $cityid)
                        ->where('l.location_type=?', 2)
                        ->where('hd.grocery_status=?', 1);
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
     * Dev : Priyanka Varanasi
     * Modyfied By : Nitin Kumar Gupta
     * Modyfied Date : 15 FEB 2016
     */

    public function getcategoriesByGroceryId() {

        if (func_num_args() > 0) {
            $grocery_id = func_get_arg(0);

            try {

                $selectMenu = $this->select()
                        ->from(array('hd' => 'grocery_details'), array('hd.id'))
                        ->setIntegrityCheck(false)
                        ->joinLeft(array('p' => 'products'), 'hd.id=p.grocery_id', array('p.category_id'))
                        ->joinLeft(array('cat' => 'menu_category'), 'p.category_id=cat.category_id')
                        ->where('hd.id=?', $grocery_id)
                        ->where('hd.grocery_status=?', 1)
                        ->where('cat.cat_status=?', 1)
                        ->distinct('p.category_id')
                        ->order('p.category_id ASC');

                $selectCuisine = $this->select()
                        ->from(array('hd' => 'grocery_details'), array('hd.id'))
                        ->setIntegrityCheck(false)
                        ->joinLeft(array('p' => 'products'), 'hd.id=p.grocery_id', array('p.cuisine_id'))
                        ->joinLeft(array('fc' => 'famous_cuisines'), 'p.cuisine_id=fc.cuisine_id')
                        ->where('hd.id=?', $grocery_id)
                        ->where('hd.grocery_status=?', 1)
                        ->where('fc.cuisine_status=?', 1)
                        ->distinct('p.cuisine_id')
                        ->order('p.cuisine_id ASC');

                $resultMenu = $this->getAdapter()->fetchAll($selectMenu);
                $resultCuisine = $this->getAdapter()->fetchAll($selectCuisine);

                $categorys = array();

                if ($resultMenu) {
                    $categorys['menuList'] = $resultMenu;
                } else {
                    $categorys['menuList'] = array();
                }

                if ($resultCuisine) {
                    $categorys['cuisineList'] = $resultCuisine;
                } else {
                    $categorys['cuisineList'] = array();
                }

                if (!empty($categorys['menuList']) || !empty($categorys['cuisineList'])) {
                    return $categorys;
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

    /*
     * Dev : Priyanka Varanasi
     * Date: 16/1/2016
     * Desc: TO select all grocerys 
     */

    public function selectAllGrocerysLocations() {

        try {
            $select = $this->select()
                    ->from(array('hd' => 'grocery_details'))
                    ->setIntegrityCheck(false)
                    ->joinLeft(array('loc' => 'location'), 'hd.grocery_location= loc.location_id');
            //->joinLeft(array('ag' => 'agents'), 'hd.agent_id= ag.agent_id');
            $result = $this->getAdapter()->fetchAll($select);
            if ($result) {
                $i = 0;
                foreach ($result as $value) {
                    if ($value['location_type'] == 0) {
                        $result[$i]['grocery_country'] = $value['name'];
                        $result[$i]['grocery_state'] = '';
                        $result[$i]['grocery_city'] = '';
                        $result[$i]['grocery_location'] = '';
                    } else if ($value['location_type'] == 1) {
                        $select = $this->select()
                                ->setIntegrityCheck(false)
                                ->from(array('loc' => 'location'))
                                ->where('loc.location_id=?', $value['parent_id']);
                        $result1 = $this->getAdapter()->fetchRow($select);
                        $result[$i]['grocery_state'] = $value['name'];
                        $result[$i]['grocery_country'] = $result1['name'];
                        $result[$i]['grocery_city'] = '';
                        $result[$i]['grocery_location'] = '';
                    } else if ($value['location_type'] == 2) {
                        $select = $this->select()
                                ->setIntegrityCheck(false)
                                ->from(array('loc' => 'location'))
                                ->where('loc.location_id=?', $value['parent_id']);
                        $result2 = $this->getAdapter()->fetchRow($select);
                        $result[$i]['grocery_city'] = $value['name'];
                        $result[$i]['grocery_state'] = $result2['name'];
                        if ($result2['parent_id']) {
                            $select = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('loc' => 'location'))
                                    ->where('loc.location_id=?', $result2['parent_id']);
                            $result3 = $this->getAdapter()->fetchRow($select);
                            $result[$i]['grocery_country'] = $result3['name'];
                            $result[$i]['grocery_location'] = '';
                        }
                    } else if ($value['location_type'] == 3) {
                        $select = $this->select()
                                ->setIntegrityCheck(false)
                                ->from(array('loc' => 'location'))
                                ->where('loc.location_id=?', $value['parent_id']);
                        $result4 = $this->getAdapter()->fetchRow($select);
                        $result[$i]['grocery_location'] = $value['name'];
                        $result[$i]['grocery_city'] = $result4['name'];
                        if ($result4['parent_id']) {
                            $select = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('loc' => 'location'))
                                    ->where('loc.location_id=?', $result4['parent_id']);
                            $result5 = $this->getAdapter()->fetchRow($select);
                            $result[$i]['grocery_state'] = $result5['name'];
                            if ($result5['parent_id']) {
                                $select = $this->select()
                                        ->setIntegrityCheck(false)
                                        ->from(array('loc' => 'location'))
                                        ->where('loc.location_id=?', $result5['parent_id']);
                                $result6 = $this->getAdapter()->fetchRow($select);
                                $result[$i]['grocery_country'] = $result6['name'];
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
                        ->where('grocery_name LIKE ?', '%' . $name . '%');

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

    /*
     * Dev : Sibani Mishra
     * Date: 1/4/2016
     * Desc: TO select all Cuisines based on Grocery Location
     */

    public function getCuisines() {
        if (func_num_args() > 0) {
            $grocery_location = func_get_arg(0);

            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hd' => 'grocery_details'))
                        ->join(array('hc' => 'grocery_cuisines'), 'hd.id=hc.grocery_id', array('hc.cuisine_id'))
                        ->join(array('fc' => 'famous_cuisines'), 'hc.cuisine_id=fc.cuisine_id', array('fc.Cuisine_name'))
                        ->where('grocery_location=?', $grocery_location)
                        ->group(array("hc.cuisine_id", "fc.Cuisine_name")); //remove same rows.
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
     * Desc: fetch Grocerys based on cuisines.
     * date : 4/2/2016
     */

    public function gethotalsname() {
        if (func_num_args() > 0) {
            $grocery_locations = func_get_arg(0);

            $cuisine_id = func_get_arg(1);


            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hd' => 'grocery_details'), array('hd.id', 'hd.grocery_location', 'hd.address', 'hd.grocery_rating', 'hd.grocery_name', 'hd.grocery_image', 'hd.open_time', 'hd.closing_time', 'hd.grocery_status', 'hd.notice', 'hd.minorder', 'hd.deliverycharge'))
                        ->where('hd.grocery_location=?', $grocery_locations);
                $getgrocerysdetails = $this->getAdapter()->fetchAll($select);

                $groceryIds = array();
                foreach ($getgrocerysdetails as $key => $val) {
                    $groceryIds[] = $val['id'];
                }

                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('hc' => 'grocery_cuisines'), array('hc.grocery_id', 'hc.cuisine_id'))
                        ->join(array('fc' => 'famous_cuisines'), 'hc.cuisine_id=fc.cuisine_id', array('fc.Cuisine_name'))
                        ->where('hc.grocery_id IN (?)', $groceryIds)
                        ->where('hc.cuisine_id IN (?)', $cuisine_id);
                $getdetailsofcuisines = $this->getAdapter()->fetchAll($select);

                foreach ($getgrocerysdetails as $groceryKey => $groceryVal) {
                    $groceryIds[] = $val['id'];
                    foreach ($getdetailsofcuisines as $cuisineKey => $cuisineVal) {
                        if ($groceryVal['id'] == $cuisineVal['grocery_id']) {
                            unset($cuisineVal['grocery_id']);
                            $getgrocerysdetails[$groceryKey]['cuisines_details'][] = $cuisineVal;
                        }
                    }
                }

                foreach ($getgrocerysdetails as $groceryKey => $groceryVal) {

                    if (!isset($groceryVal['cuisines_details']))
                        unset($getgrocerysdetails[$groceryKey]);
                }
                $getgrocerysdetails = array_values($getgrocerysdetails);
//                echo '<pre>';
//                print_r($getgrocerysdetails);
//                die("Test");
                return $getgrocerysdetails;
            } catch (Exception $ex) {
                throw new Exception('Unable To retrieve data :' . $ex);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function updategrocerys() {
        if (func_num_args() > 0) {

            $grocery_id = func_get_arg(0);
            $avaragestarratings = func_get_arg(1);
            try {
                $data = array(
                    'grocery_rating' => $avaragestarratings,
                );

                $result = $this->update($data, 'id = "' . $grocery_id . '"');
            } catch (Exception $ex) {
                throw new Exception('Unable To retrieve data :' . $ex);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function gethotalsnamebasedReviewandratings() {
        if (func_num_args() > 0) {
            $grocerylocationid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this, array('grocery_name', 'grocery_rating', 'address', 'grocery_contact_number', 'grocery_image', 'open_time', 'closing_time', 'notice', 'minorder', 'deliverycharge'))
                        ->where('grocery_location=?', $grocerylocationid)
                        ->order('grocery_rating DESC');

                $result = $this->getAdapter()->fetchAll($select);
                return $result;
            } catch (Exception $ex) {
                throw new Exception('Unable To retrieve data :' . $ex);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

}

?>