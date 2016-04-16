<?php

class Admin_Model_Notification extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'notification';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_Notification();
        return self::$_instance;
    }

    /**
     * 
     * @return array of array
     * @throws Exception
     * @since  4/1/2016
     * @author sowmya
     * @uses notification::notificationLog[1]
     */
    public function getNotificationDetail() {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('n' => 'notification'), array('notification_id', 'notification_message', 'sent_date', 'status'))
                ->joinleft(array('r' => 'usermeta'), 'r.user_id=n.sent_to', array('r.first_name as receiver_fname', 'r.last_name as receiver_lname'))
                ->joinleft(array('u' => 'usermeta'), 'u.user_id=n.sent_by', array('u.first_name as sender_fname', 'u.last_name as sender_lname'))
                ->order('n.notification_id');

        $result = $this->getAdapter()->fetchAll($select);
        if ($result) :
            return $result;
        endif;
    }

    /**
     * @param int: $notificationid
     * @return int
     * @throws Exception
     * @since  4/1/2016
     * @author sowmya
     * @uses notification::notificationAjaxHandler[1]
     */
    public function deletenotificationDetail() {

        if (func_num_args() > 0) {
            $notificationid = func_get_arg(0);
            $db = Zend_Db_Table::getDefaultAdapter();
            $where = $db->quoteInto('notification_id = ?', $notificationid);
            $result = $db->delete('notification', $where);
            if ($result)
                return true;
            else {
                return false;
            }
        }
    }

    /**
     * @param array: $data
     * @return int
     * @throws Exception
     * @since  4/1/2016
     * @author sowmya
     * @uses notification::notificationAjaxHandler[2]
     */
    public function AddNotification() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);

            try {
                $response = $this->insert($data);
            } catch (Exception $e) {
                return $e->getMessage();
            }
            if ($response) {
                return $response;
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * @param int: $userId
     * @return array of array
     * @throws Exception
     * @since  4/1/2016
     * @author sowmya
     * @uses notification::notificationAjaxHandler[1]
     */
    public function getNotificationWhere() {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $select = $this->select()
                    ->from($this)
                    ->where($where)
                    ->order('sent_date DESC');
            $result = $this->getAdapter()->fetchAll($select);
            if ($result) :
                return $result;
            endif;
        }
    }

    /**
     * @param String: $where,int:$start
     * @return array of array
     * @throws Exception
     * @since  4/1/2016
     * @author sowmya
     * @uses notification::notificationAjaxHandler[1]
     */
    public function getNotificationWithLimit() {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $start = func_get_arg(1);
            $select = $this->select()
                    ->from($this)
                    ->where($where)
                    ->order('sent_date DESC')
                    ->limit(10, $start);
            $result = $this->getAdapter()->fetchAll($select);
//            print_r($result);
            if ($result) :
                return $result;
            endif;
        }
    }

    /**
     * @param int: $notificationId
     * @return int
     * @throws Exception
     * @since  4/1/2016
     * @author sowmya
     * @uses notification::notificationAjaxHandler[1]
     */
    public function changeAdminNotificationStatus() {
        if (func_num_args() > 0) {
            $notificationId = func_get_arg(0);
            $data = array('status' => 1);
            $updated = $this->update($data, "notification_id = '" . $notificationId . "'");
            return true;
        } else {
            return false;
        }
    }

}
