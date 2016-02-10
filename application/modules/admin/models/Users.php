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

    public function getUserdetails() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('u' => 'users'))
                    ->joinLeft(array('um' => 'usermeta'), 'u.user_id= um.user_id', array('um.first_name', 'um.last_name'));

            $result = $this->getAdapter()->fetchAll($select);
//            echo '<pre>';print_r($result); die("ok");
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }



    public function getAllUserdetails() {
        if (func_num_args() > 0) {
            $userid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('u' => 'users'))
                        ->joinLeft(array('um' => 'usermeta'), 'u.user_id= um.user_id', array('um.first_name', 'um.last_name', 'um.phone', 'um.city', 'um.state', 'um.country', 'um.address'))
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
    public function getstatustodeactivate(){
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

}
