<?php

class Admin_Model_Products extends Zend_Db_Table_Abstract {

    private static $_instance = null;
    protected $_name = 'products';

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new Admin_Model_Products();
        }
        return self::$_instance;
    }

    /*
     * Modified code 
     * Dev :priyanka varanasi
     */

    //////////////////// Newly modifed and used code /////////////////
    public function getProductsdetails() {
        try {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('p' => 'products'))
                    ->joinLeft(array('hd' => 'hotel_details'), 'p.hotel_id= hd.id');
            $result = $this->getAdapter()->fetchAll($select);
        } catch (Exception $e) {
            throw new Exception('Unable To retrieve data :' . $e);
        }

        if ($result) {
            return $result;
        }
    }

    public function addProductsdetails() {
        if (func_num_args() > 0) {
            $productdata = func_get_arg(0);

            try {
                $rowid = $this->insert($productdata);
                if ($rowid) {
                    return $rowid;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To insert data :' . $e);
            }
        }
    }

    //added by sowmya 9/4/2016
    public function getAllProductdetails() {
        if (func_num_args() > 0) {
            $productId = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('p' => 'products'))
                        ->joinLeft(array('hd' => 'hotel_details'), 'p.hotel_id= hd.id')
                        ->joinLeft(array('a' => 'agents'), 'p.agent_id= a.agent_id')
                        ->joinLeft(array('m' => 'menu_category'), 'p.category_id= m.category_id')
                        ->joinLeft(array('fc' => 'famous_cuisines'), 'p.cuisine_id= fc.cuisine_id')
                        ->where('p.product_id=?', $productId);
                $result = $this->getAdapter()->fetchRow($select);
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }

            if ($result) {
                return $result;
            }
        }
    }

    public function updateProductsdetails() {
        if (func_num_args() > 0) {
            $productId = func_get_arg(0);
            $productdata = func_get_arg(1);
            try {
                $result3 = $this->update($productdata, 'product_id = "' . $productId . '"');
                if ($result3) {
                    return $result3;
                } else {

                    return null;
                }
            } catch (Exception $e) {

                throw new Exception('Unable To update data :' . $e);
            }
        }
    }

    public function getProductsByHotelId() {
        if (func_num_args() > 0) {
            $hotelId = func_get_arg(0);
            try {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('p' => 'products'))
                        ->joinLeft(array('hd' => 'hotel_details'), 'p.hotel_id= hd.id')
                        ->where('p.hotel_id=?', $hotelId);
                $result = $this->getAdapter()->fetchAll($select);

                if ($result) {
                    return $result;
                }
            } catch (Exception $e) {
                throw new Exception('Unable To retrieve data :' . $e);
            }
        }
    }

    public function changeProductStatus() {
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
    //desc: to delete products
    //date:29/1/2016

    public function productDelete() {
        if (func_num_args() > 0):
            $productid = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('product_id = ?' => $productid));
                $db->delete('products', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $productid;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    /* Dev : Sowmya
     * Date: 11/4/2015
     * desc: to delete products by agent id */

    public function productDeleteByAgentId() {
        if (func_num_args() > 0):
            $agent_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('agent_id = ?' => $id));
                $db->delete('products', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $agent_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

    /* Dev : Sowmya
     * Date: 11/4/2015
     * desc: to delete products by agent id */

    public function deleteProductsByHotelId() {
        if (func_num_args() > 0):
            $hotel_id = func_get_arg(0);
            try {
                $db = Zend_Db_Table::getDefaultAdapter();
                $where = (array('hotel_id = ?' => $hotel_id));
                $db->delete('products', $where);
            } catch (Exception $e) {
                throw new Exception($e);
            }
            return $hotel_id;
        else:
            throw new Exception('Argument Not Passed');
        endif;
    }

}

?>