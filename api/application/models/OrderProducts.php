<?php
  /*
   * Dev : Priyanka Varanasi
   * Date: 22/12/2015
   * Desc: Order products Modal Design
   */

class Application_Model_OrderProducts extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'order_products';

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Application_Model_OrderProducts();
        return self::$_instance;
    }
    
    public function getAgentProductTransactions(){
        
        if(func_num_args()>0){
           $agent_id =   func_get_arg(0);
       
            try {
              $select = $this->select()
                      ->setIntegrityCheck(false)
                      ->from(array('op' => 'order_products'))
                      ->join(array('ut' => 'user_transactions'),'op.order_id=ut.order_id')
                      ->join(array('p' => 'products'),'op.product_id=p.product_id')
                      ->join(array('o' => 'orders'),'op.order_id=o.order_id')
                      ->join(array('hd' => 'hotel_details'),'op.restaurent_id= hd.id')
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
    
       public function insertOrdersProducts() {
        if (func_num_args() > 0) {
            $data1 = func_get_arg(0);
            try {
                $responseId = $this->insert($data1);
                if ($responseId) {
                    return $responseId;
                } else {
                    return null;
                }
            } catch (Exception $ex) {
                return $ex;
            }
        } else {
            return "argument not passed";
        }
    }

    public function removeOrderproduct() {
        if (func_num_args() > 0) {
            $order_product_id = func_get_arg(0);
//            print_r($order_product_id);die("dsue");
            try {
//                die("sfhf");
                $deleted = $this->delete('order_id= ' . $order_product_id);
//                print_r($deleted);die("ued");
                if ($deleted) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            throw new Exception("Argument not passed");
        }
    }
}
?>