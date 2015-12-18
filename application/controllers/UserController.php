<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserController extends CI_Controller {

	    /**
     * Controlador definido para interactuar con usuarios
     *
     * Se encuentra compuesto de las siguientes rutas:
     * 		
     *      /user/listar
     *    
     *
     * El modelo definido por defecto para interactuar con la BD es UserModel.
     * Si se requiere el uso de metodos adicionales declararlos hasta abajo
     *
     */
	public function listar()
	{
		$response["responseStatus"] = "Fail";
		$response["message"] = "Usuarios no pueden ser listados";

		// load model
		$this->load->model("usermodel");

		$response["user"] = $this->usermodel->listar();
		$response["responseStatus"] = "OK";
		$response["message"] = "Lista de Usuarios";

		echo json_encode($response);
	}
}

/* End of file UserController.php */
/* Location: ./application/controllers/UserController.php */