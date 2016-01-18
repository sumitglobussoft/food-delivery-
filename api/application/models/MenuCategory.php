<?php
  /*
   * Dev : Priyanka Varanasi
   * Date: 22/12/2015
   * Desc: Menu category Modal Design
   */

class Application_Model_MenuCategory extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'menu_category';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_MenuCategory();
        return self::$_instance;
    }
    
        /*
   * Dev : Priyanka Varanasi
   * Date: 22/12/2015
   * Desc: TO select all categorys in db
   */
    public function selectAllCategorys(){
         
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
    
    
    public function GetMenuProducts() {

               try {

                $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->from(array('cat' => 'menu_category'))
                       ->join(array('pr' => 'products'), 'cat.category_id=pr.category_id');
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