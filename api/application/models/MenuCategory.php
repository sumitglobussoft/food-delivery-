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

    public function selectAllCategorys() {

        try {

            $select = $this->select()
                    ->from($this)
                    ->where('cat_status=?', 1);
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

    public function GetMenuProducts() {

        try {

            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('cat' => 'menu_category'))
                    ->join(array('pr' => 'products'), 'cat.category_id=pr.category_id');
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
     * Dev : sreekanth
     * Date: 5/5/2015
     * Desc: TO select all categorys in db
     */

    public function getcategoriesByCategoryId() {

        if (func_num_args() > 0) {
            $categoryid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('category_id=?', $categoryid);
                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

    //Dev=sreekanth
//date= 4-may-2016
    public function getstatusChangeOfHotel() {
        if (func_num_args() > 0):
            $hotelid = func_get_arg(0);
            try {
                $data = array('cat_status' => new Zend_DB_Expr('IF(cat_status=1, 0, 1)'));
                $result = $this->update($data, 'category_id = "' . $hotelid . '"');
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

//Dev=sreekanth
//date= 4-may-2016
    public function updateCategory() {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $categoryid = func_get_arg(1);
            try {
                $result1 = $this->update($data, 'category_id = "' . $categoryid . '"');

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

//Dev=sreekanth
//date= 5-may-2016
    public function hotelcategorydelete() {
        if (func_num_args() > 0):
            $categoryid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('category_id = ?' => $categoryid));
                $db->delete('menu_category', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $categoryid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

//Dev=sreekanth
//date= 5-may-2016
    public function addhotelcategory() {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $row = $this->insert($data);
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

    /*
     * Dev : sowmya
     * Date: 7/5/2016
     * Desc: TO select all categorys in db
     */

    public function selectAllCategory() {

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

}

?>