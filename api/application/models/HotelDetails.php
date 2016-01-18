<?php
  /*
   * Dev : Priyanka Varanasi
   * Date: 10/10/2015
   * Desc: Products Modal
   */


class Application_Model_HotelDetails extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'hotel_details';

    public static function getInstance() {
        if (!is_object(self::$_instance))
            self::$_instance = new Application_Model_HotelDetails();
        return self::$_instance;
    }
     /*
   * Dev : Priyanka Varanasi
   * Date: 10/10/2015
   * Desc: TO select all products in db
   */
    public function selectAllHotels(){
         
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
      //dev:priyanka varanasi
    //desc: to fetch agent hotels
    //date:18/12/2015
    public function getHoteldetails() {
     if(func_num_args()>0){
         $agent_id = func_get_arg(0);
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('hd' => 'hotel_details'),array('hd.agent_id','hd.owner_fname','hd.owner_lname','hd.city','hd.city','hd.state','hd.country','hd.address','hd.primary_phone','hd.secondary_phone','hd.hotel_name','hd.hotel_image','hd.open_time','hd.closing_time','hd.hotel_status','hd.notice','hd.id'))
                    ->joinLeft(array('ag' => 'agents'), 'hd.agent_id= ag.agent_id')
                    ->where('hd.agent_id=?',$agent_id);
           
            $result = $this->getAdapter()->fetchAll($select);
 
        if ($result) {
            return $result;
        }else{
            
            return null;
        }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

    }
 }
        
      //dev:priyanka varanasi
    //desc:activate and deactive of hotel
    //date:18/12/2015
    public function getstatusChangeOfHotel(){
          if (func_num_args() > 0):
            $hotelid = func_get_arg(0);
            try {
                $data = array('hotel_status' => new Zend_DB_Expr('IF(hotel_status=1, 0, 1)'));
                $result = $this->update($data, 'id = "' . $hotelid . '"');
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
    
    public function hotelDelete() {
        if (func_num_args() > 0):
            $hotelid = func_get_arg(0);
     
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('id = ?' => $hotelid));
                $delete = $db->delete('hotel_details', $where);
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
      //dev:priyanka varanasi
    //desc:to fetch hotel details by hotel id
    //date:18/12/2015
    public function getHoteldetailsByHotelId(){
           if(func_num_args()>0){
         $hotel_id = func_get_arg(0);
        try {
            $select = $this->select()
                      ->where('id=?',$hotel_id);
             $result = $this->getAdapter()->fetchRow($select);
 
        if ($result) {
            return $result;
        }else{
            
            return null;
        }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

    }  
        
        
    }
    
      //dev:priyanka varanasi
    //desc: to update edited hotel details based on hotel id
    //date:18/12/2015
    public function updateHotelDetails(){
        
        if(func_num_args()>0){
            $hotelid = func_get_arg(0);
            $data = func_get_arg(1);
            try {
                $result = $this->update($data, 'id =' . $hotelid);
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
     * Dev: priyanka Varanasi
     * Desc: to insert hotel details 
     * Date : 21/12/2015
     * 
     */
    
       public function insertHotelDetails() {

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
     * Dev: Priyanka Varanasi
     * Date : 21/12/2015
     * Desc : TO get all menu details from all hotels
     */
    
    public function  GetHotelsAndMenu(){
     
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('hd' => 'hotel_details'))
                    ->join(array('pr' => 'products'),'hd.id= pr.hotel_id')
                     ->joinLeft(array('cat' => 'menu_category'), 'pr.category_id= cat.category_id');
               $result = $this->getAdapter()->fetchAll($select);
 
        if ($result) {
            return $result;
        }else{
            return null;
        }
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

    }   
      public function  getRestaurentsByLocationid(){
    if (func_num_args() > 0) {
            $locationid = func_get_arg(0);
            $cityid = func_get_arg(1);
           
       try {
                $select = $this->select()
                      ->setIntegrityCheck(false)
                      ->from(array('hd' => 'hotel_details'))
                      ->join(array('l' => 'location'), 'hd.hotel_location=l.location_id')
                      ->where('hd.hotel_location=?',$locationid)
                      ->where('l.parent_id=?',$cityid)
                      ->where('l.location_type=?',3);

                  $result = $this->getAdapter()->fetchAll($select);
              
            if ($result) {
                return $result;
            }  
            }  catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }else{
            
        }
}
     public function getRestaurentsBycityId(){
       if (func_num_args() > 0) {
             $cityid = func_get_arg(1);
       try {
                $select = $this->select()
                      ->setIntegrityCheck(false)
                      ->from(array('hd' => 'hotel_details'))
                      ->join(array('l' => 'location'), 'hd.hotel_location=l.location_id')
                      ->where('hd.hotel_location=?',$locationid)
                      ->where('l.location_type=?',2);

                  $result = $this->getAdapter()->fetchAll($select);
              
            if ($result) {
                return $result;
            }  
            }  catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }else{
            
        }    
         
     }
     
     
           
    public function getcategoriesByHotelId(){
        
     if(func_num_args()>0){
         $hotel_id = func_get_arg(0);
      
         try {

               $select = $this->select()
                    ->from(array('hd' => 'hotel_details'),array('hd.id'))
                    ->setIntegrityCheck(false)
                    ->joinLeft(array('p' => 'products'),'hd.id=p.hotel_id',array('p.category_id'))
                    ->joinLeft(array('cat' => 'menu_category'),'p.category_id=cat.category_id')
                    ->where('hd.id=?',$hotel_id)
                     ->distinct('p.category_id');
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
         /*
   * Dev : Priyanka Varanasi
   * Date: 16/1/2016
   * Desc: TO select all hotels 
   */
    public function selectAllHotelsLocations(){
         
            try {
            $select = $this->select()
                    ->from(array('hd' => 'hotel_details'))
                    ->setIntegrityCheck(false)
                    ->joinLeft(array('loc' => 'location'), 'hd.hotel_location= loc.location_id');
                   //->joinLeft(array('ag' => 'agents'), 'hd.agent_id= ag.agent_id');
                 $result = $this->getAdapter()->fetchAll($select);
             if ($result){
                 $i=0;
                 foreach ($result as $value) {
                     if($value['location_type']==0){
                        $result[$i]['hotel_country'] = $value['name'];
                        $result[$i]['hotel_state'] = '';
                        $result[$i]['hotel_city'] = '';
                        $result[$i]['hotel_location'] ='';
                        
                    }else if($value['location_type']==1){
                    $select = $this->select()
                            ->setIntegrityCheck(false)
                       ->from(array('loc' => 'location'))
                       ->where('loc.location_id=?',$value['parent_id']);
                 $result1 = $this->getAdapter()->fetchRow($select);
                 $result[$i]['hotel_state'] = $value['name'];
                 $result[$i]['hotel_country'] = $result1['name'];
                 $result[$i]['hotel_city'] = '';
                 $result[$i]['hotel_location'] ='';
                    }else if($value['location_type']==2){
                    $select = $this->select()
                            ->setIntegrityCheck(false)
                       ->from(array('loc' => 'location'))
                       ->where('loc.location_id=?',$value['parent_id']);
                 $result2 = $this->getAdapter()->fetchRow($select);
                 $result[$i]['hotel_city'] = $value['name'];
                 $result[$i]['hotel_state'] = $result2['name'];
                    if($result2['parent_id']){
                     $select = $this->select()
                             ->setIntegrityCheck(false)
                       ->from(array('loc' => 'location'))
                       ->where('loc.location_id=?',$result2['parent_id']);
                 $result3 = $this->getAdapter()->fetchRow($select);
                 $result[$i]['hotel_country'] = $result3['name'];
                 $result[$i]['hotel_location'] ='';
                      }
                     }else if($value['location_type']==3){
                        $select = $this->select()
                                ->setIntegrityCheck(false)
                       ->from(array('loc' => 'location'))
                       ->where('loc.location_id=?',$value['parent_id']);
                 $result4 = $this->getAdapter()->fetchRow($select);
                  $result[$i]['hotel_location'] = $value['name'];
                 $result[$i]['hotel_city'] = $result4['name'];
                    if($result4['parent_id']){
                     $select = $this->select()
                             ->setIntegrityCheck(false)
                       ->from(array('loc' => 'location'))
                       ->where('loc.location_id=?',$result4['parent_id']);
                 $result5 = $this->getAdapter()->fetchRow($select);
                   $result[$i]['hotel_state'] = $result5['name']; 
                   if($result5['parent_id']){
                      $select = $this->select()
                              ->setIntegrityCheck(false)
                       ->from(array('loc' => 'location'))
                       ->where('loc.location_id=?',$result5['parent_id']);
                 $result6 = $this->getAdapter()->fetchRow($select);
                   $result[$i]['hotel_country'] = $result6['name'];  
                   }
                      }   
                     }else{
                         
                     }
                $i++; 
                 }
                if($result){
                    
                   return $result;   
                }
                
            }else{
                return null;
            } 
            } catch (Exception $e) {
                throw new Exception('Unable to access data :' . $e);
            }

      
    }
    
}
?>