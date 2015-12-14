<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseModel extends CI_Model {

    /**
     * Modelo definido para interactuar con la tabla "Purchase"
     *
     */

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }




    function insertPurchase($Purchase){

        $this->db->insert("Purchase",$Purchase);
        $PurchaseID=$this->db->insert_id();
        return $PurchaseID;
    }

  

}