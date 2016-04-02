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
                ->add(new Zend_Acl_Resource('web::home::home'), 'web::home')
                ->add(new Zend_Acl_Resource('web::home::index'), 'web::home')
                ->add(new Zend_Acl_Resource('web::home::home-ajax-handler'), 'web::home')
                ->add(new Zend_Acl_Resource('web::home::restaurents-list'), 'web::home')
                ->add(new Zend_Acl_Resource('web::home::restaurant-details'), 'web::home');




        $this->allow('guest', 'web::home::home')
                ->allow('guest', 'web::home::index')
                ->allow('guest', 'web::home::home-ajax-handler')
                ->allow('guest', 'web::home::restaurents-list')
                ->allow('guest', 'web::home::restaurant-details');

        $this->add(new Zend_Acl_Resource('web::error'), 'web')
                ->add(new Zend_Acl_Resource('web::error::error'), 'web::error');

        $this->allow('guest', 'web::error::error');



        $this->add(new Zend_Acl_Resource('web::authentication'), 'web')
                ->add(new Zend_Acl_Resource('web::authentication::signup'), 'web::authentication')
                ->add(new Zend_Acl_Resource('web::authentication::ziingo-login'), 'web::authentication')
                ->add(new Zend_Acl_Resource('web::authentication::welcome'), 'web::authentication')
                ->add(new Zend_Acl_Resource('web::authentication::logout'), 'web::authentication')
                ->add(new Zend_Acl_Resource('web::authentication::ajax-handler-auth'), 'web::authentication')
                ->add(new Zend_Acl_Resource('web::authentication::authentication-ajax-handler'), 'web::authentication')
                ->add(new Zend_Acl_Resource('web::authentication::activate-account'), 'web::authentication');

        $this->allow('guest', 'web::authentication::signup')
                ->allow('user', 'web::authentication::welcome')
                ->allow('guest', 'web::authentication::logout')
                ->allow('guest', 'web::authentication::ziingo-login')
                ->allow('guest', 'web::authentication::ajax-handler-auth')
                ->allow('guest', 'web::authentication::authentication-ajax-handler')
                ->allow('guest', 'web::authentication::activate-account');

        $this->add(new Zend_Acl_Resource('web::order'), 'web')
                ->add(new Zend_Acl_Resource('web::order::order-confirmation'), 'web::home')
                ->add(new Zend_Acl_Resource('web::order::order-ajax-handler'), 'web::home');



        $this->allow('user', 'web::order::order-confirmation')
                ->allow('user', 'web::order::order-ajax-handler');


        $this->add(new Zend_Acl_Resource('web::settings'), 'web')
                ->add(new Zend_Acl_Resource('web::settings::cart'), 'web::home')
                ->allow('guest', 'web::settings::cart');


        //====================end Web module=======================  
        //========================Agent module=======================


        $this->add(new Zend_Acl_Resource('agent'))
                ->add(new Zend_Acl_Resource('agent::authentication'), 'agent')
                ->add(new Zend_Acl_Resource('agent::authentication::index'), 'agent::authentication')
                ->add(new Zend_Acl_Resource('agent::authentication::dashboard'), 'agent::authentication')
                ->add(new Zend_Acl_Resource('agent::authentication::logout'), 'agent::authentication');

        $this->allow('guest', 'agent::authentication::index')
                ->allow('user', 'agent::authentication::dashboard')
                ->allow('guest', 'agent::authentication::logout');

        $this->add(new Zend_Acl_Resource('agent::settings'), 'agent')
                ->add(new Zend_Acl_Resource('agent::settings::agent-hotel-details'), 'agent::settings')
                ->add(new Zend_Acl_Resource('agent::settings::edit-hotel-details'), 'agent::settings')
                ->add(new Zend_Acl_Resource('agent::settings::add-hotel-details'), 'agent::settings');

        $this->allow('user', 'agent::settings::agent-hotel-details')
                ->allow('user', 'agent::settings::edit-hotel-details')
                ->allow('user', 'agent::settings::add-hotel-details');


        $this->add(new Zend_Acl_Resource('agent::order'), 'agent')
                ->add(new Zend_Acl_Resource('agent::order::order-ajax-handler'), 'agent::order')
                ->add(new Zend_Acl_Resource('agent::order::restuarent-orders'), 'agent::order')
                ->add(new Zend_Acl_Resource('agent::order::edit-restuarent-orders'), 'agent::order');

        $this->allow('user', 'agent::order::order-ajax-handler')
                ->allow('user', 'agent::order::restuarent-orders')
                ->allow('user', 'agent::order::edit-restuarent-orders');

        $this->add(new Zend_Acl_Resource('agent::product'), 'agent')
                ->add(new Zend_Acl_Resource('agent::product::product-details'), 'agent::product')
                ->add(new Zend_Acl_Resource('agent::product::edit-product-details'), 'agent::product')
                ->add(new Zend_Acl_Resource('agent::product::add-product-details'), 'agent::product');

        $this->allow('user', 'agent::product::product-details')
                ->allow('user', 'agent::product::add-product-details')
                ->allow('user', 'agent::product::edit-product-details');

//                   
//                   
//====================end Agent module=======================  
        //========================Admin module=======================
        $this->add(new Zend_Acl_Resource('admin'))
                ->add(new Zend_Acl_Resource('admin::admin'), 'admin')
                ->add(new Zend_Acl_Resource('admin::admin::index'), 'admin::admin')
                ->add(new Zend_Acl_Resource('admin::admin::dashboard'), 'admin::admin')
                ->add(new Zend_Acl_Resource('admin::admin::logout'), 'admin::admin')

                // admin error panel///
                ->add(new Zend_Acl_Resource('admin::error'), 'admin')
                ->add(new Zend_Acl_Resource('admin::error::error'), 'admin::error')

                // admin order panel///
                ->add(new Zend_Acl_Resource('admin::order'), 'admin')
                ->add(new Zend_Acl_Resource('admin::order::order-details'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::order::order-product-details'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::order::edit-order-details'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::order::refund-request'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::order::order-listing-ajax-handler'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::order::order-ajax-handler'), 'admin::order')
                ->add(new Zend_Acl_Resource('admin::order::view-order'), 'admin::order')

                // admin delivery  panel///
                ->add(new Zend_Acl_Resource('admin::static'), 'admin')
                ->add(new Zend_Acl_Resource('admin::static::delivery-guys-details'), 'admin::static')
                ->add(new Zend_Acl_Resource('admin::static::edit-deliveryguy-details'), 'admin::static')
                ->add(new Zend_Acl_Resource('admin::static::add-delivery-guy'), 'admin::static')
                ->add(new Zend_Acl_Resource('admin::static::delivery-guy-orders'), 'admin::static')
//                
//                
//                
//               // admin agent panel/// 
                ->add(new Zend_Acl_Resource('admin::agent'), 'admin')
                ->add(new Zend_Acl_Resource('admin::agent::agent-details'), 'admin::agent')
                ->add(new Zend_Acl_Resource('admin::agent::add-agents'), 'admin::agent')
                ->add(new Zend_Acl_Resource('admin::agent::edit-agent-details'), 'admin::agent')

                // admin users panel///
                ->add(new Zend_Acl_Resource('admin::user'), 'admin')
                ->add(new Zend_Acl_Resource('admin::user::userdetails'), 'admin::user')
                ->add(new Zend_Acl_Resource('admin::user::edit-user-details'), 'admin::user')
                ->add(new Zend_Acl_Resource('admin::user::add-user-details'), 'admin::user')
                ->add(new Zend_Acl_Resource('admin::user::user-ajax-handler'), 'admin::user')

                // admin products panel///
                ->add(new Zend_Acl_Resource('admin::product'), 'admin')
                ->add(new Zend_Acl_Resource('admin::product::product-details'), 'admin::product')
                ->add(new Zend_Acl_Resource('admin::product::edit-product-details'), 'admin::product')
                ->add(new Zend_Acl_Resource('admin::product::add-product-details'), 'admin::product')
                ->add(new Zend_Acl_Resource('admin::product::product-ajax-handler'), 'admin::product')

                // admin settings panel///
                ->add(new Zend_Acl_Resource('admin::settings'), 'admin')
                ->add(new Zend_Acl_Resource('admin::settings::countries-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::city-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::states-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::location-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::locationsettings-handler'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::edit-location'), 'admin::settings')


                // admin transactions panel///
                ->add(new Zend_Acl_Resource('admin::transaction'), 'admin')
                ->add(new Zend_Acl_Resource('admin::transaction::admin-user-transactions'), 'admin::transaction')
                ->add(new Zend_Acl_Resource('admin::transaction::admin-agent-transactions'), 'admin::transaction')
                // admin notification panel///added by sowmya 1/4/2016
                ->add(new Zend_Acl_Resource('admin::notification'), 'admin')
                ->add(new Zend_Acl_Resource('admin::notification::notification-log'), 'admin::notification')
                ->add(new Zend_Acl_Resource('admin::notification::send-user-notification'), 'admin::notification')
                ->add(new Zend_Acl_Resource('admin::notification::send-agent-notification'), 'admin::notification')
                ->add(new Zend_Acl_Resource('admin::notification::notification-ajax-handler'), 'admin::notification')
                ->add(new Zend_Acl_Resource('admin::notification::notification'), 'admin::notification');



//                
//                
        // admin panel landing page///
        $this->allow('guest', 'admin::admin::index')
                ->allow('admin', 'admin::admin::dashboard')
                ->allow('guest', 'admin::admin::logout')

                // // admin agent panel/// ///  
                ->allow('guest', 'admin::error::error')
                ->allow('admin', 'admin::agent::agent-details')
                ->allow('admin', 'admin::agent::add-agents')
                ->allow('admin', 'admin::agent::edit-agent-details')

                // admin users panel///
                ->allow('admin', 'admin::user::userdetails')
                ->allow('admin', 'admin::user::edit-user-details')
                ->allow('admin', 'admin::user::user-ajax-handler')
                ->allow('admin', 'admin::user::add-user-details')

                // admin products panel///
                ->allow('admin', 'admin::product::product-ajax-handler')
                ->allow('admin', 'admin::product::product-details')
                ->allow('admin', 'admin::product::edit-product-details')
                ->allow('admin', 'admin::product::add-product-details')

                // admin settings panel///
                ->allow('admin', 'admin::settings::countries-details')
                ->allow('admin', 'admin::settings::city-details')
                ->allow('admin', 'admin::settings::states-details')
                ->allow('admin', 'admin::settings::location-details')
                ->allow('admin', 'admin::settings::locationsettings-handler')
                ->allow('admin', 'admin::settings::edit-location')

                // admin transaction panel///
                ->allow('admin', 'admin::transaction::admin-user-transactions')
                ->allow('admin', 'admin::transaction::admin-agent-transactions')


                // admin order panel/// 
                ->allow('admin', 'admin::order::order-details')
                ->allow('admin', 'admin::order::edit-order-details')
                ->allow('admin', 'admin::order::order-product-details')
                ->allow('admin', 'admin::order::refund-request')
                ->allow('admin', 'admin::order::order-ajax-handler')
                ->allow('admin', 'admin::order::order-listing-ajax-handler')
                ->allow('admin', 'admin::order::view-order')


                // admin delivery panel///
                ->allow('admin', 'admin::static::delivery-guys-details')
                ->allow('admin', 'admin::static::edit-deliveryguy-details')
                ->allow('admin', 'admin::static::add-delivery-guy')
                ->allow('admin', 'admin::static::delivery-guy-orders')

                // admin notification panel///added by sowmya 1/4/2016
                ->allow('admin', 'admin::notification::notification-log')
                ->allow('admin', 'admin::notification::send-user-notification')
                ->allow('admin', 'admin::notification::send-agent-notification')
                ->allow('admin', 'admin::notification::notification-ajax-handler')
                ->allow('admin', 'admin::notification::notification');

//====================end Admin module=======================  
    }

}

?>