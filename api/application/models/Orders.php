<?php
  /*
   * Dev : Priyanka Varanasi
   * Date: 2/12/2015
   * Desc: Users Transactiona Modal Design
   */

class Application_Model_Orders extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'orders';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_Orders();
        return self::$_instance;
    }

     /*
   * Dev : Priyanka Varanasi
   * Date: 3/12/2015
   * Desc: insert all user transaction details 
   */
    
    public function insertOrders() {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $responseId = $this->insert($data);
                if ($responseId) {
                    return $responseId;
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
    
     public function GetOrderProducts(){
        if(func_num_args()>0){
           $agent_id =   func_get_arg(0);
       
            try {
       $select = $this->select()
                      ->setIntegrityCheck(false)
                      ->from(array('o' => 'orders'))
                      ->joinLeft(array('op' => 'order_products'), 'o.order_id=op.order_id')
                      ->joinLeft(array('p' => 'products'),'op.product_id=p.product_id')
                      ->joinLeft(array('hd' => 'hotel_details'),'op.restaurent_id=hd.id')
                      ->joinLeft(array('dsl' => 'delivery_status_log'),'op.order_product_id=dsl.order_product_id')
                      ->joinLeft(array('dg' => 'delivery_guys'),'dsl.delivery_guy_id=dg.del_guy_id')
                       ->where('hd.agent_id=?',$agent_id);
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


