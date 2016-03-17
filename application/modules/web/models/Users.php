<?php

/*
 * Dev : Sibani Mishra
 * Date: 3/10/2016
 * Desc: Users Modal Design
 */
class Web_Model_Users extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'users';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Web_Model_Users();
        }
        return self::$_instance;
    }

//    public function 
    
}
