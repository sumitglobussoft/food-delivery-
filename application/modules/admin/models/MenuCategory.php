<?php

class Admin_Model_MenuCategory extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'menu_category';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_MenuCategory();
        }
        return self::$_instance;
    }

    public function updateMenuCatdetails() {
        if (func_num_args() > 0) {
            $categoryId = func_get_arg(0);
            $catdata = func_get_arg(1);

            try {
                $result2 = $this->update($catdata, 'category_id = "' . $categoryId . '"');
                if ($result2) {
                    return $result2;
                } else {

                    return null;
                }
            } catch (Exception $e) {

                throw new Exception('Unable To update data :' . $e);
            }
        }
    }

    public function addCatdetails() {
        if (func_num_args() > 0) {
            $catdata = func_get_arg(0);

            try {
                $row = $this->insert($catdata);
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
   * Dev : Priyanka Varanasi
   * Date: 22/12/2015
   * Desc: TO select all categorys in db
   */
    public function selectAllCategorys(){
         
            try {

                $select = $this->select()
                        ->from($this)
                        ->where('cat_status=?',1);
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
