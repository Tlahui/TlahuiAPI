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
	
	
	// Pide un idProducto... y regresa las tallas disponibles para dicho producto
	public function size()
	{
		$response["responseStatus"] = "Not OK";
		
		// Obtenemos el id del producto 
		$idProduct = $this->input->get("idProduct");
		
		// load model
		$this->load->model("productmodel");

		$productSize = $this->productmodel->getProductSize( $idProduct );
		
		if(false !== $productSize)
		{
			$response["responseStatus"] = "OK";
			$response["sizes"] = $productSize;
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));
			
	}
	
	
	
	// Actualizamos la cantidad de productos disponibles, pasándole el ID de la combinación
	// de producto y talla (size)
	public function updateSizeById()
	{
		$response["responseStatus"] = "FAIL";
		$response["message"] = "Cantidad no pudo ser modificada";
		
		// Obtenemos el id del producto 
		$id = $this->input->post("id");
		$cantidad = $this->input->post("cantidad");
		
		// load model
		$this->load->model("productmodel");

		$productSize = $this->productmodel->updateSizeById( $id, $cantidad );
		
		if(false !== $productSize)
		{
			$response["responseStatus"] = "OK";
			$response["message"] = "Cantidad modificada correctamente";
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));
			
	}
	




	// Adicionamos una nueva combinación de producto y talla, así como su existencia
	public function sizeAdd()
	{
		$response["responseStatus"] = "FAIL";
		$response["message"] = "Talla no pudo ser insertada";
		
		// Obtenemos el id del producto 
		$idProduct = $this->input->post("idProduct");
		$idSize = $this->input->post("idSize");
		$cantidad = $this->input->post("cantidad");
		
		// load model
		$this->load->model("productmodel");

		$resultado = $this->productmodel->sizeAdd( $idProduct, $idSize, $cantidad );
		
		
		if(false !== $resultado)
		{
			$response["responseStatus"] = "OK";
			$response["message"] = "Talla insertada correctamente";
			$response["data"] = $resultado;
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));
			
	}
	


	// Eliminamos una combinación de producto y talla, así como su existencia
	public function sizeDelete()
	{
		$response["responseStatus"] = "FAIL";
		$response["message"] = "Talla no pudo ser eliminado para el producto";
		
		// Obtenemos el id del producto 
		$idProduct = $this->input->post("idProduct");
		// Si pasan idSize lo tomamos, si no le asignamos 0 que significará TODOS en código
		$idSize = $this->input->post("idSize");
		$idSize = ( trim( $idSize ) == "" ? 0 : $idSize );

		// load model
		$this->load->model("productmodel");

		$resultado = $this->productmodel->sizeDelete( $idProduct, $idSize );
		
		
		if(0 !== $resultado)
		{
			$response["responseStatus"] = "OK";
			$response["message"] = "Talla eliminada correctamente para el producto";
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));
			
	}
	
	
}

/* End of file product.php */
/* Location: ./application/controllers/product.php */
