<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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
		$username = $this->input->post("username");
		$password = $this->input->post("password");

		$this->load->model("usermodel");

		$userRegister = $this->usermodel->login($username,$password);

		$response ["responseStatus"] = "invalid user";
		
		if ($userRegister !== false )
		{
			$response["responseStatus"] = "OK";
			$response["user"] = $userRegister;
		}

		echo json_encode($response);

	}

	public function register()
	{
		$response["responseStatus"] = "Not OK";
		$newUser["correoElectronico"] = $this->input->post("correoElectronico");
		$newUser["usuario"] = $this->input->post("usuario");
		$newUser["password"] = $this->input->post("password");
		$newUser["nombre"] = $this->input->post("nombre");
		$newUser["fechaNacimiento"] = $this->input->post("fechaNacimiento");
		$newUser["direccion"] = $this->input->post("direccion");
		$newUser["telefono"] = $this->input->post("telefono");

		$this->load->model("usermodel");

		if(0=== preg_match("/^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$/",$newUser["fechaNacimiento"]))
		{
			$response["responseStatus"]  = "Invalid Date Format. yyyy-mm-dd, yyyy mm dd, or yyyy/mm/dd Expected";
		}
		else
		{
			if (!filter_var($newUser["correoElectronico"], FILTER_VALIDATE_EMAIL) === false)
			{
				if($this->usermodel->usernameIsUnique($newUser["usuario"]) &&
				 $this->usermodel->emailIsUnique($newUser["correoElectronico"]))
				{
					if(0 === preg_match("/^(?![0-9]{6,})[0-9a-zA-Z]{6,}$/",$newUser["password"]))
					{
						$response["responseStatus"] = "Password must contain at least one leter, minimum length 6, alphanumeric";
					}
					else
					{
						if(0 === preg_match("/^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$/",$newUser["telefono"]))
						{
							$response["responseStatus"] = "Invalid phone number. Valid formats: 111-222-3333, or 111.222.3333, or (111) 222-3333, or 1112223333";
						}
						else
						{
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

		echo json_encode($response);
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */