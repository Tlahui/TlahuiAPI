<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function login()
	{
		// ¿ el admin va a tener un login ?
	}


	// Inserta un nuevo registro, desde el consumo del webservice REGISTER
	// Se utiliza la misma tabla USER, pero con un campo extra para indicar
	// ue es de tipo Administrador
	public function create() {

		$response["responseStatus"] = "Not OK";

		// Las variables que obtenemos del post las ponemos en un array
		$newUser["correoElectronico"] = $this->input->post("correoElectronico");
		$newUser["usuario"] = $this->input->post("usuario");
		$newUser["password"] = $this->input->post("password");
		$newUser["nombre"] = $this->input->post("nombre");
		$newUser["fechaNacimiento"] = $this->input->post("fechaNacimiento");
		$newUser["direccion"] = $this->input->post("direccion");
		$newUser["telefono"] = $this->input->post("telefono");

		// Activamos el model (archivo php) que contiene las funciones
		// que usaremos adelante
		$this->load->model("adminmodel");

		// Insertamos siempre y cuando no exista
		// y pase las validaciones...

		// Si ocurre un error regresa 0 ... así que aquí checamos si la fecha
		// viene mal
		if( 0 === preg_match("/^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$/",$newUser["fechaNacimiento"]))
		{
			$response["responseStatus"]  = "Invalid Date Format. yyyy-mm-dd, yyyy mm dd, or yyyy/mm/dd Expected";
		}
		else
		{
			// Validamos el correo electrónico...
			if (!filter_var($newUser["correoElectronico"], FILTER_VALIDATE_EMAIL) === false)
			{
				// Validamos que aún no existan en la base de datos
				if($this->adminmodel->usernameIsUnique($newUser["usuario"]) && 
				 $this->adminmodel->emailIsUnique($newUser["correoElectronico"]))
				{	
					// Validamos que el password cumpla con ciertos criterios (al menos 6 posiciones, al menos una letra...)
					if(0 === preg_match("/^(?![0-9]{6,})[0-9a-zA-Z]{6,}$/",$newUser["password"]))
					{
						$response["responseStatus"] = "Password must contain at least one leter, minimum length 6, alphanumeric";
					}
					else
					{
						// Validamos el teléfono ...
						if(0 === preg_match("/^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$/",$newUser["telefono"]))
						{
							$response["responseStatus"] = "Invalid phone number. Valid formats: 111-222-3333, or 111.222.3333, or (111) 222-3333, or 1112223333";
						}
						else
						{
							// Si llegamos hasta aquí, es que los datos accesados son correctos
							$newUser["password"] = password_hash($newUser["password"], PASSWORD_DEFAULT);

							// Le ponemos la "marca" de que éste usuario es de tipo Administrador
							$newUser["type"] = 1;							

							// Insertamos el nuevo usuario a través de una llamada al modelo
							$response["userID"] = $this->adminmodel->insertadmin($newUser);
							$response["responseStatus"] = "OK";
						}
					}
				}
				else
				{
					$response["responseStatus"] = "Email or Username Exists Already";
				}
			}
			else
			{
				$response["responseStatus"] = "Invalid Email Format";
			}
		}

		// Regresamos la respuesta en formato JSON
		//echo json_encode($response);
		// Según la documentación, ésta es la manera en que debemos
		// regresar el json... y con ésta función me respeta el UTF8
		// a diferencia del echo...
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));		

	}

	public function getClients()
	{
		$response["responseStatus"] = "Not OK";

		// load model
		$this->load->model("adminmodel");

		$response["clients"] = $this->adminmodel->getAllClients();
		$response["responseStatus"] = "OK";

		echo json_encode($response);

	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */	
