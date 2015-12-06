<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminmodel extends CI_Model {

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
        $this->db->where("type",1);
        $this->db->select("id,usuario,nombre,correoElectronico,password");

        $found = $this->db->get("user")->row();

        $databasePassword = false;
        if($found)
        {
            $databasePassword = $found->password;
            
            
        }
        else
        {
            $this->db->where("correoElectronico",$username);
            $this->db->select("id,usuario,nombre,correoElectronico,password");
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
}