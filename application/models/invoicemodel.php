<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InvoiceModel extends CI_Model {

  public function __construct()
  {
      // Call the Model constructor
      parent::__construct();
      //Connect to database
      $this->load->database();
  }

  public function getInvoice($idPurchase) {

    $this->db->select("id,idPurchase,idAddress,nombre,rfc,numFactura,fechaEmision,fechaPago,tipoPago");
    $result = $this->db->get_where("Invoice",array("id"=>$idPurchase))->row();

    return $result;
  }


}
