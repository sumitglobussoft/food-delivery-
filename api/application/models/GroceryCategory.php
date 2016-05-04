<?php

class Application_Model_GroceryCategory extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'grocery_category';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Application_Model_GroceryCategory();
        }
        return self::$_instance;
    }


    /*
     * Dev : sowmya
     * Date: 5/4/2016
     * Desc: TO select all categorys in db
     */

    public function selectAllCategorys() {

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

    /*
     * Dev: sowmya
     * Desc: add cuisine in db
     * date : 13/1/2015;
     */

    public function addCategory() {
        if (func_num_args() > 0) {
            $Categorys = func_get_arg(0);

            try {
                $row = $this->insert($Categorys);
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
     * Dev : sowmya
     * Date: 5/4/2016
     * Desc: TO select all categorys in db
     */
    public function changeCategoryStatus() {
        if (func_num_args() > 0):
            $catid = func_get_arg(0);
            try {
                $data = array('cat_status' => new Zend_DB_Expr('IF(cat_status=1, 0, 1)'));
                $result = $this->update($data, 'category_id = "' . $catid . '"');
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
 /*
     * Dev : sowmya
     * Date: 5/4/2016
     * Desc: TO select all categorys in db
     */

    public function categorydelete() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('category_id = ?' => $uid));
                $db->delete('grocery_category', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $uid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }
    /*
     * Dev : sowmya
     * Date: 5/4/2016
     * Desc: TO editall categorys in db
     */
      public function updateCategory() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $id = func_get_arg(1);
            try {
                $result1 = $this->update($data, 'category_id = "' . $id . '"');
               
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
       /*
     * Dev : sowmya
     * Date: 5/4/2016
     * Desc: TO get all categorys by id
     */
    public function getCategoryById() {
          if (func_num_args() > 0) {
            $category_id = func_get_arg(0);
        try {
            $select = $this->select()
                    ->from($this)
                    ->where('category_id=?',$category_id);
            $result = $this->getAdapter()->fetchRow($select);
            if ($result) {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }
          }
    }
}


