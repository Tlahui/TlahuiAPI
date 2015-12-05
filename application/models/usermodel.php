<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model {

	public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        //Connect to database
        $this->load->database();
    }

	public function login($username,$password)
	{
		$this->db->where("usuario",$username);
		$this->db->select("usuario,nombre,correoElectronico,direccion,telefono,password");

		$found = $this->db->get("user")->row();

		$databasePassword = false;
		if($found)
		{
			$databasePassword = $found->password;
		}
		else
		{
			$this->db->where("correoElectronico",$username);
			$this->db->select("usuario,nombre,correoElectronico,direccion,telefono,password");
			$found = $this->db->get("user")->row();

			if($found)
			{
				$databasePassword = $found->password;
			}
		}

		if ($databasePassword !== false )
		{
			//echo "entra";
			if (password_verify( $password, $databasePassword))
			{
				unset($found->password);
				return $found;
			}
		}

		//var_dump(password_verify("password", '$2y$10$hAHV97tk4'));
		return false;
	}

	public function usernameIsUnique($username)
	{
		$this->db->where("usuario",$username);

		$found = $this->db->get("user")->row();

		if($found)
		{
			return false;
		}

		return true;
	}

	public function emailIsUnique($email)
	{
		$this->db->where("correoElectronico",$email);

		$found = $this->db->get("user")->row();

		if($found)
		{
			return false;
		}

		return true;
	}

	public function insertuser($user)
	{
		$this->db->insert("user",$user);
		$userID = $this->db->insert_id();
		return $userID;
	}
}