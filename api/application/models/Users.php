<?php

/*
 * Dev : Priyanka Varanasi
 * Date: 2/12/2015
 * Desc: Users Modal Design
 */

class Application_Model_Users extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'users';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_Users();
        return self::$_instance;
    }

    /*
     * Dev :- Priyanka Varanasi
     * date :- 2/12/2015
     * Desc :- To insert user info
     */

    public function insertUser() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);

            try {
                $responseId = $this->insert($data);
                return $responseId;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function insertNewUsercreds() {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = $this->insert($data);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
            return $result;
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
                        ->where('uname = ?', $userName);

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

    /*
     * Dev :- vivek Chaudhari
     * date :- 13March2015
     * Desc :- check email id exist or not
     * @params : <string> emailid
     * @return :- <boolean> response
     */

    public function isVaildEmail($email) {
        $select = $this->select()
                ->from($this)
                ->where('email = ?', $email);
        $result = $this->getAdapter()->fetchRow($select);
        if ($result) {
            return true;
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


//
//            $result = $this->_db_table->select()
//                    ->where('email=?', $email)
//                    ->where('password=?', $password)->query()
//                    ->fetchAll();
//
//            return $result;

            try {
                $select = $this->select()
                        ->from($this)
                        ->where('email = ?', $email)
                        ->where('password = ?', $password);
//              echo  $select;die("dhjg");        
                $result = $this->getAdapter()->fetchRow($select);
//echo $result;die("djhg");
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
                        ->where('uname = ?', $username)
                        ->where('password = ?', $password);
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
     * Dev :- priyanka varanasi
     * date :- 5/12/2015
     * Desc :- To validate fb user
     */

    public function checkFBUserExist() {
        if (func_num_args() > 0) {
            $fbId = func_get_arg(0);

            try {
                $select = $this->select()
                        ->from($this)
                        ->where('fb_id = ?', $fbId);
                $result = $this->getAdapter()->fetchRow($select);
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $exc) {
                throw new Exception('Unable to update, exception occured' . $exc);
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    public function checkTWTUserExist() {
        if (func_num_args() > 0) {
            $fbId = func_get_arg(0);

            try {
                $select = $this->select()
                        ->from($this)
                        ->where('twt_id = ?', $fbId);
                $result = $this->getAdapter()->fetchRow($select);
                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $exc) {
                throw new Exception('Unable to update, exception occured' . $exc);
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    /*
     * Dev :- Sibani Mishra
     * date :- 7/3/2016
     * Desc :- fetch email
     */

    public function getUserExits() {
        if (func_num_args() > 0) {
            $email = func_get_arg(0);

            try {

                $select = $this->select()
                        ->from($this)
                        ->where('email = ?', $email);
                $result = $this->getAdapter()->fetchRow($select);


                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception('Unable To Insert Exception Occured :' . $ex);
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    /*
     * Dev :- Sibani Mishra
     * date :- 11/3/2016
     * Desc :- Forgot Password
     */

    public function checkMail() {
        if (func_num_args() > 0) {
            $fpdemail = func_get_arg(0);
            $resetcode = func_get_arg(1);
            $time = time();
            $data = array(
                'reset_code' => $resetcode
            );
            $select = $this->select()
                    ->from($this)
                    ->where('email = ?', $fpdemail);
//            echo $select;die;
            $row = $this->getAdapter()->fetchRow($select);

            if ($row) {
                //if ($resetcode != "") {
                try {
                    $updated = $this->update($data, "email = '" . $fpdemail . "'");
                } catch (Exception $exc) {
                    throw new Exception('Unable to update, exception occured' . $exc);
                }
                if ($updated)
                    return $updated;
            } else {
                return false;
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    public function verifyResetCode() {
        if (func_num_args() > 0) {
            $fpwemail = func_get_arg(0);
            $resetcode = func_get_arg(1);
            $select = $this->select()
                    ->from($this)
                    ->where('reset_code = ?', $resetcode)
                    ->where('email = ?', $fpwemail);

            $row = $this->getAdapter()->fetchRow($select);
            if ($row) {
                return 1;
            } else {
                return 0;
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    public function resetPassword() {
        if (func_num_args() > 0) {
            $fpwemail = func_get_arg(0);
            $fpwresetcode = func_get_arg(1);
            $password = func_get_arg(2);

            $select = $this->select()
                    ->from($this)
                    ->where('reset_code = ?', $fpwresetcode)
                    ->where('email = ?', $fpwemailresetcode)
                    ->where();
            $row = $this->getAdapter()->fetchRow($select);
            if ($row) {
                try {
                    $data = array('password' => sha1(md5($password)), 'reset_code' => '');
                    $updated = $this->update($data, "email = '" . $fpwemail . "'");
                } catch (Exception $exc) {
                    throw new Exception('Unable to update, exception occured' . $exc);
                }
                if ($updated) {
                    return $updated;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    /*
     * Dev :- Sibani Mishra
     * date :- 14/3/2016
     * Desc :- update Activation Link 
     */

    function updateActivationToken() {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);

            $where = func_get_arg(1);
            try {
                $result = $this->update($data, "$where");
            } catch (Exception $e) {
                throw new Exception('Unable To Select Exception Occured :' . $e);
            }
            if ($result) {
                return $result;
            } else {
                return 0;
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function getUsercredsWhere() {
        if (func_num_args() > 0) {
            $activationlink = func_get_arg(0);

            try {

                $select = $this->select()
                        ->from($this)
                        ->where('ActivationToken = ?', $activationlink);
             
                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception('Unable To Insert Exception Occured :' . $ex);
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

}

?>
