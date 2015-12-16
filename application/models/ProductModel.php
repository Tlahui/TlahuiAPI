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

    /**
     * Listado de productos en Oferta
     *
     * Obtiene un array con los registros de la tabla ProductImage
     * y en caso que no exista revuelve false
     *
     * @author Chiunti
     * @return Array|boolean
     */
    function ProductListFeatured(){
        $query = $this->db->get_where('Product', array('oferta' => 1));
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

    function productDelete($productID){
        /*
        *
        * Delete Product
        *
        */
        $this->db->delete('Product', array('id' => $productID)); 
    }

    function productExist($productID){
        /*
        *
        * Check if exist Product
        *
        */
        $query = $this->db->get_where('Product', array('id' => $productID));
        return ($query->num_rows() > 0);
    }

}