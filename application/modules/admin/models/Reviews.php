<?php

class Admin_Model_Reviews extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'reviews';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_Reviews();
        }
        return self::$_instance;
    }

//dev:sowmya
    //desc:hotel reviews
    //date:20/4/2016
    public function getAllHotelReviews() {

        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('r' => 'reviews'))
                    ->joinLeft(array('u' => 'users'), 'u.user_id= r.user_id', array('u.user_id', 'u.uname', 'u.email'))
                    ->joinLeft(array('hd' => 'hotel_details'), 'hd.id= r.review_for_id', array('hd.id', 'hd.hotel_name'))
                    ->where('review_type = ?', 0)
                    ->order('review_date DESC');
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

//dev:sowmya
    //desc:grocery reviews
    //date:20/4/2016
    public function getAllGroceryReviews() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('r' => 'reviews'))
                    ->joinLeft(array('u' => 'users'), 'u.user_id= r.user_id', array('u.user_id', 'u.uname', 'u.email'))
                    ->joinLeft(array('gd' => 'grocery_details'), 'gd.grocery_id= r.review_for_id', array('gd.grocery_id', 'gd.Grocery_name'))
                    ->where('review_type = ?', 1)
                    ->order('review_date DESC');
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    //dev:sowmya
    //desc:activate and deactive of the reviews
    //date:20/4/2016
    public function getstatustodeactivate() {
        if (func_num_args() > 0):
            $review_id = func_get_arg(0);
            try {
                $data = array('review_status' => new Zend_DB_Expr('IF(review_status=1, 0, 1)'));
                $result = $this->update($data, 'review_id = "' . $review_id . '"');
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
    //desc:delete reviews
    //date:20/4/2016

    public function deleteReviews() {
        if (func_num_args() > 0):
            $review_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('review_id = ?' => $review_id));
                $db->delete('reviews', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $review_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

}
