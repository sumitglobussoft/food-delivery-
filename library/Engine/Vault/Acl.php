<?php

class Engine_Vault_Acl extends Zend_Acl {

    public function __construct() {
        // Add a new role called "guest"
        $this->addRole(new Zend_Acl_Role('guest'));
        // Add a role called user, which inherits from guest
        $this->addRole(new Zend_Acl_Role('user'), 'guest');
        // Add a role called admin, which inherits from user
        $this->addRole(new Zend_Acl_Role('admin'), 'user');
//========================web module=======================
        $this->add(new Zend_Acl_Resource('web'))
                ->add(new Zend_Acl_Resource('web::home'), 'web')
                ->add(new Zend_Acl_Resource('web::error'), 'web')
                ->add(new Zend_Acl_Resource('web::error::error'), 'web::error')
                ->add(new Zend_Acl_Resource('web::home::home'), 'web::home')
                ->add(new Zend_Acl_Resource('web::home::index'), 'web::home');

        $this->allow('guest', 'web::home::home')
                ->allow('guest', 'web::error::error')
                ->allow('guest', 'web::home::index');

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
                ->allow('guest', 'agent::authentication::dashboard')
                ->allow('guest', 'agent::authentication::logout');

//====================end Agent module=======================  

        //========================Admin module=======================
        $this->add(new Zend_Acl_Resource('admin'))
                ->add(new Zend_Acl_Resource('admin::admin'), 'admin')
                ->add(new Zend_Acl_Resource('admin::order'), 'admin')
                ->add(new Zend_Acl_Resource('admin::payment'), 'admin')
                ->add(new Zend_Acl_Resource('admin::product'), 'admin')
                ->add(new Zend_Acl_Resource('admin::settings'), 'admin')
                ->add(new Zend_Acl_Resource('admin::static'), 'admin')
                ->add(new Zend_Acl_Resource('admin::transaction'), 'admin')
                ->add(new Zend_Acl_Resource('admin::user'), 'admin')
                ->add(new Zend_Acl_Resource('admin::admin::index'), 'admin::admin')
                ->add(new Zend_Acl_Resource('admin::admin::dashboard'), 'admin::admin')
                ->add(new Zend_Acl_Resource('admin::admin::logout'), 'admin::admin');

        $this->allow('guest', 'admin::admin::index')
                ->allow('guest', 'admin::admin::dashboard')
                ->allow('guest', 'admin::admin::logout');

//====================end Agent module=======================  
    }

}

?>