<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductController extends CI_Controller {

    /**
     * Controlador definido para interactuar con productos
     *
     * Se encuentra compuesto de las siguientes rutas:
     * 		/product
     *      /product/add
     *      /product/edit
     *      /product/delete
     *      /product/get/:id
     *      /product/featured
     *      /product/category/:id
     *      /product/like
     *      /product/unlike
     *
     * El modelo definido por defecto para interactuar con la BD es ModelProduct.
     * Si se requiere el uso de metodos adicionales declararlos hasta abajo
     *
     */

    function __construct(){
        parent::__construct();
        $this->load->model('ProductModel');
    }

    public function listar(){
        $this->load->model('CategoryModel');
        $this->load->model('ProductImageModel');
        $productos = $this->ProductModel->ProductList();
        $i=0;
        foreach($productos as $producto){
            $imagenes = $this->ProductImageModel->ImageListFromProduct($producto['id']);
            $categorias = $this->CategoryModel->CategoryFromProduct($producto['id']);
            $productos[$i]['imagenes']=$imagenes;
            $productos[$i]['categorias']=$categorias;
            $i++;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode( $productos ));
    }

    public function readInputJson(){
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $jsonError = json_last_error();
            if ($jsonError == JSON_ERROR_DEPTH){
                throw new Exception(" - Excedido tamaño máximo de la pila", $jsonError);
            } elseif ($jsonError == JSON_ERROR_STATE_MISMATCH){
                throw new Exception(" - Desbordamiento de buffer o los modos no coinciden", $jsonError);
            } elseif ($jsonError == JSON_ERROR_CTRL_CHAR){
                throw new Exception(" - Encontrado carácter de control no esperado", $jsonError);
            } elseif ($jsonError == JSON_ERROR_SYNTAX){
                throw new Exception(" - Error de sintaxis, JSON mal formado", $jsonError);
            } elseif ($jsonError == JSON_ERROR_UTF8){
                throw new Exception(" - Caracteres UTF-8 malformados, posiblemente están mal codificados", $jsonError);
            } elseif ($jsonError != JSON_ERROR_NONE){
                throw new Exception(" - Error desconocido", $jsonError);
            }
            return $data;
        } catch (Exception $e) {
            $response[ "responseStatus" ] = "FAIL";
            $response[ "message" ]        = "Error en el json: ".$e->getMessage();
            $this->output->set_content_type('application/json')->set_output(json_encode( $response ));
            return Null;
        }

    }

    public function add(){
        /******************************************
        *
        *  Alta de Productos
        *
        ******************************************/
        // leer json de entrada
        $data = self::readInputJson();
        // validar que no venga vacio
        if (!empty($data)){
            try {

                // Validaciones de que los campos no vengan vacios
                if (!array_key_exists('nombre', $data)              or empty($data['nombre']) )
                    throw new Exception(" - missing nombre", 1);
                if (!array_key_exists('precio', $data)              or empty($data['precio']))
                    throw new Exception(" - missing precio", 2);
                if (!array_key_exists('oferta', $data)              or is_null($data['oferta']))
                    throw new Exception(" - missing oferta", 3);
                if (!array_key_exists('descripcion', $data)         or empty($data['descripcion']))
                    throw new Exception(" - missing descripcion", 4);
                if (!array_key_exists('productor', $data)           or empty($data['productor']))
                    throw new Exception(" - missing productor", 5);
                if (!array_key_exists('idProductCategory', $data)   or empty($data['idProductCategory']))
                    throw new Exception(" - missing idCategory", 6);
                if (!array_key_exists('talla', $data)               or empty($data['talla']))
                    throw new Exception(" - missing talla", 7);
                

                $newProduct [ "nombre" ]             = $data [ "nombre" ];
                $newProduct [ "precio" ]             = $data [ "precio" ];
                $newProduct [ "oferta" ]             = $data [ "oferta" ];
                $newProduct [ "descripcion" ]        = $data [ "descripcion" ];
                $newProduct [ "productor" ]          = $data [ "productor" ];
                $newProductCategory [ "idCategory" ] = $data [ "idProductCategory" ];
                $tallas                              = $data [ "talla" ];

            } catch (Exception $e) {
                $response[ "responseStatus" ] = "FAIL";
                $response[ "message" ]        = "Error en el json: ".$e->getMessage();
                $this->output->set_content_type('application/json')->set_output(json_encode( $response ));
                return;
            }

            try {
                // Agregar el producto
                $this->load->model("productModel");
                $productID = $this->productModel->productInsert($newProduct);

                // Agregar la Categoria
                $this->load->model("productCategoryModel");
                $newProductCategory [ "idProduct" ]    = $productID;
                $this->productCategoryModel->productCategoryInsert($newProductCategory);

                // Agregar Tallas
                $this->load->model("productSizeModel");
                foreach ($tallas as $talla) {
                    $talla ["idProduct"] = $productID;
                    $this->productSizeModel->productSizeInsert($talla);
                }
            } catch (Exception $e) {
                $response[ "responseStatus" ] = "FAIL";
                $response[ "message" ]        = "Producto no pudo ser insertado: ".$e->getMessage();
                $this->output->set_content_type('application/json')->set_output(json_encode( $response ));
                return;
            }

            $response[ "responseStatus" ] = "OK";
            $response[ "message" ]        = "Producto insertado correctamente";
            $response[ "data" ]           = array('id' => $productID);
            $this->output->set_content_type('application/json')->set_output(json_encode( $response ));
        }
        return;
    }

    public function edit(){

    }

    public function delete(){
        /******************************************
        *
        *  Borrar Productos
        *
        ******************************************/
        // leer json de entrada
        $data = self::readInputJson();
        // validar que no venga vacio
        if (!empty($data)){
            try {

                // Validaciones de que los campos no vengan vacios
                if (!array_key_exists('id', $data)              or empty($data['id']) )
                    throw new Exception(" - missing id", 1);
                $productID = $data [ "id" ];
            } catch (Exception $e) {
                $response[ "responseStatus" ] = "FAIL";
                $response[ "message" ]        = "Error en el json: ".$e->getMessage();
                $this->output->set_content_type('application/json')->set_output(json_encode( $response ));
                return;
            }

            try {
                // Borrar el producto
                $this->load->model("productModel");

                if (!$this->productModel->productExist($productID))
                    throw new Exception(" - Product not found", 1);
                $this->productModel->productDelete($productID);
                // Borrar el product size
                $this->load->model("productSizeModel");
                $this->productSizeModel->productSizeDelete($productID);
                // Borrar el product Category
                $this->load->model("productCategoryModel");
                $this->productCategoryModel->productCategoryDelete($productID);

            } catch (Exception $e) {
                $response[ "responseStatus" ] = "FAIL";
                $response[ "message" ]        = "Producto no pudo ser eliminado: ".$e->getMessage();
                $this->output->set_content_type('application/json')->set_output(json_encode( $response ));
                return;
            }

            $response[ "responseStatus" ] = "OK";
            $response[ "message" ]        = "Producto eliminado correctamente";
            $this->output->set_content_type('application/json')->set_output(json_encode( $response ));
        }
        return;
    }

    public function get($id){

    }

    public function featured(){
        /************************
        *
        *  Get Featured Products
        *
        *************************/
        $this->load->model('CategoryModel');
        $this->load->model('ProductImageModel');
        $productos = $this->ProductModel->ProductListFeatured();
        $i=0;
        foreach($productos as $producto){
            $imagenes = $this->ProductImageModel->ImageListFromProduct($producto['id']);
            $categorias = $this->CategoryModel->CategoryFromProduct($producto['id']);
            $productos[$i]['imagenes']=$imagenes;
            $productos[$i]['categorias']=$categorias;
            $i++;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode( $productos ));

    }

    public function category($idCategory){

    }

    public function like(){

    }

    public function unlike(){

    }
    
    
    
	// Pide un idProducto... y regresa las tallas disponibles para dicho producto
	public function size()
	{
		$response["responseStatus"] = "Not OK";
		
		// Obtenemos el id del producto 
		$idProduct = $this->input->get("idProduct");
		
		// load model
		$this->load->model("productmodel");

		$productSize = $this->productmodel->getProductSize( $idProduct );
		
		if(false !== $productSize)
		{
			$response["responseStatus"] = "OK";
			$response["sizes"] = $productSize;
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));
			
	}
	
	
	
	// Actualizamos la cantidad de productos disponibles, pasándole el ID de la combinación
	// de producto y talla (size)
	public function updateSizeById()
	{
		$response["responseStatus"] = "FAIL";
		$response["message"] = "Cantidad no pudo ser modificada";
		
		// Obtenemos el id del producto 
		$id = $this->input->post("id");
		$cantidad = $this->input->post("cantidad");
		
		// load model
		$this->load->model("productmodel");

		$productSize = $this->productmodel->updateSizeById( $id, $cantidad );
		
		if(false !== $productSize)
		{
			$response["responseStatus"] = "OK";
			$response["message"] = "Cantidad modificada correctamente";
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));
			
	}
	




	// Adicionamos una nueva combinación de producto y talla, así como su existencia
	public function sizeAdd()
	{
		$response["responseStatus"] = "FAIL";
		$response["message"] = "Talla no pudo ser insertada";
		
		// Obtenemos el id del producto 
		$idProduct = $this->input->post("idProduct");
		$idSize = $this->input->post("idSize");
		$cantidad = $this->input->post("cantidad");
		
		// load model
		$this->load->model("productmodel");

		$resultado = $this->productmodel->sizeAdd( $idProduct, $idSize, $cantidad );
		
		
		if(false !== $resultado)
		{
			$response["responseStatus"] = "OK";
			$response["message"] = "Talla insertada correctamente";
			$response["data"] = $resultado;
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));
			
	}
	


	// Eliminamos una combinación de producto y talla, así como su existencia
	public function sizeDelete()
	{
		$response["responseStatus"] = "FAIL";
		$response["message"] = "Talla no pudo ser eliminado para el producto";
		
		// Obtenemos el id del producto 
		$idProduct = $this->input->post("idProduct");
		// Si pasan idSize lo tomamos, si no le asignamos 0 que significará TODOS en código
		$idSize = $this->input->post("idSize");
		$idSize = ( trim( $idSize ) == "" ? 0 : $idSize );

		// load model
		$this->load->model("productmodel");

		$resultado = $this->productmodel->sizeDelete( $idProduct, $idSize );
		
		
		if(0 !== $resultado)
		{
			$response["responseStatus"] = "OK";
			$response["message"] = "Talla eliminada correctamente para el producto";
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode( $response ));
			
	}
    

}

/* End of file welcome.php */
/* Location: ./application/controllers/productController.php */
