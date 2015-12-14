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

    unction ProductUnLike($idProduct, $idUser){  
        $dataProductUnLike = array(
            'idProduct' => $idProduct,
            'idUser' => $idUser);

        $this->db->where('idProduct', $idProduct);
        $this->db->where('idUser', $idUser);
        $query = $this->db->get('ProductLike');
        $response["responseStatus"]= "failed";    //No existe un like en el producto 
        
        if($query->num_rows() !== 0){ //existe relación usuario y producto, entonces se elimina like
            $response["responseStatus"]= "ok";

            $this->db->where('idProduct', $idProduct);
            $this->db->where('idUser', $idUser);
            
            if($this->db->delete('ProductLike')){
                $count = $this->db->query('SELECT * FROM ProductLike')->num_rows;
                echo $count, " likes";
                return $count; 
            }
            else{
                return false;
            }
        }
        echo json_encode($response);             
    }


}