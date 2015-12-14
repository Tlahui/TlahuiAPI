<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseController extends CI_Controller {

  

    function __construct(){
        parent::__construct();
        $this->load->model('PurchaseModel');
    }

/*    public function listar(){
        $this->load->model('CategoryModel');
        $this->load->model('ProductImageModel');
        $productos = $this->ProductModel->ProductList();
        $i=0;
        foreach($productos as $producto){
            $imagenes = $this->ProductImageModel->ImageListFromProduct($producto['id']);
            $categorias = $this->CategoryModel->CategoryFromProduct($producto['id']);
            $productos[$i]['imagenes']=$imagenes;
            $productos[$i]['categorias']=$categorias;
            $i++;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode( $productos ));
    }
*/
    public function add(){

    // $response["responseStatus"]="OK1";
     $newPurchase["idAddress"]=$this->input->post("idAddress");
     $newPurchase["tipoPago"]=$this->input->post("tipoPago");
     $newPurchase["montoTotal"]=$this->input->post("montoTotal");
     $newPurchase["montoEnvio"]=$this->input->post("montoEnvio");
     $newPurchase["referenciaPago"]=$this->input->post("referenciaPago");
     $newPurchase["pagoProcesado"]=$this->input->post("pagoProcesado");
     $newPurchase["solicitudCancelacion"]=$this->input->post("solicitudCancelacion");
    
        $this->load->model("PurchaseModel");
      



        if($this->input->post("montoTotal")!=0){
           $id=$this->PurchaseModel->insertPurchase($newPurchase);
             $response["responseStatus"]="OK";
             $response["message"]="Compra Exitosa";
             $response['id']=$id;
         
        }else{
            
            $response["responseStatus"]= "FAIL";
            $response["message"]="No se pudo realizar compra";

        }
         
      
     echo json_encode($response);

    }

    public function edit(){

    }

    public function delete(){

    }

    public function get($id){

    }

    public function featured(){

    }

    public function category($idCategory){

    }

    public function like(){

    }

    public function unlike(){

    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/purchaseController.php */