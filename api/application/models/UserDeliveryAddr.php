<?php
  /*
   * Dev : Priyanka Varanasi
   * Date: 3/12/2015
   * Desc: User delivery address Modal Design
   */


class Application_Model_UserDeliveryAddr extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'user_delivery_addr';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_UserDeliveryAddr();
        return self::$_instance;
    }
   /*
     * Dev :- Priyanka Varanasi
     * date :- 3/12/2015
     * Desc :- To insert user delivery address in db while orders
   */
      public function insertUserDeliveryAddress() {
        
        if(func_num_args() > 0){
            $data = func_get_arg(0);
            
            try{
                $responseId = $this->insert($data);
                
            if($responseId){
                return $responseId;
            }else{
                    
                 return null;   
                }
            }catch(Exception $e){  
               
                 return $e->getMessage(); 
            }
           
        }else{
            throw new Exception('Argument Not Passed');
        }
        
        
   }
   
         public function updateUserDeliveryAddress() {
        
         if(func_num_args()>0){
            $userid = func_get_arg(0);
            $addressid = func_get_arg(1);
            $data = func_get_arg(2);
            $where = array();
            $where[] = $this->getAdapter()->quoteInto('user_id = ?', $userid);
            $where[] = $this->getAdapter()->quoteInto('user_del_addr_id = ?', $addressid);          
            $update  =  $this->update($data,$where);
            if($update){
                return $update;
            }else{
                
                return null;
            }
        }else{
            throw new Exception("Argument not passed");
        }
    }
        
   

}
