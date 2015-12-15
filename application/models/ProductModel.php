<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductModel extends CI_Model {

    /**
     * Modelo definido para interactuar con la tabla "Product"
     *
     */

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Listado de productos
     *
     * Obtiene un array con los registros de la tabla ProductImage
     * y en caso que no exista revuelve false
     *
     * @author Gosh
     * @return Array|boolean
     */
    function ProductList(){
        $query = $this->db->get('Product');
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    function productInsert($newProduct){
        /*
        *
        * Insert new Product
        *
        */

        $this->db->insert("Product",$newProduct);
        $productID = $this->db->insert_id();
        return $productID;
    }

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

    function productSizeInsert($newProductSize) {
        /*
        *
        * Insert new Product Size
        *
        */

        $this->db->insert("ProductSize",$newProductSize);
        $productSizeID = $this->db->insert_id();
        return $productSizeID;

    }

    function productSizesInsert($newProductSizes){
        /*
        *
        * Insert multiple Product Sizes
        *
        */

        foreach($newProductSizes as $newProductSize){
            self::productSizeInsert($newProductSize);
        }

    }

}