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
    public function getCountrys(){
         try {
                $select = $this->select()
                        ->from($this)
                         ->where('location_type=?',0);
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
        public function getStates(){
         try {
                $select = $this->select()
                        ->from($this)
                         ->where('location_type=?',1);
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
        public function getCitys(){
         try {
                $select = $this->select()
                        ->from($this)
                         ->where('location_type=?',2);
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
        public function getLocations(){
         try {
                $select = $this->select()
                        ->from($this)
                         ->where('location_type=?',3);
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
   public function  getLocationsByCitys(){
    if (func_num_args() > 0) {
            $locationid = func_get_arg(0);
       try {
                $select = $this->select()
                        ->from($this)
                         ->where('parent_id=?',$locationid)
                         ->where('location_type=?',3);
                  $result = $this->getAdapter()->fetchAll($select);
              
            if ($result) {
                return $result;
            }  
            }  catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }else{
            
        }
}

        /*
     * Dev: priyanka varanasi
     * Desc: to get city name by city id 
     * date : 15/1/2015;
     */
   public function  getCityNameByCityId(){
    if (func_num_args() > 0) {
            $cityid = func_get_arg(0);
       try {
                $select = $this->select()
                        ->from($this)
                         ->where('location_id=?',$cityid)
                         ->where('location_type=?',2);
                  $result = $this->getAdapter()->fetchRow($select);
              
            if ($result) {
                return $result;
            }  
            }  catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }else{
            
        }
}


}
?>