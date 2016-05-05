<?php

class Admin_Model_NewsletterLog extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'newsletter_log';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Admin_Model_NewsletterLog();
        return self::$_instance;
    }
    
    /**
     * @return int
     * @throws Exception
     * @since 7-9-2015
     * @author Harshal Wagh
     * @uses newsletter::AddNewsletter[1]
     */
     public function AddNewsletter(){
        
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
     * @return array of array
     * @throws Exception
     * @since 7-9-2015
     * @author Harshal Wagh
     * @uses newsletter::sendNewsletter[1]
     */
    public function getNewsletterDetail(){
         $select = $this->select()
                ->from($this);
        $result = $this->getAdapter()->fetchAll($select);
       // echo '<pre>';print_r($result);die;
        if ($result) :
            return $result;
        endif;
    }
	
	 public function getNewsletterDetailbyId($newsletterId) {
        $select = $this->select()
                ->from($this)
                ->where('newsletter_log_id ="' . $newsletterId . '"');
        $result = $this->getAdapter()->fetchRow($select);
        // echo '<pre>';print_r($result);die;
        if ($result) :
            return $result;
        endif;
    }
    
    public function UpdateNewsletter() {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $newsletterId = func_get_arg(1);
            $select = $this->select()
                    ->from($this)
                    ->where('newsletter_log_id = ?', $newsletterId);
            $result = $this->getAdapter()->fetchRow($select);
            if ($result) {
                $updated = $this->update($data, 'newsletter_log_id = ' . $newsletterId);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    
    public function DeleteNewsletter() {

        if (func_num_args() > 0) {
            $newsletteLogid = func_get_arg(0);
            $db = Zend_Db_Table::getDefaultAdapter();
            $where = $db->quoteInto('newsletter_log_id = ?', $newsletteLogid);
            $result = $db->delete('newsletter_log', $where);
            if ($result)
                return true;
            else {
                return false;
            }
        }
    }
	
}