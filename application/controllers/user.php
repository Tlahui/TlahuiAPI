<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model {

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


        // Recuperamos los campos de la tabla usuario
        // buscándolo por nombre de usuario
        $this->db->where( "usuario", $username );
        $this->db->select("usuario,nombre,correoElectronico,direccion,telefono,password");
        $found = $this->db->get("user")->row();

        // Por default, asumimos que falló
        $databasePassword = false;

        // Si lo encontramos ...
        if($found) {
            $databasePassword = $found->password;
        } else {
            // Si no lo encontramos... lo buscamos por su
            // correo electrónico ...
            $this->db->where("correoElectronico",$username);
            $this->db->select("usuario,nombre,correoElectronico,direccion,telefono,password");
            $found = $this->db->get("user")->row();
            if($found) {
                $databasePassword = $found->password;
            }
        }

        // Si fué localizado por nombre o correo electrónico ...
        if ($databasePassword !== false ) {
            // Verificamos el password que introdujo, comparándolo
            // Con el que está almacenado en la base de datos

            // NOTA: password_verify() se encarga de convertir a hash
            // aunque la función original con que convertimos el pass
            // para guardarlo a la base de datos genera un hash distinto
            // cada vez que se ejecuta... pasword_verify() hace la validación
            // exacta sin necesidad de "hashear" el $password que le enviemos
            // para validar ..... 
            if (password_verify( $password, $databasePassword)) {
                // Quitamos de la memoria el password que enviaron
                // ( ya que éste no viene encriptado )
                unset($found->password);
                // Y regresamos true ...
                return $found;
            }
        }
        
        return false;
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
    public function insertUser( $user ) {

        // Insertamos ...
        $this->db->insert( "user", $user );
        // regresamos el ID que le tocó al registro
        $userID = $this->db->insert_id();
        return $userID;

    }

}

/* End of file usermodel.php */
/* Location: ./application/controllers/usermodel.php */
