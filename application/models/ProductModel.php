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


    function ProductList(){
        $query = $this->db->get('Product');
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    function ImageListFromProduct($id){
        $query = $this->db->get_where('ProductImage', array('idProduct' => $id));
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return 0;
        }
    }

    function CategoryFromProduct($id){
        $this->db->select('Category.id, Category.nombre');
        $this->db->from('ProductCategory');
        $this->db->where('ProductCategory.idProduct', $id);
        $this->db->join('Category', 'Category.id = ProductCategory.idCategory');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return 0;
        }
    }

}