<?php
  /*
   * Dev : Priyanka Varanasi
   * Date: 10/10/2015
   * Desc: Products Modal
   */


class Application_Model_Products extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'products';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_Products();
        return self::$_instance;
    }
     /*
   * Dev : Priyanka Varanasi
   * Date: 10/10/2015
   * Desc: TO select all products in db
   */
    public function selectAllProducts(){
         
            try {

                $select = $this->select()
                        ->from($this);
                 $result = $this->getAdapter()->fetchAll($select);
               
            if ($result) {
                return $result;
            }else{
                
                return null;
            } 
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }

      
    }
        /*
   * Dev : Priyanka Varanasi
   * Date: 18/12/2015
   * Desc: get all agent related products
   */
    public function getALLAgentProducts(){
         if(func_num_args()>0){
           $agent_id =   func_get_arg(0);
       
            try {
       $select = $this->select()
                      ->setIntegrityCheck(false)
                      ->from(array('pd' => 'products'))
                      ->joinLeft(array('ag' => 'agents'), 'pd.agent_id=ag.agent_id')
                      //>joinLeft(array('hd' => 'hotel_details'), 'pd.agent_id=hd.agent_id')
                      ->where('pd.agent_id=?',$agent_id);
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
        
     //dev:priyanka varanasi
    //desc:activate and deactive product
    //date:18/12/2015
    public function getstatusChangeOfProduct(){
          if (func_num_args() > 0):
            $productid = func_get_arg(0);
            try {
                $data = array('prod_status' => new Zend_DB_Expr('IF(prod_status=1, 0, 1)'));
                $result = $this->update($data, 'product_id = "' . $productid . '"');
            } catch (Exception $e) {
                throw new Exception($e);
            }
            if ($result):
                return $result;
            else:
                return 0;
            endif;
        else:
            throw new Exception('Argument Not Passed');
        endif;
        
    }      
       
    //dev:priyanka varanasi
    //desc: to delete hotel
    //date:18/12/2015
    
    public function productDelete() {
        if (func_num_args() > 0):
            $productid = func_get_arg(0);
     
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('product_id = ?' => $productid));
                $delete = $db->delete('products', $where);
                if($delete){
                    return $delete;
                }
            } catch (Exception $e) {
                throw new Exception($e);
            }
            
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }  
       
    
        /*
   * Dev : Priyanka Varanasi
   * Date: 22/12/2015
   * Desc: TO select product by product id
   */
    public function getProductByProductId(){
         if(func_num_args()>0){
             $productid = func_get_arg(0);
           try {

                $select = $this->select()
                        ->from($this)
                        ->where('product_id=?',$productid);
                 $result = $this->getAdapter()->fetchRow($select);
               
            if ($result) {
                return $result;
            }else{
                
                return null;
            } 
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }

      
    }
    }
     
        /*
   * Dev : Priyanka Varanasi
   * Date: 22/12/2015
   * Desc: TO update product by product id
   */
    
    public function updateProductDetails() {
        
        if(func_num_args()>0){
            $product_id = func_get_arg(0);
            $data = func_get_arg(1);
            
                try {
                $result = $this->update($data, 'product_id =' . $product_id);
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
    
     
        /*
   * Dev : Priyanka Varanasi
   * Date: 22/12/2015
   * Desc: TO add product details 
   */
    public function AddProductDetails() {
        
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
    
       
           /*
   * Dev : Priyanka Varanasi
   * Date: 22/12/2015
   * Desc: TO select product by product id
   */
    public function getProductBycategoryID(){
         if(func_num_args()>0){
             $categoryid = func_get_arg(0);
            
           try {

                $select = $this->select()
                         ->from($this)
                        ->where('category_id=?',$categoryid);
              
                 $result = $this->getAdapter()->fetchAll($select);
             
            if ($result) {
                return $result;
            }else{
                
                return null;
            } 
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }

      
    }
    }
    
    public function getRestaurentsMenuDetails(){
           if(func_num_args()>0){
             $hotel_id = func_get_arg(0);
            
           try {

                $select = $this->select()
                       ->setIntegrityCheck(false)
                      ->from(array('pd' => 'products'),array('category_id'))
                      ->joinLeft(array('cat' => 'menu_category'), 'pd.category_id=cat.category_id',array('cat.cat_name'))
                        //->joinLeft(array('hd' => 'hotel_details'), 'pd.hotel_id=hd.hotel_id',array('hd.hotel_name'))
                       ->where('pd.hotel_id=?',$hotel_id)
                      ->distinct('pd.category_id');
                 $result = $this->getAdapter()->fetchAll($select);
               
            if ($result) {
                $i=0;
                
                foreach ($result as $value) {
                   
                 $select = $this->select()
                       ->setIntegrityCheck(false)
                      ->from(array('pd' => 'products'))
                      ->where('pd.category_id=?',$value['category_id']);
                 $response= $this->getAdapter()->fetchAll($select);
                 $result[$i]['cat_products'] = $response;
                 $i++;
                }
           if($result){
               return $result ;
           }
            }else{
                
                return null;
            } 
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }

      
    }  
        
        
        
    }
    }

?>