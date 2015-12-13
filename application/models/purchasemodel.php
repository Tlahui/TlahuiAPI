<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseModel extends CI_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        //Connect to database
        $this->load->database();
    }

    public function getInfo($id) {


        $this->db->select("id as idPurchase, pagoProcesado, referenciaPago as referencia, montoTotal, montoEnvio, idAddress, tipoPago");
        $result = $this->db->get_where("Purchase",array("id"=>$id))->row();

        //if ($result->idPurchase === null) return false;////
        $this->db->select("entreCalles");
        $idAdd= $result->idAddress;
        $address = $this->db->get_where("Address",array("id"=>$idAdd))->row();

        $purchase["idPurchase"]    = $result->idPurchase;
        $purchase["pagoProcesado"] = $result->pagoProcesado;
        $purchase["referencia"]    = $result->referencia;
        $purchase["montoTotal"] = $result->montoTotal;
        $purchase["montoEnvio"] = $result->montoEnvio;
        $purchase["entreCalles"] = $address->entreCalles;
        $purchase["idAdd"] = $idAdd;
        $purchase["tipoPago"] = $result->tipoPago;
        return $purchase;
    }

    // Funcion para cancelar una compra.
    public function cancel($id) {
        /*$data = array(
            "id" => $id,
            "solicitudCancelacion" => 1
        );*/
        $this->db->where("id", $id);
        $this->db->where("solicitudCancelacion", 1);
        $this->db->delete("Purchase");

        if($this->db->affected_rows() >1 ){
            return true;
        }
        else {
            return false;
        }
    }

    //funcion para solicitar una cancelación de compra
    public function cancelRequest($id) {
        $data = array(
            "solicitudCancelacion"=>1
        );

        $this->db->where("id", $id);
        $this->db->update("Purchase",$data);

        if ($this->db->affected_rows() >0) {
            return true;
        }
        else {
            return false;
        }

    }

}
