<?php
  /*
   * Dev : Priyanka Varanasi
   * Date: 3/12/2015
   * Desc: Usersmeta Modal Design
   */


class Application_Model_Usermeta extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'usermeta';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_Usermeta();
        return self::$_instance;
    }
   /*
     * Dev :- Priyanka Varanasi
     * date :- 3/12/2015
     * Desc :- To insert user info in user meta
   */
      public function insertUserMeta() {
        
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
    /*
     * Dev :- Priyanka Varanasi
     * date :- 3/12/2015
     * Desc :- To user info 
   */
         public function updateUserMeta() {
        
        if(func_num_args()>0){
            $userid = func_get_arg(0);
            $data = func_get_arg(1);
            try {
                $result = $this->update($data, 'user_id =' . $userid);
                if ($result) {
                    return $result;
                }else{
                    return null; 
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }else{
            throw new Exception("Argument not passed");
        }
    }
        
   

}