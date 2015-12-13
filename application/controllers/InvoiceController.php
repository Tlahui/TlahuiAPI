<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InvoiceController extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
  }

  public function get($id) {

    $response["responseStatus"] = false;

    if(is_numeric($id) && $id > 0) {
      $this->load->model("InvoiceModel");
      $invoice = $this->InvoiceModel->getInvoice($id);

      echo json_encode($invoice);
    }
    else {
      $response["responseStatus"] = "FAIL";
      $response["message"] = "Registro no encontrado";

      $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
  }

}

?>
