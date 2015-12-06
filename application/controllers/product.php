<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function getAll()
	{
		$response["responseStatus"] = "Not OK";

		// load model
		$this->load->model("productmodel");

		$response["products"] = $this->productmodel->getAll();
		$response["responseStatus"] = "OK";

		echo json_encode($response);
	}

	public function getAvailability()
	{
		$response["responseStatus"] = "Product not found";

		$productID = $this->input->post("idProduct");

		$this->load->model("productmodel");

		$productAvailability = $this->productmodel->getAvailability($productID);

		if(false !== $productAvailability)
		{
			$response["responseStatus"] = "OK";
			$response["availability"] = true;
			$response["qty"] = $productAvailability->qty;
		}

		echo json_encode($response);
	}

    public function UploadProductImage(){
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '100';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';

        $this->load->model("productmodel");
        $this->load->helper(array('url'));
        $this->load->library('upload', $config);

        $response["responseStatus"] = "Error";
        $productID = $this->input->post("idProduct");
        $urlImage = "/Testurl.jpg";

        $product = $this->productmodel->getAvailability($productID);

        if($product){
            if (!$this->upload->do_upload()){
                $response["message"] = array('error' => $this->stripHTMLtags($this->upload->display_errors()));
            }
            else{
                $dataImage = array('upload_data' => $this->upload->data());
                $addProductImage = $this->productmodel->AddProductImage($productID);
                if($addProductImage){
                    $response["responseStatus"] = "OK";
                    $response["urlImage"] = $dataImage["upload_data"]["file_name"];
                    $response["IDImage"] = $addProductImage;
                }else{
                    $response["message"] = "Insert Error";
                }
            }
        }else{
            $response["message"] = "Product not Exists";
        }
        echo json_encode($response);
    }

    private function stripHTMLtags($str)
    {
        $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
        $t = htmlentities($t, ENT_QUOTES, "UTF-8");
        return $t;
    }

}

/* End of file product.php */
/* Location: ./application/controllers/product.php */