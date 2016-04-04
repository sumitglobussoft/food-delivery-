<?php

/*
 * Dev : Sibani Mishra
 * Date: 3/17/2016
 * Desc: User delivery address Modal Design
 */

class Application_Model_UserDeliveryAddress extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'user_delivery_address';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_UserDeliveryAddress();
        return self::$_instance;
    }

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

    public function fetchUserDeliveryAddress() {

        if (func_num_args() > 0) {
            $userid = func_get_arg(0);

            try {

                $select = $this->select()
                        ->from($this, ['user_delivery_address_id', 'user_name', 'landmark', 'Location', 'contact_country_code', 'contact_number', 'address_line1', 'address_line2', 'district', 'state', 'country', 'pin'])
                        ->where('ordered_user_id = ?', $userid);


                $result = $this->getAdapter()->fetchAll($select);

                return $result;
            } catch (Exception $e) {
                throw new Exception('Unable To Insert Exception Occured :' . $e);
            }
        }
    }

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

}

?>
