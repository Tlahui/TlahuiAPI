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

    function ProductLike($idProduct, $idUser){  
        $dataProductLike = array(
            'idProduct' => $idProduct,
            'idUser' => $idUser
        );  
        $this->db->where('idProduct', $idProduct);
        $this->db->where('idUser', $idUser);
        $query = $this->db->get('ProductLike');
        $response["responseStatus"]= "no ok";     

        if($query->num_rows()==0){ //no existe relación usuario y producto, entonces agrego
            $response["responseStatus"]= "ok";
            if( $this->db->insert('ProductLike', $dataProductLike)){
            $count = $this->db->query('SELECT * FROM ProductLike');//para agregar el total de likes
            echo  $count->num_rows();    
            }
            else{
                return false;
            }
        }
    echo json_encode($response);             
    }

}