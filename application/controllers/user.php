<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User  extends CI_Controller {

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
	public function login()
	{
		//$this->load->view('welcome_message');

		// Obtenemos los datos que envío el post
		$username = $this->input->post("username");
		$password = $this->input->post("password");

		// Ahora creamos el modelo
		$this->load->model("usermodel");

		// Llamamos a la función que debe retornarnos los datos del usuario
		// o false si ocurrió un error o es inválido
		$userRegister = $this->usermodel->login( $username, $password );
		
		// Le asignamos por default que no fué exitoso
		$response ["responseStatus"] = "invalid user";
		
		// Si no ocurrió un error ...
		if ($userRegister !== false ) {
			$response["responseStatus"] = "OK";
			$response["user"] = $userRegister;
		}

		// Regresamos el JSON
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));		

	}


	// Inserta un nuevo registro, desde el consumo del webservice REGISTER
	public function register() {

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
		$this->load->model("usermodel");

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
				if($this->usermodel->usernameIsUnique($newUser["usuario"]) && 
				 $this->usermodel->emailIsUnique($newUser["correoElectronico"]))
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
							$response["userID"] = $this->usermodel->insertuser($newUser);
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






	// Inserta un nuevo registro, desde el consumo del webservice REGISTER
	// Se utiliza la misma tabla USER, pero con un campo extra para indicar
	// ue es de tipo Administrador
	public function registerAdmin() {

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
		$this->load->model("usermodel");

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
				if($this->usermodel->usernameIsUnique($newUser["usuario"]) && 
				 $this->usermodel->emailIsUnique($newUser["correoElectronico"]))
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
							$response["userID"] = $this->usermodel->insertuser($newUser);
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


}

/* End of file user.php */
/* Location: ./application/controllers/user.php */	
