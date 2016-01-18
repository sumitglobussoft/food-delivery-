<?php

/*
 * Dev : Priyanka Varanasi
 * Date: 2/12/2015
 * Desc: Users Modal Design
 */

class Application_Model_Agents extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'agents';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_Agents();
        return self::$_instance;
    }

    /*
     * Dev :- Priyanka Varanasi
     * date :- 2/12/2015
     * Desc :- To insert user info
     */

    public function insertAgent() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $responseId = $this->insert($data);
                if ($responseId) {
                    return $responseId;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev :- Priyanka Varanasi
     * date :- 2/12/2015
     * Desc :- To validate user name 
     */

    public function validateUserName() {

        if (func_num_args() > 0) {
            $userName = func_get_arg(0);
            try {

                $select = $this->select()
                        ->from($this)
                        ->where('loginname = ?', $userName);

                $result = $this->getAdapter()->fetchRow($select);
                
            if ($result) {
                return $result;
            }else{
                return null;
                
            }
            } catch (Exception $e) {
                throw new Exception('Unable To Insert Exception Occured :' . $e);
            }

        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev :- priyanka varanasi
     * date :- 2/12/2015
     * Desc :- To validate user email
     */

    public function validateUserEmail() {

        if (func_num_args() > 0) {
            $userEmail = func_get_arg(0);
            try {

                $select = $this->select()
                        ->from($this)
                        ->where('email = ?', $userEmail);

                $result = $this->getAdapter()->fetchRow($select);
                
            if ($result) {
                return $result;
            } else{
                return null;
            }
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }

        } else {
            throw new Exception('Argument Not Passed');
        }
    }



    /*
     * Dev :- vivek Chaudhari
     * date :- 13March2015
     * Desc :- To get the user contest details
     * @params : <string> emailid, <int> password
     * @return :- array of user details 
     */

    public function authenticateByEmail() {
        if (func_num_args() > 0) {
            $email = func_get_arg(0);
            $password = func_get_arg(1);
       
            try {
                $select = $this->select()
                        ->from($this)
                        ->where("email = '" . $email . "'")
                        ->where("password = '" . $password . "'");
                $result = $this->getAdapter()->fetchRow($select);
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To Insert Exception Occured :' . $e);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /*
     * Dev :- vivek Chaudhari
     * date :- 13March2015
     * Desc :- To get the user contest details
     * @params : <string> username, <int> password
     * @return :- array of user details 
     */

    public function authenticateByUsername() {
        if (func_num_args() > 0) {
            $username = func_get_arg(0);
            $password = func_get_arg(1);
           
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('loginname = ?', $username)
                        ->where('password = ?', $password);
               
                $result = $this->getAdapter()->fetchRow($select);
                if ($result) {
                    return $result;
                }else{
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To Insert Exception Occured :' . $e);
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

  

}

