<?php
  /*
   * Dev : Priyanka Varanasi
   * Date: 10/10/2015
   * Desc: DElivery status log modal
   */


class Application_Model_DeliveryStatusLog extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'delivery_status_log';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_DeliveryStatusLog();
        return self::$_instance;
    }
     /*
   * Dev : Priyanka Varanasi
   * Date: 10/10/2015
   * Desc: TO select all products in db
   */
    public function getOrderStatus(){
         if(func_num_args()>0){
            $orderid = func_get_arg(0) ;
         
            try {
               $select = $this->select()
                          ->from($this)
                          ->where('order_id=?',$orderid);
                 $result = $this->getAdapter()->fetchAll($select);
               
            if ($result) {
                return $result;
            }else{
                
                return null;
            } 
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }

      }else{
         throw new Exception('Argument Not Passed'); 
          
      }
    }
        
        
        
    }

?>
