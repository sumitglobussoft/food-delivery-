<?php

class Admin_Model_Users extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'users';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_Users();
        }
        return self::$_instance;
    }

    /*
      developer: sowmya
     * date :5 april 2016 
      function :function to get all user details */

    public function getUserdetails() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('u' => 'users'))
                    ->joinLeft(array('um' => 'usermeta'), 'u.user_id= um.user_id', array('um.first_name', 'um.last_name'))
                    ->order('reg_date DESC');

            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    /*
      developer: sowmya
     * date :28 march 2016 
      function :function to get all user details */

    public function getAllUserdetails() {
        if (func_num_args() > 0) {
            $userid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('u' => 'users'))
                        ->joinLeft(array('um' => 'usermeta'), 'u.user_id= um.user_id', array('um.first_name', 'um.last_name', 'um.phone', 'um.city', 'um.state', 'um.country', 'um.contact_country_code','um.profilepic_url'))
                        ->where('u.user_id = ?', $userid);

                $result = $this->getAdapter()->fetchRow($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        }
    }

    public function updateUserdetails() {
//        die("ok");
        if (func_num_args() > 0) {
            $userid = func_get_arg(0);
            $userdata = func_get_arg(1);

            try {
                $result1 = $this->update($userdata, 'user_id = "' . $userid . '"');

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
     * Dev : Sowmya
     * Date: 17/3/2016
     * Desc:add new user details
     */

    public function addUserdetails() {
        if (func_num_args() > 0) {
            $userdata = func_get_arg(0);

            try {
                $row = $this->insert($userdata);
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

    //dev:priyanka varanasi
    //desc:activate and deactive of the user
    //date:16/12/2015
    public function getstatustodeactivate() {
        if (func_num_args() > 0):
            $userid = func_get_arg(0);
            try {
                $data = array('status' => new Zend_DB_Expr('IF(status=1, 0, 1)'));
                $result = $this->update($data, 'user_id = "' . $userid . '"');
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
    //desc: to delete user
    //date:16/12/2015

    public function userdelete() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('user_id = ?' => $uid));
                $db->delete('users', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $uid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    /**
     * @params String :$where
     * @return array of arrays, arrays of details of all Customers with condition
     * @since 1/4/2016
     * @author sowmya
     * @uses Users::PendingUsers[1],Users::availablevUsers[1],Users::deletedUsers[1],Notification::sendUserNotification[1]
     */
    public function getUsersWhere() {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $sql = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('u' => 'users'))
                    ->joinLeft(array('um' => 'usermeta'), 'u.user_id= um.user_id', array('um.first_name', 'um.last_name'))
                    ->where($where);
            $result = $this->getAdapter()->fetchAll($sql);
            if ($result) {
                return $result;
            } else {
                return false;
            }
        }
    }

}
