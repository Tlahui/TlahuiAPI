<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model {

	public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        //Connect to database
        $this->load->database();
    }

	public function login()
	{
		return true;
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