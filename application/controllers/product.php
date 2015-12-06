<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function getAll()
	{
		$response["responseStatus"] = "Not OK";

		// load model
		$this->load->model("productmodel");
		
		$response["products"] = $this->productmodel->getAll();
		$response["responseStatus"] = "OK";

		echo json_encode($response);
	}

	public function getAvailability()
	{
		$response["responseStatus"] = "Product not found";

		$productID = $this->input->post("idProduct");

		$this->load->model("productmodel");

		$productAvailability = $this->productmodel->getAvailability($productID);

		if(false !== $productAvailability)
		{
			$response["responseStatus"] = "OK";
			$response["availability"] = true;
			$response["qty"] = $productAvailability->qty;
		}

		echo json_encode($response);
	}
	
	/*
	 *	Function addProduct
	 *	Insert new Product on DB
	 *	Recive from POST request:
	 *		- Nombre:
	 *		- Precio
	 *		- Cantidad
	 *		- imagenes
	 * 
	 * Returns: idProduct, reponseStatus: OK
	 */
	public function addProduct() {
		
		$response["responseStatus"] = false;
		
		
		$product["nombre"]  = $this->input->post("nombre");
		$product["precio"] = $this->input->post("precio");
		$product["qty"] = $this->input->post("qty");
		
		if (preg_match('/^[0-9]+(?:\.[0-9]{0,2})?$/', $product["precio"])) {
			$response["responseStatus"] = "Invalid amount";
		}
		else {
			$images = $this->input->post("images");
		
			$this->load->model("productmodel");
			$idProduct = $this->productmodel->addProduct($product);
		
			$imageList = explode(",",$images);
			for($i=0 ; $i<count($imageList); $i++) {
			}
			
			
			$this->productmodel->addProductImages($idProduct,$images);
			
			
			//if all check 
			$response["responseStatus"] = "Ok";	
		}
		
		echo json_encode($response);
	}
}

/* End of file product.php */
/* Location: ./application/controllers/product.php */