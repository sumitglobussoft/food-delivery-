<?php

class Engine_Vault_Acl extends Zend_Acl {

    public function __construct() {
        // Add a new role called "guest"
        $this->addRole(new Zend_Acl_Role('guest'));
        // Add a role called user, which inherits from guest
        $this->addRole(new Zend_Acl_Role('user'), 'guest');
        // Add a role called agent, which inherits from user
       // Add a role called admin, which inherits from user
        $this->addRole(new Zend_Acl_Role('admin'), 'user');
        
        
        
     
        //========================Web module=======================
        $this->add(new Zend_Acl_Resource('web'))
                ->add(new Zend_Acl_Resource('web::home'), 'web')
                ->add(new Zend_Acl_Resource('web::error'), 'web')
                ->add(new Zend_Acl_Resource('web::error::error'), 'web::error')
                ->add(new Zend_Acl_Resource('web::home::home'), 'web::home')
                ->add(new Zend_Acl_Resource('web::home::index'), 'web::home')
                 ->add(new Zend_Acl_Resource('web::home::home-ajax-handler'), 'web::home')
                 ->add(new Zend_Acl_Resource('web::home::restaurents-list'), 'web::home')
                ->add(new Zend_Acl_Resource('web::home::restaurant-details'), 'web::home');
        
        
        
      
        $this->allow('guest', 'web::home::home')
                ->allow('guest', 'web::error::error')
                ->allow('guest', 'web::home::index')
         ->allow('guest', 'web::home::home-ajax-handler')
         ->allow('guest', 'web::home::restaurents-list')
                ->allow('guest', 'web::home::restaurant-details');
        
        
  $this->add(new Zend_Acl_Resource('web::authentication'), 'web')
        ->add(new Zend_Acl_Resource('web::authentication::signup'), 'web::authentication')
          ->add(new Zend_Acl_Resource('web::authentication::ziingo-login'), 'web::authentication')
         ->add(new Zend_Acl_Resource('web::authentication::welcome'), 'web::authentication')
        ->add(new Zend_Acl_Resource('web::authentication::logout'), 'web::authentication')
          ->add(new Zend_Acl_Resource('web::authentication::ajax-handler-auth'), 'web::authentication');
  
  $this->allow('guest', 'web::authentication::signup')
       ->allow('user', 'web::authentication::welcome')
          ->allow('guest', 'web::authentication::logout')
           ->allow('guest', 'web::authentication::ziingo-login')
          ->allow('guest', 'web::authentication::ajax-handler-auth');
  
  
  //====================end Web module=======================  
  
  
//====================end web module=======================        
        //========================Agent module=======================
        $this->add(new Zend_Acl_Resource('agent'))
                ->add(new Zend_Acl_Resource('agent::authentication'), 'agent')
                ->add(new Zend_Acl_Resource('agent::order'), 'agent')
                ->add(new Zend_Acl_Resource('agent::payment'), 'agent')
                ->add(new Zend_Acl_Resource('agent::product'), 'agent')
                ->add(new Zend_Acl_Resource('agent::settings'), 'agent')
                ->add(new Zend_Acl_Resource('agent::static'), 'agent')
                ->add(new Zend_Acl_Resource('agent::transaction'), 'agent')
                ->add(new Zend_Acl_Resource('agent::user'), 'agent')
                ->add(new Zend_Acl_Resource('agent::authentication::index'), 'agent::authentication')
                ->add(new Zend_Acl_Resource('agent::authentication::dashboard'), 'agent::authentication')
                ->add(new Zend_Acl_Resource('agent::authentication::logout'), 'agent::authentication');
        
        
       

        $this->allow('guest', 'agent::authentication::index')
                ->allow('user', 'agent::authentication::dashboard')
                ->allow('guest', 'agent::authentication::logout');

        
           $this->add(new Zend_Acl_Resource('agent::settings::agent-hotel-details'), 'agent::settings')
                 ->add(new Zend_Acl_Resource('agent::settings::edit-hotel-details'), 'agent::settings')
                 ->add(new Zend_Acl_Resource('agent::settings::add-hotel-details'), 'agent::settings');
           
                   $this->allow('user', 'agent::settings::agent-hotel-details')
                       ->allow('user', 'agent::settings::edit-hotel-details')
                   ->allow('user', 'agent::settings::add-hotel-details');
        
                   
                   
              $this->add(new Zend_Acl_Resource('agent::order::order-ajax-handler'), 'agent::order')
                     ->add(new Zend_Acl_Resource('agent::order::restuarent-orders'), 'agent::order');
              
                    $this->allow('user', 'agent::order::order-ajax-handler')
                            ->allow('user', 'agent::order::restuarent-orders');
                    
                    
                 $this->add(new Zend_Acl_Resource('agent::transaction::agent-payments'), 'agent::order');
                    
              
                    $this->allow('user', 'agent::transaction::agent-payments');
                                
              
                           
                   
              $this->add(new Zend_Acl_Resource('agent::product::product-details'), 'agent::product')
                      ->add(new Zend_Acl_Resource('agent::product::edit-product-details'), 'agent::product')
                 ->add(new Zend_Acl_Resource('agent::product::add-product-details'), 'agent::product');
              
                    $this->allow('user', 'agent::product::product-details')
                           ->allow('user', 'agent::product::add-product-details')
                            ->allow('user', 'agent::product::edit-product-details');
        
//====================end Agent module=======================  

        //========================Admin module=======================
            $this->add(new Zend_Acl_Resource('admin'))
                ->add(new Zend_Acl_Resource('admin::admin'), 'admin')
                ->add(new Zend_Acl_Resource('admin::error'), 'admin')
                ->add(new Zend_Acl_Resource('admin::static'), 'admin')
                ->add(new Zend_Acl_Resource('admin::user'), 'admin')
                ->add(new Zend_Acl_Resource('admin::order'), 'admin')
                ->add(new Zend_Acl_Resource('admin::transaction'), 'admin')
                ->add(new Zend_Acl_Resource('admin::product'), 'admin')
                ->add(new Zend_Acl_Resource('admin::agent'), 'admin')
                    ->add(new Zend_Acl_Resource('admin::settings'), 'admin')
                
                ->add(new Zend_Acl_Resource('admin::error::error'), 'admin::error')
                ->add(new Zend_Acl_Resource('admin::admin::index'), 'admin::admin')
                ->add(new Zend_Acl_Resource('admin::admin::dashboard'), 'admin::admin')
                ->add(new Zend_Acl_Resource('admin::admin::logout'), 'admin::admin')
                ->add(new Zend_Acl_Resource('admin::user::userdetails'), 'admin::static')
                ->add(new Zend_Acl_Resource('admin::user::all-user-details'), 'admin::user')
                ->add(new Zend_Acl_Resource('admin::user::add-user-details'), 'admin::user')
                ->add(new Zend_Acl_Resource('admin::user::user-ajax-handler'), 'admin::user')
                    
                ->add(new Zend_Acl_Resource('admin::transaction::all-transaction'), 'admin::transaction')
                ->add(new Zend_Acl_Resource('admin::order::orderdetails'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::order::all-order-details'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::static::csv-exportcsv'), 'admin::static')
                ->add(new Zend_Acl_Resource('admin::static::set-status-active'), 'admin::static')
                ->add(new Zend_Acl_Resource('admin::product::product-details'), 'admin::product')
                ->add(new Zend_Acl_Resource('admin::product::all-product-details'), 'admin::product')
                ->add(new Zend_Acl_Resource('admin::order::delivery-guy-details'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::order::all-delivery-guy-details'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::order::add-delivery-guy-details'), 'admin::order')
            
            
              ->add(new Zend_Acl_Resource('admin::agent::agent-details'), 'admin::agent')
              ->add(new Zend_Acl_Resource('admin::agent::edit-agent-details'), 'admin::agent')
              ->add(new Zend_Acl_Resource('admin::agent::add-agents'), 'admin::agent')
            
            
             ->add(new Zend_Acl_Resource('admin::settings::add-country'), 'admin::settings')
            ->add(new Zend_Acl_Resource('admin::settings::countries-details'), 'admin::settings')
                    
     ->add(new Zend_Acl_Resource('admin::settings::add-city'), 'admin::settings')
            ->add(new Zend_Acl_Resource('admin::settings::city-details'), 'admin::settings')
                    
     ->add(new Zend_Acl_Resource('admin::settings::add-state'), 'admin::settings')
            ->add(new Zend_Acl_Resource('admin::settings::states-details'), 'admin::settings')
                    
          ->add(new Zend_Acl_Resource('admin::settings::add-location'), 'admin::settings')
            ->add(new Zend_Acl_Resource('admin::settings::location-details'), 'admin::settings');
          
        $this->allow('guest', 'admin::admin::index')
                ->allow('guest', 'admin::error::error')
                ->allow('admin', 'admin::admin::dashboard')
                ->allow('admin', 'admin::user::userdetails')
                ->allow('guest', 'admin::admin::logout')
                ->allow('admin', 'admin::user::all-user-details')
                 ->allow('admin', 'admin::user::user-ajax-handler')
                ->allow('admin', 'admin::user::add-user-details')
                ->allow('admin', 'admin::transaction::all-transaction')
                ->allow('admin', 'admin::order::orderdetails')
                ->allow('admin', 'admin::order::all-order-details')
                ->allow('admin', 'admin::static::csv-exportcsv')
                ->allow('admin', 'admin::static::set-status-active')
                ->allow('admin', 'admin::product::product-details')
                ->allow('admin', 'admin::product::all-product-details')
                ->allow('admin', 'admin::order::delivery-guy-details')
                ->allow('admin', 'admin::order::all-delivery-guy-details')
                ->allow('admin', 'admin::order::add-delivery-guy-details')
        ->allow('admin', 'admin::agent::agent-details')
        ->allow('admin', 'admin::agent::edit-agent-details')
        ->allow('admin', 'admin::agent::add-agents')
                
                
         ->allow('admin', 'admin::settings::add-country')
         ->allow('admin', 'admin::settings::countries-details')
                
        ->allow('admin', 'admin::settings::add-city')
        ->allow('admin', 'admin::settings::city-details')
                
        ->allow('admin', 'admin::settings::add-state')
        ->allow('admin', 'admin::settings::states-details')
                
        ->allow('admin', 'admin::settings::add-location')
        ->allow('admin', 'admin::settings::location-details');
      
//====================end Agent module=======================  
    }

}

?>