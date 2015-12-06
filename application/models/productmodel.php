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

    public function  AddProductImage($productID,$url){
        $dataProductImage = array(
            'url' => $url,
            'idProduct' => $productID
        );
        $query = $this->db->insert('productImage', $dataProductImage);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
}