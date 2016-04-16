<?php

class Admin_Model_Usermeta extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'usermeta';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_Usermeta();
        }
        return self::$_instance;
    }

    public function updateUsermetadetails() {

        if (func_num_args() > 0) {
            $userid = func_get_arg(0);
            $usermetadata = func_get_arg(1);

            try {
                $result2 = $this->update($usermetadata, 'user_id = "' . $userid . '"');

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

    public function addUsermetaDetails() {
        if (func_num_args() > 0) {
            $usermetadata = func_get_arg(0);
            try {
                $id = $this->insert($usermetadata);
                if ($id) {
                    return $id;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To insert data :' . $e);
            }
        }
    }

    //dev:sowmya
    //desc: to delete usermeta
    //date:11/4/2016

    public function usermetadelete() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('user_id = ?' => $uid));
                $db->delete('usermeta', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $uid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

}
