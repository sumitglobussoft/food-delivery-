<?php
  /*
   * Dev : Priyanka Varanasi
   * Date: 10/10/2015
   * Desc: Products Modal
   */


class Admin_Model_HotelDetails extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'hotel_details';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Admin_Model_HotelDetails();
        return self::$_instance;
    }
     /*
   * Dev : Priyanka Varanasi
   * Date: 10/10/2015
   * Desc: TO select all products in db
   */
    public function selectAllHotels(){
         
            try {

                $select = $this->select()
                        ->from($this);
                 $result = $this->getAdapter()->fetchAll($select);
               
            if ($result) {
                return $result;
            }else{
                
                return null;
            } 
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }

      
    }

}
?>