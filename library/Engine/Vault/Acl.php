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
        $this->addRole(new Zend_Acl_Role('agent'), 'user');




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
                ->add(new Zend_Acl_Resource('web::order::order-confirmation'), 'web::order')
                ->add(new Zend_Acl_Resource('web::order::order-ajax-handler'), 'web::order');

        $this->allow('user', 'web::order::order-confirmation')
                ->allow('user', 'web::order::order-ajax-handler');


        $this->add(new Zend_Acl_Resource('web::settings'), 'web')
                ->add(new Zend_Acl_Resource('web::settings::cart'), 'web::home')
                ->allow('guest', 'web::settings::cart');



        $this->add(new Zend_Acl_Resource('web::profile'), 'web')
                ->add(new Zend_Acl_Resource('web::profile::profile'), 'web::profile');

        $this->allow('user', 'web::profile::profile');


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
                ->add(new Zend_Acl_Resource('agent::settings::add-hotel-details'), 'agent::settings')
                ->add(new Zend_Acl_Resource('agent::settings::view-hotel-details'), 'agent::settings'); // added by sowmya 11/4/2016

        $this->allow('user', 'agent::settings::agent-hotel-details')
                ->allow('user', 'agent::settings::edit-hotel-details')
                ->allow('user', 'agent::settings::add-hotel-details')
                ->allow('user', 'agent::settings::view-hotel-details'); // added by sowmya 11/4/2016

        $this->add(new Zend_Acl_Resource('agent::order'), 'agent')
                ->add(new Zend_Acl_Resource('agent::order::order-ajax-handler'), 'agent::order')
                ->add(new Zend_Acl_Resource('agent::order::restuarent-orders'), 'agent::order')
                ->add(new Zend_Acl_Resource('agent::order::edit-restuarent-orders'), 'agent::order')
                ->add(new Zend_Acl_Resource('agent::order::view-restuarent-orders'), 'agent::order'); // added by sowmya 14/4/2016

        $this->allow('user', 'agent::order::order-ajax-handler')
                ->allow('user', 'agent::order::restuarent-orders')
                ->allow('user', 'agent::order::edit-restuarent-orders')
                ->allow('user', 'agent::order::view-restuarent-orders'); // added by sowmya 14/4/2016

        $this->add(new Zend_Acl_Resource('agent::product'), 'agent')
                ->add(new Zend_Acl_Resource('agent::product::product-details'), 'agent::product')
                ->add(new Zend_Acl_Resource('agent::product::edit-product-details'), 'agent::product')
                ->add(new Zend_Acl_Resource('agent::product::add-product-details'), 'agent::product')
                ->add(new Zend_Acl_Resource('agent::product::view-product-details'), 'agent::product'); // added by sowmya 11/4/2016

        $this->allow('user', 'agent::product::product-details')
                ->allow('user', 'agent::product::add-product-details')
                ->allow('user', 'agent::product::edit-product-details')
                ->allow('user', 'agent::product::view-product-details'); // added by sowmya 11/4/2016
        // added by sowmya 4/4/2016
        $this->add(new Zend_Acl_Resource('agent::transaction'), 'agent')
                ->add(new Zend_Acl_Resource('agent::transaction::agent-payments'), 'agent::transaction');

        $this->allow('user', 'agent::transaction::agent-payments');

// added by sowmya 25/4/2016 grocery module
        $this->add(new Zend_Acl_Resource('agent::grocery'), 'agent')
                ->add(new Zend_Acl_Resource('agent::grocery::grocery-details'), 'agent::grocery')
                ->add(new Zend_Acl_Resource('agent::grocery::edit-grocery-details'), 'agent::grocery')
                ->add(new Zend_Acl_Resource('agent::grocery::add-grocery-details'), 'agent::grocery')
                ->add(new Zend_Acl_Resource('agent::grocery::view-grocery-details'), 'agent::grocery'); // added by sowmya 11/4/2016

        $this->allow('user', 'agent::grocery::grocery-details')
                ->allow('user', 'agent::grocery::edit-grocery-details')
                ->allow('user', 'agent::grocery::add-grocery-details')
                ->allow('user', 'agent::grocery::view-grocery-details'); // added by sowmya 25/4/2016
        // added by sowmya 26/4/2016 review module
        $this->add(new Zend_Acl_Resource('agent::reviews'), 'agent')
                ->add(new Zend_Acl_Resource('agent::reviews::grocery-reviews'), 'agent::reviews')
                ->add(new Zend_Acl_Resource('agent::reviews::hotel-reviews'), 'agent::reviews'); // added by sowmya 26/4/2016

        $this->allow('user', 'agent::reviews::grocery-reviews')
                ->allow('user', 'agent::reviews::hotel-reviews'); // added by sowmya 26/4/2016
        //
                //      // added by sowmya 26/4/2016 profile module
        $this->add(new Zend_Acl_Resource('agent::profile'), 'agent')
                ->add(new Zend_Acl_Resource('agent::profile::edit-profile'), 'agent::profile')
                ->add(new Zend_Acl_Resource('agent::profile::change-password'), 'agent::profile')
                ->add(new Zend_Acl_Resource('agent::profile::country'), 'agent::profile')// added by sowmya 29/4/2016
                ->add(new Zend_Acl_Resource('agent::profile::state'), 'agent::profile')
                ->add(new Zend_Acl_Resource('agent::profile::city'), 'agent::profile')
                ->add(new Zend_Acl_Resource('agent::profile::location'), 'agent::profile')
                ->add(new Zend_Acl_Resource('agent::profile::hotel-cuisines'), 'agent::profile')
                ->add(new Zend_Acl_Resource('agent::profile::hotel-category'), 'agent::profile')
                ->add(new Zend_Acl_Resource('agent::profile::grocery-category'), 'agent::profile')
                ->add(new Zend_Acl_Resource('agent::profile::edit-grocery-category'), 'agent::profile')
                ->add(new Zend_Acl_Resource('agent::profile::edit-location'), 'agent::profile'); //upto here added by sowmya 26/4/2016

        $this->allow('user', 'agent::profile::edit-profile')
                ->allow('user', 'agent::profile::change-password')
                ->allow('user', 'agent::profile::country')
                ->allow('user', 'agent::profile::state')
                ->allow('user', 'agent::profile::city')
                ->allow('user', 'agent::profile::location')
                ->allow('user', 'agent::profile::hotel-cuisines')
                ->allow('user', 'agent::profile::hotel-category')
                ->allow('user', 'agent::profile::grocery-category')
                ->allow('user', 'agent::profile::edit-grocery-category')
                ->allow('user', 'agent::profile::edit-location')

        ;
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
                ->add(new Zend_Acl_Resource('admin::static::delivery-guy-order-logs'), 'admin::static')// added by sowmya 4/4/2016
                ->add(new Zend_Acl_Resource('admin::static::view-deliveryguy-details'), 'admin::static')// added by sowmya 8/4/2016
                // admin agent panel/// 
                ->add(new Zend_Acl_Resource('admin::agent'), 'admin')
                ->add(new Zend_Acl_Resource('admin::agent::agent-details'), 'admin::agent')
                ->add(new Zend_Acl_Resource('admin::agent::add-agents'), 'admin::agent')
                ->add(new Zend_Acl_Resource('admin::agent::edit-agent-details'), 'admin::agent')
                ->add(new Zend_Acl_Resource('admin::agent::view-agent-details'), 'admin::agent')// added by sowmya 8/4/2016
                // admin users panel///
                ->add(new Zend_Acl_Resource('admin::user'), 'admin')
                ->add(new Zend_Acl_Resource('admin::user::userdetails'), 'admin::user')
                ->add(new Zend_Acl_Resource('admin::user::edit-user-details'), 'admin::user')
                ->add(new Zend_Acl_Resource('admin::user::view-user-details'), 'admin::user')// added by sowmya 8/4/2016
                ->add(new Zend_Acl_Resource('admin::user::add-user-details'), 'admin::user')
                ->add(new Zend_Acl_Resource('admin::user::user-ajax-handler'), 'admin::user')

                // admin products panel///
                ->add(new Zend_Acl_Resource('admin::product'), 'admin')
                ->add(new Zend_Acl_Resource('admin::product::product-details'), 'admin::product')
                ->add(new Zend_Acl_Resource('admin::product::edit-product-details'), 'admin::product')
                ->add(new Zend_Acl_Resource('admin::product::add-product-details'), 'admin::product')
                ->add(new Zend_Acl_Resource('admin::product::product-ajax-handler'), 'admin::product')
                ->add(new Zend_Acl_Resource('admin::product::view-product-details'), 'admin::product')// added by sowmya 9/4/2016
                // admin settings panel///
                ->add(new Zend_Acl_Resource('admin::settings'), 'admin')
                ->add(new Zend_Acl_Resource('admin::settings::countries-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::city-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::states-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::location-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::locationsettings-handler'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::edit-location'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::cuisines-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::category-details'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::edit-cuisines'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::edit-category'), 'admin::settings')
                ->add(new Zend_Acl_Resource('admin::settings::edit-profile'), 'admin::settings') //by sowmya 19/4/2016
                ->add(new Zend_Acl_Resource('admin::settings::change-password'), 'admin::settings')//by sowmya 19/4/2016
                ->add(new Zend_Acl_Resource('admin::settings::grocery-category-details'), 'admin::settings')//by sowmya 23/4/2016
                ->add(new Zend_Acl_Resource('admin::settings::edit-grocery-category'), 'admin::settings')//by sowmya 23/4/2016
                // admin transactions panel///
                ->add(new Zend_Acl_Resource('admin::transaction'), 'admin')
                ->add(new Zend_Acl_Resource('admin::transaction::admin-user-transactions'), 'admin::transaction')
                ->add(new Zend_Acl_Resource('admin::transaction::admin-agent-transactions'), 'admin::transaction')
                ->add(new Zend_Acl_Resource('admin::transaction::admin-product-transactions'), 'admin::transaction')

                // admin notification panel///added by sowmya 1/4/2016
                ->add(new Zend_Acl_Resource('admin::notification'), 'admin')
                ->add(new Zend_Acl_Resource('admin::notification::notification-log'), 'admin::notification')
                ->add(new Zend_Acl_Resource('admin::notification::send-user-notification'), 'admin::notification')
                ->add(new Zend_Acl_Resource('admin::notification::send-agent-notification'), 'admin::notification')
                ->add(new Zend_Acl_Resource('admin::notification::notification-ajax-handler'), 'admin::notification')
                ->add(new Zend_Acl_Resource('admin::notification::notification'), 'admin::notification')

                // admin hotel-details panel///  5/4/2016
                ->add(new Zend_Acl_Resource('admin::hotel-details'), 'admin')
                ->add(new Zend_Acl_Resource('admin::hotel-details::hotel-details'), 'admin::hotel-details')
                ->add(new Zend_Acl_Resource('admin::hotel-details::add-hotel-details'), 'admin::hotel-details')
                ->add(new Zend_Acl_Resource('admin::hotel-details::edit-hotel-details'), 'admin::hotel-details')
                ->add(new Zend_Acl_Resource('admin::hotel-details::hotel-details-ajax-handler'), 'admin::hotel-details')
                ->add(new Zend_Acl_Resource('admin::hotel-details::view-hotel-details'), 'admin::hotel-details') // added by sowmya 9/4/2016
                // admin grocery-details panel///  20/4/2016
                ->add(new Zend_Acl_Resource('admin::grocery-details'), 'admin')
                ->add(new Zend_Acl_Resource('admin::grocery-details::grocery-details'), 'admin::grocery-details')
                ->add(new Zend_Acl_Resource('admin::grocery-details::add-grocery-details'), 'admin::grocery-details')
                ->add(new Zend_Acl_Resource('admin::grocery-details::edit-grocery-details'), 'admin::grocery-details')
                ->add(new Zend_Acl_Resource('admin::grocery-details::grocery-details-ajax-handler'), 'admin::grocery-details')
                ->add(new Zend_Acl_Resource('admin::grocery-details::view-grocery-details'), 'admin::grocery-details') // added by sowmya 20/4/2016  
                // admin review panel///  20/4/2016
                ->add(new Zend_Acl_Resource('admin::reviews'), 'admin')
                ->add(new Zend_Acl_Resource('admin::reviews::hotel-reviews'), 'admin::reviews')
                ->add(new Zend_Acl_Resource('admin::reviews::grocery-reviews'), 'admin::reviews')
                ->add(new Zend_Acl_Resource('admin::reviews::reviews-ajax-handler'), 'admin::reviews')
                // admin coupons panel///  3/5/2016
                ->add(new Zend_Acl_Resource('admin::coupons'), 'admin')
                ->add(new Zend_Acl_Resource('admin::coupons::add-new-coupon'), 'admin::coupons')
                ->add(new Zend_Acl_Resource('admin::coupons::manage-coupons'), 'admin::coupons')
                ->add(new Zend_Acl_Resource('admin::coupons::coupons-log'), 'admin::coupons')
                ->add(new Zend_Acl_Resource('admin::coupons::edit-coupon'), 'admin::coupons')
                ->add(new Zend_Acl_Resource('admin::coupons::coupons-ajax-handler'), 'admin::coupons')
                // admin newletters panel///  4/5/2016
                ->add(new Zend_Acl_Resource('admin::newsletter'), 'admin')
                ->add(new Zend_Acl_Resource('admin::newsletter::newsletter-ajax-handler'), 'admin::newsletter')
                ->add(new Zend_Acl_Resource('admin::newsletter::send-newsletter'), 'admin::newsletter')
                ->add(new Zend_Acl_Resource('admin::newsletter::add-newsletter'), 'admin::newsletter')
                ->add(new Zend_Acl_Resource('admin::newsletter::edit-newsletter'), 'admin::newsletter')
                ->add(new Zend_Acl_Resource('admin::newsletter::manage-newsletters'), 'admin::newsletter');

        // admin panel landing page///
        $this->allow('guest', 'admin::admin::index')
                ->allow('admin', 'admin::admin::dashboard')
                ->allow('guest', 'admin::admin::logout')

                // // admin agent panel/// ///  
                ->allow('guest', 'admin::error::error')
                ->allow('admin', 'admin::agent::agent-details')
                ->allow('admin', 'admin::agent::add-agents')
                ->allow('admin', 'admin::agent::edit-agent-details')
                ->allow('admin', 'admin::agent::view-agent-details')// added by sowmya 8/4/2016
                // admin users panel///
                ->allow('admin', 'admin::user::userdetails')
                ->allow('admin', 'admin::user::edit-user-details')
                ->allow('admin', 'admin::user::user-ajax-handler')
                ->allow('admin', 'admin::user::add-user-details')
                ->allow('admin', 'admin::user::view-user-details')// added by sowmya 8/4/2016
                // admin products panel///
                ->allow('admin', 'admin::product::product-ajax-handler')
                ->allow('admin', 'admin::product::product-details')
                ->allow('admin', 'admin::product::edit-product-details')
                ->allow('admin', 'admin::product::add-product-details')
                ->allow('admin', 'admin::product::view-product-details')// added by sowmya 9/4/2016
                // admin settings panel///
                ->allow('admin', 'admin::settings::countries-details')
                ->allow('admin', 'admin::settings::city-details')
                ->allow('admin', 'admin::settings::states-details')
                ->allow('admin', 'admin::settings::location-details')
                ->allow('admin', 'admin::settings::locationsettings-handler')
                ->allow('admin', 'admin::settings::edit-location')
                ->allow('admin', 'admin::settings::category-details')
                ->allow('admin', 'admin::settings::cuisines-details')
                ->allow('admin', 'admin::settings::edit-category')
                ->allow('admin', 'admin::settings::edit-cuisines')
                ->allow('admin', 'admin::settings::edit-profile')// added by sowmya 19/4/2016
                ->allow('admin', 'admin::settings::change-password')// added by sowmya 19/4/2016
                ->allow('admin', 'admin::settings::grocery-category-details')// added by sowmya 23/4/2016
                ->allow('admin', 'admin::settings::edit-grocery-category')// added by sowmya 23/4/2016
                // admin transaction panel///
                ->allow('admin', 'admin::transaction::admin-user-transactions')
                ->allow('admin', 'admin::transaction::admin-agent-transactions')
                ->allow('admin', 'admin::transaction::admin-product-transactions')

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
                ->allow('admin', 'admin::static::delivery-guy-order-logs')// added by sowmya 4/4/2016
                ->allow('admin', 'admin::static::view-deliveryguy-details')// added by sowmya 8/4/2016
                // admin notification panel///added by sowmya 1/4/2016
                ->allow('admin', 'admin::notification::notification-log')
                ->allow('admin', 'admin::notification::send-user-notification')
                ->allow('admin', 'admin::notification::send-agent-notification')
                ->allow('admin', 'admin::notification::notification-ajax-handler')
                ->allow('admin', 'admin::notification::notification')

                // admin hotel-details panel///added by sowmya5/4/2016
                ->allow('admin', 'admin::hotel-details::hotel-details')
                ->allow('admin', 'admin::hotel-details::add-hotel-details')
                ->allow('admin', 'admin::hotel-details::edit-hotel-details')
                ->allow('admin', 'admin::hotel-details::hotel-details-ajax-handler')
                ->allow('admin', 'admin::hotel-details::view-hotel-details')
                // admin grocery-details panel///added by sowmya 20/4/2016
                ->allow('admin', 'admin::grocery-details::grocery-details')
                ->allow('admin', 'admin::grocery-details::add-grocery-details')
                ->allow('admin', 'admin::grocery-details::edit-grocery-details')
                ->allow('admin', 'admin::grocery-details::grocery-details-ajax-handler')
                ->allow('admin', 'admin::grocery-details::view-grocery-details')
                // admin review panel///added by sowmya 20/4/2016
                ->allow('admin', 'admin::reviews::hotel-reviews')
                ->allow('admin', 'admin::reviews::grocery-reviews')
                ->allow('admin', 'admin::reviews::reviews-ajax-handler')
                // admin coupons panel///added by sowmya 20/4/2016
                ->allow('admin', 'admin::coupons::add-new-coupon')
                ->allow('admin', 'admin::coupons::manage-coupons')
                ->allow('admin', 'admin::coupons::coupons-log')
                ->allow('admin', 'admin::coupons::edit-coupon')
                ->allow('admin', 'admin::coupons::coupons-ajax-handler')
                // admin newlettes panel///added by sowmya 4/5/2016
                ->allow('admin', 'admin::newsletter::newsletter-ajax-handler')
                ->allow('admin', 'admin::newsletter::add-newsletter')
                ->allow('admin', 'admin::newsletter::send-newsletter')
                ->allow('admin', 'admin::newsletter::edit-newsletter')
                ->allow('admin', 'admin::newsletter::manage-newsletters')
        ; // added by sowmya 20/4/2016
//====================end Admin module=======================  
    }

}

?>