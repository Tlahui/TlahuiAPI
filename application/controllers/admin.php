<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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

		$this->load->model("adminmodel");

		$adminRegister = $this->adminmodel->login($username,$password);

		$response ["responseStatus"] = "invalid user";
		
		if ($adminRegister !== false )
		{
			$response["responseStatus"] = "OK";
			$response["user"] = $adminRegister;
		}
		echo json_encode($response);
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */