<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productmodel extends CI_Model {

	public function __construct()
    {
        // Llama al constructor de modelos
        parent::__construct();

        //Hace la conexión con la Base de Datos
        $this->load->database();
    }

	public function getDetails()
	{
		// Selección de las columnas que vamos a visualizar
		$this->db->select("id, precio, nombre, precio, oferta, descripcion, productor,");

		//result() regresa un arreglo de objetos
		$products = $this->db->get("product")->result();

		return $products;

	}
}