<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductImageController extends CI_Controller {

    /**
     * Controlador definido para interactuar con Imagenes de productos
     *
     * Se encuentra compuesto de las siguientes rutas:
     * 		/product/image/add
     *      /product/image/get/:id
     *      /product/image/all/:id
     *      /product/image/delete
     *
     * El modelo definido por defecto para interactuar con la BD es ModelProduct.
     * Si se requiere el uso de metodos adicionales declararlos hasta abajo
     *
     */

    function __construct(){
        parent::__construct();
        $this->load->model('ProductImageModel');
    }

    public function add(){

    }

    public function get($id){

    }

    public function all($idUser){

    }

    public function delete(){

    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/productController.php */