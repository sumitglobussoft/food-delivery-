<?php

class Application_Model_Reviews extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'reviews';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Application_Model_Reviews();
        }
        return self::$_instance;
    }

//dev:sowmya
    //desc:hotel reviews
    //date:20/4/2016
    public function getAllHotelReviews() {
        if (func_num_args() > 0) {
            $agent_id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('r' => 'reviews'))
                        ->joinLeft(array('u' => 'users'), 'u.user_id= r.user_id', array('u.user_id', 'u.uname', 'u.email'))
                        ->joinLeft(array('hd' => 'hotel_details'), 'hd.id= r.review_for_id', array('hd.id', 'hd.hotel_name'))
                        ->joinLeft(array('a' => 'agents'), 'hd.agent_id= a.agent_id')
                        ->where('review_type = ?', 0)
                        ->order('review_date DESC')
                        ->where('hd.agent_id=?', $agent_id);
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

//dev:sowmya
    //desc:grocery reviews
    //date:20/4/2016
    public function getAllStoreReviews() {
        if (func_num_args() > 0) {
            $agent_id = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('r' => 'reviews'))
                        ->joinLeft(array('u' => 'users'), 'u.user_id= r.user_id', array('u.user_id', 'u.uname', 'u.email'))
                        ->joinLeft(array('gd' => 'store_details'), 'gd.store_id= r.review_for_id', array('gd.store_id', 'gd.store_name'))
                        ->joinLeft(array('a' => 'agents'), 'gd.agent_id= a.agent_id')
                        ->where('review_type = ?', 1)
                        ->order('review_date DESC')
                        ->where('gd.agent_id=?', $agent_id);
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

    public function isavailablereview() {

        if (func_num_args() > 0) {
            $hotelid = func_get_arg(0);
            $userid = func_get_arg(1);
            try {

                $select = $this->select()
                        ->from($this)
                        ->where('review_type=0')
                        ->where("review_for_id=?", $hotelid)
                        ->where("user_id=?", $userid)
                        ->where("review_status=1 or review_status=0");

                $result = $this->getAdapter()->fetchRow($select);

                return $result;
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function addReview($data) {
        try {
            $result = $this->insert($data);
            if ($result) {
                return $result;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            throw new Exception('Unable To Insert Exception Occured :' . $e);
        }
    }

    public function gethotelsReviewsWithLimit() {
        if (func_num_args() > 0) {

            $hotelid = func_get_arg(0);

            try {

                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('r' => 'reviews'), array('review_rating', 'review_description', 'review_date'))
                        ->join(array('u' => 'users'), 'r.user_id=u.user_id', array('u.uname'))
                        ->where('r.review_type=0')
                        ->where("r.review_for_id=?", $hotelid)
                        ->where("r.review_status=1 or review_status=0");

                $result = $this->getAdapter()->fetchAll($select);

                return $result;
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function getavgratingsofindividualHotel() {
        if (func_num_args() > 0) {
            $hotelid = func_get_arg(0);
            try {

                $selectColumns = [
                    'one_star' => new Zend_Db_Expr('@one_star:=sum(case when review_rating = 1 then 1 else 0 end)'),
                    'two_star' => new Zend_Db_Expr('@two_star:=sum(case when review_rating = 2 then 1 else 0 end)'),
                    'three_star' => new Zend_Db_Expr('@three_star:=sum(case when review_rating = 3 then 1 else 0 end)'),
                    'four_star' => new Zend_Db_Expr('@four_star:=sum(case when review_rating = 4 then 1 else 0 end)'),
                    'five_star' => new Zend_Db_Expr('@five_star:=sum(case when review_rating = 5 then 1 else 0 end)'),
                ];

                $select = $this->select()
                        ->from($this, $selectColumns)
                        ->where("review_for_id=?", $hotelid);

                $result = $this->getAdapter()->fetchRow($select);

                $one_star = $result['one_star'];
                $two_star = $result['two_star'];
                $three_star = $result['three_star'];
                $four_star = $result['four_star'];
                $five_star = $result['five_star'];


                $avgresult1 = (($one_star * 1 + $two_star * 2 + $three_star * 3 + $four_star * 4 + $five_star * 5) / ($one_star + $two_star + $three_star + $four_star + $five_star));

                return $avgresult1;
            } catch (Exception $ex) {
                throw new Exception('Unable to access data :' . $ex);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

}
