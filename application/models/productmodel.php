<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productmodel extends CI_Model {

	public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        //Connect to database
        $this->load->database();
    }

	public function getAll()
	{
		$this->db->select("id, nombre, precio");
		// result() return array of objects
		$products = $this->db->get("product")->result();

		return $products;
	}

	public function getAvailability($productID)
	{
		$this->db->where("id",$productID);
		$availability = $this->db->get("product")->row();

		if($availability)
		{
			return $availability;
		}

		return false;
	}
	
	
	// Obtenemos todos los tamaños disponibles, de un idProduct determinado
	public function getProductSize( $idProduct )
	{
		$this->db->select("idSize, nombre");
		$this->db->where("idProduct", $idProduct);
		$this->db->join("size", "productsize.idSize = size.id");
		
		// Regresamos todos los registros que encuentre 
		$products = $this->db->get("productsize")->result_array();
		
		return $products;
		
	}


	// Obtenemos todos los tamaños disponibles, de un idProduct determinado
	public function updateSizeById( $id, $cantidad )
	{
	
		$data = array( 'cantidad' => $cantidad );	
		$this->db->where("id", $id);
		$this->db->update("productsize", $data);
		
		// OJO: Si el UPDATE se lleva a cabo regresa 1 línea afectada
		// sin embargo, si repito el UPDATE, como ya no modifica la cantidad porque sería la misma
		// regresa 0
		return ( $this->db->affected_rows() == 1 );
		
	}
	
	
	
	// Adicionamos una nueva combinación de producto y talla (size), más su cantidad (existencia)
	public function sizeAdd( $idProduct, $idSize, $cantidad )
	{
	
		// db_debug TIENE que estar a FALSE para que _error_number funcione
		// sin embargo, para no moverle a la configuración, guardaremos el valor actual,
		// lo cambiaremos, y luego lo dejamos como estaba
		$orig_db_debug = $this->db->db_debug;
		$this->db->db_debug = FALSE;	
	
		$data = array( 
			'idProduct' => $idProduct,
			'idSize' => $idSize,
			'cantidad' => $cantidad
		);	
		
		$this->db->insert("productsize",$data);
		
		
		$this->db->db_debug = $orig_db_debug;
		
		// Si se ejecutó exitosamente ...
		if ( $this->db->_error_number() == 0 ) {		
			$userID = $this->db->insert_id();
			return $userID;
		} else {
			return false;
		}
		
	}
	



	// Eliminamos una combinación de producto y talla (size)
	// size es opcional, si no lo pasan borraos todos los idProduct encontrados
	public function sizeDelete( $idProduct, $idSize )
	{
	
		$this->db->where("idProduct",$idProduct);
		if ( $idSize != 0 ) {
			$this->db->where("idSize",$idSize);
		}
		$this->db->delete("productsize");

		// Regresamos las líneas afectadas por el DELETE
		// 0 significará que no se borró nada		
		return $this->db->affected_rows();
		
	}
	
}
