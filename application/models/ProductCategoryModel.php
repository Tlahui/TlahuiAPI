<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductCategoryModel extends CI_Model {

    /**
     * Modelo definido para interactuar con la tabla "ProductCategory"
     *
     */

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Agregar Product Category
     *
     *
     * @author Chiunti
     * @return ProductCategoryId|integer
     */
    function productCategoryInsert($newProductCategory) {
        /*
        *
        * Insert new Product Category
        *
        */

        $this->db->insert("ProductCategory",$newProductCategory);
        $productCategoryID = $this->db->insert_id();
        return $productCategoryID;
    }

    /**
     * Borrar Product Category
     *
     *
     * @author Chiunti
     * @param ProductCategoryId|integer
     */
    function productCategoryDelete($productID) {
        /*
        *
        * Delete Product Category
        *
        */

        $this->db->delete('ProductCategory', array('idProduct' => $productID)); 
        return true;
    }

}