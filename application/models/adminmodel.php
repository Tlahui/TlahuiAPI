<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminmodel extends CI_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        //Connect to database
        $this->load->database();
    }

// las funciones de los modelos SIEMPRE tienen que retornar valores
// Si no es necesario retornar nada, por convención se regresa true

    public function login( $username, $password) {

    }

    // checamos si el correo electrónico ya existe
    public function emailIsUnique( $email ) {

        // Esta función nos permite "construir" la consulta
        // Codeigniter evita inyección de código  la optimiza
        $this->db->where( "correoElectronico", $email );

        // Recuperamos una sola línea de la consulta
        // lo que va dentro de get() es el nombre de la tabla
        // donde aplicaremos la consulta
        $found = $this->db->get("user")->row();

        // regresamos si la encontramos o no
        if ( $found ) {
            return false;
        } else {
            return true;
        }

    }

    // checamos si el nombre ya existe
    public function usernameIsUnique( $name ) {

        // Esta función nos permite "construir" la consulta
        // Codeigniter evita inyección de código  la optimiza
        $this->db->where( "nombre", $name );

        // Recuperamos una sola línea de la consulta
        // lo que va dentro de get() es el nombre de la tabla
        // donde aplicaremos la consulta
        $found = $this->db->get("user")->row();

        // regresamos si la encontramos o no
        if ( $found ) {
            return false;
        } else {
            return true;
        }

    }

    // Insertamos el usuario que obtenemos a traves de la llamada POST
    // al webservice
    public function insertAdmin( $user ) {

        // Insertamos ...
        $this->db->insert( "user", $user );
        // regresamos el ID que le tocó al registro
        $userID = $this->db->insert_id();
        return $userID;

    }

    public function update($userID,$user)
    {
        $this->db->where("id",$userID);
        $this->db->where("type",1);
        $found = $this->db->get("user")->row();

        if ( $found ) {
            $this->db->where("id",$userID);
            $this->db->where("type",1);
            $this->db->update("user",$user);
            return true;
        } else {
            return false;
        }

    }



}

/* End of file adminmodel.php */
/* Location: ./application/controllers/adminmodel.php */
