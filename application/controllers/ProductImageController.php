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
        $this->load->helper(array('form', 'url'));
    }

   public function add(){

        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
     
        $this->load->model("ProductImageModel");
        $this->load->helper(array('url'));
        $this->load->library('upload', $config);
    
        $response["responseStatus"] = "Error";
        $productID = $this->input->post("idProduct");
     

   if (!$this->upload->do_upload('url')){
            $response['responseStatus'] = "failed";
        }
        else
        {
               $dataImage = array('upload_data' => $this->upload->data());
                $addProductImage = $this->ProductImageModel->AddProductImage($productID, $dataImage["upload_data"]["file_name"]);
                if($addProductImage){
                    $response["responseStatus"] = "OK";
                    $response["url"] = $dataImage["upload_data"]["file_name"];
                    $response["IDImage"] = $addProductImage;
                }
                else{
                    $response["responseStatus"] = "Error";
                }
               
        }
         echo json_encode($response);       
  
}

}

/* End of file welcome.php */
/* Location: ./application/controllers/productController.php */