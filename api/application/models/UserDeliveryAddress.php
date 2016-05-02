<?php

/**
 * User Delivery Address detail
 * @return type
 * @throws Exception
 * @author Sibani Mishra(sibanimishra@globussoft.in)
 */
class Application_Model_UserDeliveryAddress extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'user_delivery_address';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_UserDeliveryAddress();
        return self::$_instance;
    }

    /**
     * Insert Data for user Delivery Address detail
     * @return type
     * @throws Exception
     * @author Sibani Mishra(sibanimishra@globussoft.in)
     */
    public function insertUserDeliveryAddress() {

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

    /**
     * Update User Delivery Address details 
     * @return type
     * @throws Exception
     * @author Sibani Mishra(sibanimishra@globussoft.in)
     */
    public function updateUserDeliveryAddress() {

        if (func_num_args() > 0) {
            $userid = func_get_arg(0);
            $addressid = func_get_arg(1);
            $data = func_get_arg(2);
            $where = array();
            $where[] = $this->getAdapter()->quoteInto('user_delivery_address_id= ?', $addressid);

            $update = $this->update($data, $where);

            return $update;
        } else {

            throw new Exception("Argument not passed");
        }
    }

    /**
     * Select  User Delivery Address detail
     * @return type
     * @throws Exception
     * @author Sibani Mishra(sibanimishra@globussoft.in)
     */
    public function fetchUserDeliveryAddress() {

        if (func_num_args() > 0) {
            $userid = func_get_arg(0);

            try {

                $select = $this->select()
                        ->from($this, ['user_delivery_address_id', 'user_name', 'landmark', 'Location', 'contact_country_code', 'user_contact_number', 'address_line1', 'address_line2', 'district', 'state', 'country', 'pin'])
                        ->where('ordered_user_id = ?', $userid);


                $result = $this->getAdapter()->fetchAll($select);

                return $result;
            } catch (Exception $e) {
                throw new Exception('Unable To Insert Exception Occured :' . $e);
            }
        }
    }

    /**
     * Fetch according to User id User Delivery Address detail
     * @return type
     * @throws Exception
     * @author Sibani Mishra(sibanimishra@globussoft.in)
     */
    public function selectuserid() {

        if (func_num_args() > 0) {

            $userid = func_get_arg(0);

            try {
                $select = $this->select()
                        ->from($this, 'COUNT(*)')
                        ->where('ordered_user_id=?', $userid);
                $result = $this->getAdapter()->fetchAll($select);
                return $result[0]['COUNT(*)'];
            } catch (Exception $ex) {
                throw new Exception('Unable To Insert Exception Occured :' . $ex);
            }
        }
    }

    public function selectUserDeliveryAddress() {
        if (func_num_args() > 0) {
            $addressid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->from($this)
                        ->where('user_delivery_address_id=?', $addressid);

                $result = $this->getAdapter()->fetchRow($select);

                if ($result) {
                    return $result;
                } else {

                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception('Unable To Insert Exception Occured :' . $ex);
            }
        }
    }

    /**
     *  Remove User Delivery Address detail
     * @return type
     * @throws Exception
     * @author Sibani Mishra(sibanimishra@globussoft.in)
     */
    public function removeUserDeliveryAddress() {
        if (func_num_args() > 0) {
            $addressid = func_get_arg(0);
            try {
                $deleted = $this->delete('user_delivery_address_id= ' . $addressid);
                if ($deleted) {
                    return $deleted;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                throw new Exception('Unable To Insert Exception Occured :' . $ex);
            }
        }
    }

    public function fetchDetails() {

        if (func_num_args() > 0) {

            $addressid = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('uda' => 'user_delivery_address'))
                        ->join(array('oa' => 'order_address'), 'uda.user_name=oa.user_name')
                        ->where('uda.user_delivery_address_id=?', $addressid);

                $row = $this->getAdapter()->fetchRow($select);
                return $row;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

    public function fetchUserDeliveryAddressByAddressID() {

        if (func_num_args() > 0) {
            $addressid = func_get_arg(0);

            $oldphonenumber = func_get_arg(1);

            try {

                $select = $this->select()
                        ->from($this)
                        ->where('user_delivery_address_id=?', $addressid)
                        ->where('user_contact_number=?', $oldphonenumber);
//  echo $select;die;
                $result = $this->getAdapter()->fetchRow($select);

                return $result;
            } catch (Exception $e) {
                throw new Exception('Unable To Insert Exception Occured :' . $e);
            }
        }
    }

    /**
     * Update Contact Number  User Delivery Address detail
     * @return type
     * @throws Exception
     * @author Sibani Mishra(sibanimishra@globussoft.in)
     */
    public function updateUserDeliveryAddressWhere() {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $update = $this->update($data, $where);
                return $update;
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }

}

?>
