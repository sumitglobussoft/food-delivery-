<?php

/**
 * AdminController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';

class Admin_ProductController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function productDetailsAction() {

        $productsModel = Admin_Model_Products::getInstance();
        $result = $productsModel->getProductsdetails();
  if ($result) {
            $activeArr = $inactiveArr = array();
            
            foreach ($result as $key => $value) {

                if ($value['prod_status'] == 1) {
                    $activeArr[] = $value;
                } else if($value['prod_status'] == 2) {
                    $inactiveArr[] = $value;
                }
            }
            
               $this->view->activeStatus = $activeArr;
            $this->view->inactiveStatus = $inactiveArr;
            $this->view->productdetails = $result;
        } else {
            echo 'controller error occured';
        }
   
    }

    public function allProductDetailsAction() {
        $agentsModel = Admin_Model_Agents::getInstance();
        $menuCategoryModel = Admin_Model_MenuCategory::getInstance();
        $productsModel = Admin_Model_Products::getInstance();
        $productId = $this->getRequest()->getParam("productId");

        if ($this->_request->isPost()){
            
            $agentId = $this->getRequest()->getPost('agent_id');
            $categoryId = $this->getRequest()->getPost('category_id');
            $productId = $this->getRequest()->getPost('product_id');

            $agentdata['loginname'] = $this->getRequest()->getPost('loginname'); 
            $agentdata['email'] = $this->getRequest()->getPost('email'); //agent
            $agentdata['city'] = $this->getRequest()->getPost('city'); //agent
            $agentdata['address'] = $this->getRequest()->getPost('address'); //agent
            $agentdata['membership'] = $this->getRequest()->getPost('membership'); //agent
            $agentdata['agent_status'] = $this->getRequest()->getPost('agent_status'); //agent

            $catdata['cat_name'] = $this->getRequest()->getPost('cat_name'); //menu_cat
            $catdata['cat_desc'] = $this->getRequest()->getPost('cat_desc'); //menu_cat
            $catdata['cat_status'] = $this->getRequest()->getPost('cat_status'); //menu_cat

            $productdata['name'] = $this->getRequest()->getPost('prod_name'); //product
            $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc'); //product
            $productdata['imagelink'] = $this->getRequest()->getPost('imagelink'); //product
            $productdata['cost'] = $this->getRequest()->getPost('cost'); //product
            $productdata['delivery_time'] = $this->getRequest()->getPost('deliverytime'); //product
            $productdata['prod_status'] = $this->getRequest()->getPost('prod_status'); //product

            $result1 = $agentsModel->updateAgentsdetails($agentId, $agentdata);
            $result2 = $menuCategoryModel->updateMenuCatdetails($categoryId, $catdata);
            $result3 = $productsModel->updateProductsdetails($productId, $productdata);
        }



        $result = $productsModel->getAllProductdetails($productId);
       
        if ($result) {
            $this->view->allproductdetails = $result;
        } else {
            echo 'controller error occured';
        }
    }

    public function addProductDetailsAction() {
        $agentsModel = Admin_Model_Agents::getInstance();
        $menuCategoryModel = Admin_Model_MenuCategory::getInstance();
        $productsModel = Admin_Model_Products::getInstance();

        if ($this->_request->isPost()):
            $agentdata['loginname'] = $this->getRequest()->getPost('loginname'); //agent
            $agentdata['email'] = $this->getRequest()->getPost('email'); //agent
            $agentdata['city'] = $this->getRequest()->getPost('city'); //agent
            $agentdata['address'] = $this->getRequest()->getPost('address'); //agent
            $agentdata['agent_status'] = $this->getRequest()->getPost('agent_status'); //agent
            $agentdata['membership'] = $this->getRequest()->getPost('membership'); //agent

            $agentId = $agentsModel->addAgentdetails($agentdata);

            $catdata['cat_name'] = $this->getRequest()->getPost('cat_name'); //menu_cat
            $catdata['cat_desc'] = $this->getRequest()->getPost('cat_desc'); //menu_cat
            $catdata['cat_status'] = $this->getRequest()->getPost('cat_status'); //menu_cat

            $menuCatId = $menuCategoryModel->addCatdetails($catdata);

            $productdata['agent_id'] = $agentId;
            $productdata['category_id'] = $menuCatId;
            $productdata['name'] = $this->getRequest()->getPost('prod_name'); //product
            $productdata['prod_desc'] = $this->getRequest()->getPost('prod_desc'); //product
            $productdata['imagelink'] = $this->getRequest()->getPost('imagelink'); //product
            $productdata['cost'] = $this->getRequest()->getPost('cost'); //product
            $productdata['delivery_time'] = $this->getRequest()->getPost('deliverytime'); //product
            $productdata['prod_status'] = $this->getRequest()->getPost('prod_status'); //product

            $result = $productsModel->addProductsdetails($productdata);
        endif;
    }

}
