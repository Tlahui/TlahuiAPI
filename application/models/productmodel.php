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
	
	/*
	 * retorna idProduct 
	*/
	public function addProduct($product) {
		$this->db->insert("product",$product);
		
		$idProduct = $this->db->insert_id();
		return 	$idProduct;
	}
	
	
	public function addProductImages($idProduct, $images) {
		$imageList = explode(",",$images);
		
		for($i=0 ; $i<count($imageList); $i++) {
			$imageUrl["idProduct"] = $idProduct;
			$imageUrl["url"] = $imageList[$i];
			$this->db->insert("productImage",$imageUrl);
		}
		
	}
}