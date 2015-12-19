<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddressController extends CI_Controller {

	/**
	 * Listado de direcciones de un usuario
	 */
		public function all()
	{
		$userID = $this->input->post("idUser");

		$this->load->model("AddressModel");
		$response["idUser"] = $userID;
		$response["direccion"] = $this->AddressModel->allAddress($userID);

		echo json_encode($response);
	}


	public function add()
	{
		$response["responseStatus"] = "Not OK";
		// Las variables que obtenemos del post las ponemos en un array
		$newAddress["idUser"] = $this->input->post("idUser");
		$newAddress["idState"] = $this->input->post("idState");
		$newAddress["identificadorDireccion"] = $this->input->post("identificadorDireccion");
		$newAddress["calle"] = $this->input->post("calle");
		$newAddress["exterior"] = $this->input->post("exterior");
		$newAddress["interior"] = $this->input->post("interior");
		$newAddress["colonia"] = $this->input->post("colonia");
		$newAddress["municipio"] = $this->input->post("municipio");
		$newAddress["codigoPostal"] = $this->input->post("codigoPostal");
		$newAddress["entreCalles"] = $this->input->post("entreCalles");


		
		// Activamos el model (archivo php) que contiene las funciones
		// que usaremos adelante
		$this->load->model("addressmodel");
		// Insertamos siempre y cuando no exista
		// y pase las validaciones...
		// Si ocurre un error regresa 0 ... así que aquí checamos si la fecha
		// viene mal

		//$newUser["password"] = password_hash($newUser["password"], PASSWORD_DEFAULT);
		$response["userID"] = $this->addressmodel->insertaddress($newAddress);
		$response["responseStatus"] = "OK";
		$response["responseStatus"] = "La dirección se ha insertado Correctamente";



		// Regresamos la respuesta en formato JSON
		//echo json_encode($response);
		// Según la documentación, ésta es la manera en que debemos
		// regresar el json... y con ésta función me respeta el UTF8
		// a diferencia del echo...
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));
	}


	public function get()
	{
		// Obtenemos los datos que envío el post
		$idAddress = $this->input->post("idAddress");
		// Ahora creamos el modelo
		$this->load->model("addressmodel");
		// Llamamos a la función que debe retornarnos los datos del usuario
		// o false si ocurrió un error o es inválido
		$addressRegister = $this->addressmodel->buscar($idAddress);
		
		// Le asignamos por default que no fué exitoso
		$response ["responseStatus"] = "La dirección no existe";
		
		// Si no ocurrió un error ...
		if ($addressRegister !== false ) {
			$response["responseStatus"] = "OK, dirección existente";
			$response["Direccion"] = $addressRegister;
		}
		// Regresamos el JSON
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));	
	}
	
}

/* End of file AddressController.php */
/* Location: ./application/controllers/AddressController.php */