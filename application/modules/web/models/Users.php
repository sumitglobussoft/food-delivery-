<?php

class Web_Model_Users extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'users';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_Users();
        return self::$_instance;
    }

   /*
   * dev:priyankav varanasi
   * date:5/5/2015
   * desc: to get users list form db 
   */ 
    public function getUsersDeatils() {
        $select = $this->select()
                ->from(array('u' => 'users'))
                ->where('u.role != 2');

        $result = $this->getAdapter()->fetchAll($select);
        if ($result) :
            return $result;
        endif;
    }

    /*
   * dev:priyankav varanasi
   * date:5/5/2015
   * desc: to active and deactive user
   */
    public function userActiveDeactive() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $data = array('status' => new Zend_DB_Expr('IF(status=1, 0, 1)'));
                $result = $this->update($data, 'user_id = "' . $uid . '"');
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
   * dev:priyankav varanasi
   * date:5/5/2015
   * desc: to delete user from db
   */
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

    public function getUsersDeatilsByID() {
        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from(array('u' => 'users'))
                        ->setIntegrityCheck(false)
                        ->join(array('ctry' => 'countries'), 'ctry.country_id = u.country_id', array("ctry.country_name"))
                        ->join(array('st' => 'states'), 'st.state_id = u.state_id', array("st.state_code"))
                        ->where('u.user_id =?', $uid);

                $result = $this->getAdapter()->fetchRow($select);
                if ($result) :
                    return $result;
                endif;
            } catch (Exception $e) {
                throw new Exception($e);
            }
        else :
            throw new Exception('Argument Not Passed');
        endif;
    }

   /*
   * dev:priyankav varanasi
   * date:5/5/2015
   * desc: to update user from db
   */
    
    public function updateUserDetails() {

        if (func_num_args() > 0):
            $uid = func_get_arg(0);
            $userdata = func_get_arg(1); 
            try {
                $result = $this->update($userdata, 'user_id = "' . $uid . '"');
                if ($result) {
                    return $result;
                } else {
                    return 0;
                }
            } catch (Exception $e) {
                throw new Exception($e);
            }
        else :
            throw new Exception('Argument Not Passed');
        endif;
    } 
    
    
      public function getTotalUser() {

        $select = $this->select()
                ->from($this, array("Totaluser" => "COUNT(*)"))
                ->where('role !=?', '2');

        $result = $this->getAdapter()->fetchRow($select);
        if ($result) {
            return $result['Totaluser'];
        } else {
            return false;
        }
    } 
    
    
     /*
   * dev:priyankav varanasi
   * date:28/5/2015
   * desc: to get user details from email ids
   */
    
    public function getUsersDeatilsByemailIds() {
                if (func_num_args() > 0):
            $emailids = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('email IN(?)', $emailids);

                $result = $this->getAdapter()->fetchAll($select);
                if ($result) :
                    return $result;
                endif;
            } catch (Exception $e) {
                throw new Exception($e);
            }
        else :
            throw new Exception('Argument Not Passed');
        endif;
    }
    
    
    /**
     * Developer : Ram
     * Date : 27/05/2015
     * Description : Show user statics/     
     */
     public function userStatics()
    { 
         if (func_num_args() > 0) {
            $year = func_get_arg(0);
     $select = "SELECT COUNT(u.user_id) AS total, m.month
                FROM (
                      SELECT 'JAN' AS MONTH
                      UNION SELECT 'FEB' AS MONTH
                      UNION SELECT 'MAR' AS MONTH
                      UNION SELECT 'APR' AS MONTH
                      UNION SELECT 'MAY' AS MONTH
                      UNION SELECT 'JUN' AS MONTH
                      UNION SELECT 'JUL' AS MONTH
                      UNION SELECT 'AUG' AS MONTH
                      UNION SELECT 'SEP' AS MONTH
                      UNION SELECT 'OCT' AS MONTH
                      UNION SELECT 'NOV' AS MONTH
                      UNION SELECT 'DEC' AS MONTH
                     ) AS m
               LEFT JOIN users u ON MONTH(STR_TO_DATE(CONCAT(m.month, ' $year'),'%M %Y')) = MONTH(u.reg_date) AND YEAR(u.reg_date) = '$year'
               GROUP BY m.month
               ORDER BY 1+1";



        $result = $this->getAdapter()->fetchAll($select);        
        return $result;
    }
    }


}