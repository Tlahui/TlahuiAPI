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

	public function getDetails()

	{ 
		$response["responseStatus"] = "Not OK";

		// Crga el Modelo para obtener los productos
		$this->load->model("productmodel");

		// Se asignan todos los productos de la Base de Datos
		$response["products"] = $this->productmodel->getDetails();

		// El servicios se manda llamar correctamente responde OK
		$response["responseStatus"] = "OK";

		echo json_encode($response);
	}

	
}

/* End of file product.php */
/* Location: ./application/controllers/product.php */