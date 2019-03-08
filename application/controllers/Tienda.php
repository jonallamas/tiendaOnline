<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tienda extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('cart');

		// Carga de los modelos
		$this->load->model('carrito_model');
		$this->load->model('cliente_model');
	}

	public function index()
	{
		/*
			Estados para las compras:
				- Cancelado (menor)
				- Eliminado 

				- En espera
				- Procesado
				- Enviado
				- Entregado (mayor)
		*/
		if($this->session->userdata('conectado')){
			$tienda_id = $this->session->userdata('tienda_id');
			$usuario_id = $this->session->userdata('usuario_id');

			$cant_compras = $this->carrito_model->obtener_cant_compras($tienda_id, $usuario_id);

			$compras = 0;
			foreach ($cant_compras as $cant_compra) {
				$compras++;
			}

			$productos = 0;
			foreach ($cant_compras as $cant_compra) {
				$productos = $productos + $cant_compra->cantidad;
			}

			$gastos = 0;
			foreach ($cant_compras as $cant_compra) {
				$gastos = $gastos + $cant_compra->total;
			}

			$this->data_header['cant_compras'] = $compras;
			$this->data_header['cant_productos'] = $productos;
			$this->data_header['cant_gasto'] = $gastos;

			$this->load->view('template/web_v1/header', $this->data_header);
			$this->load->view('template/web_v1/tienda/mi_tienda');
			$this->load->view('template/web_v1/footer');
		}else{
			redirect(base_url());
		}

	}

	public function carrito()
	{
		if($this->session->userdata('conectado')){
			$usuario_id = $this->session->userdata('usuario_id');
			$this->data_header['configuracion'] = $this->cliente_model->obtener_direcciones($usuario_id);
			$this->load->view('template/web_v1/header', $this->data_header);
		}else{
			$this->load->view('template/web_v1/header');
		}
		$this->load->view('template/web_v1/tienda/carrito');
		$this->load->view('template/web_v1/footer');
	}

	public function configuracion()
	{
		if($this->session->userdata('conectado')){
			$usuario_id = $this->session->userdata('usuario_id');
			$this->data_header['configuracion'] = $this->cliente_model->obtener_direcciones($usuario_id);

			$this->load->view('template/web_v1/header', $this->data_header);
			$this->load->view('template/web_v1/tienda/configuracion');
			$this->load->view('template/web_v1/footer');
		}else{
			redirect(base_url());
		}
	}

	public function guardar_configuracion()
	{
		if($this->session->userdata('conectado')){
			$configuracion_id = $this->input->post('f_config_id');

			if($configuracion_id){
				$data = array(
					'calle_nombre' 	=> $this->input->post('f_config_calle_nombre'),
					'calle_numero' 	=> $this->input->post('f_config_calle_numero'),
					'codigo_postal' => $this->input->post('f_config_cp'),
					'piso' 			=> $this->input->post('f_config_piso'),
					'departamento' 	=> $this->input->post('f_config_departamento'),

					'actualizado' 	=> date('Y-m-d H:i')
				);

				if($this->cliente_model->modifica_direccion($data, $configuracion_id)){
					// Enviar alerta se modificó con éxito
				}else{
					// Enviar alerta no se pudo modificar
				}
			}else{
				// No viajó la configuracion_id - Mostrar alerta error
			}

			redirect(base_url().'tienda/configuracion');
		}else{
			redirect(base_url());
		}

	}

	public function salir()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

	// Funciones para carrito de compras
	public function producto_agregar()
	{
		$producto_id 		= $this->input->post('producto_id');
		$producto_cantidad 	= $this->input->post('producto_cantidad');
		$producto_precio 	= $this->input->post('producto_precio');
		$producto_nombre 	= $this->input->post('producto_nombre');

		$data = array(
			'id' 	=> $producto_id,
			'qty' 	=> $producto_cantidad,
			'price' => $producto_precio,
			'name' 	=> $producto_nombre
		);

		$rowid = $this->cart->insert($data);

		$cantidad = 0;
		foreach ($this->cart->contents() as $producto) {
			$cantidad += $producto['qty'];
		}

		$info = array(
			'carrito_cant' 		=> $cantidad,
			'producto_cantidad' => $producto_cantidad,
			'producto_nombre' 	=> $producto_nombre
		);

		echo json_encode($info);
	}

    public function producto_eliminar()
    {
		$producto_nombre 	= '';
    	$producto_id 		= '';
        $rowid = $this->input->post('row_id');

        foreach ($this->cart->contents() as $producto) {
            if($producto['rowid'] == $rowid){
                $producto_nombre 	= $producto['name'];
                $producto_id 		= $producto['id'];
            }
        }

        $this->cart->remove($rowid);

        $cantidad = 0;
        foreach ($this->cart->contents() as $producto) {
            $cantidad += $producto['qty'];
        }

        $retorno = array(
            'carrito_cant' 		=> $cantidad,
            'producto_nombre' 	=> $producto_nombre, 
            'producto_id' 		=> $producto_id
        );

        echo json_encode($retorno);
    }

    public function encargar()
    {
    	if($this->session->userdata('conectado')){
	    	// Guardado de la compra
	    	$cant_productos = 0;
	    	$cant_total = 0;


	    	if(count($this->cart->contents()) > 0){
		    	foreach ($this->cart->contents() as $producto) {
		    		$cant_productos = $cant_productos + $producto['qty'];
					$cant_total = $cant_total + $producto['subtotal'];    		
		    	}

		    	$compra = array(
		    		'tienda_id' 	=> $this->session->userdata('tienda_id'),
		    		'usuario_id' 	=> $this->session->userdata('usuario_id'),
		    		'cantidad' 		=> $cant_productos,
		    		'total' 		=> $cant_total,
		    		'tipo_id' 		=> 1,

		    		'estado' 		=> 1,
					'creado' 		=> date('Y-m-d H:i:s'),
					'actualizado' 	=> date('Y-m-d H:i:s')
		    	);

		    	$this->carrito_model->alta_compra($compra);
		    	$compra_id = $this->db->insert_id();

		    	$codigo = $this->generateRandomString(16, $compra_id).$compra_id;
				$datos_codigo = array(
					'codigo' 	=> $codigo
				);
				$this->carrito_model->modifica_compra($datos_codigo, $compra_id);

		    	// Guardado de items
		    	foreach ($this->cart->contents() as $producto) {
		    		$data = array(
						'tienda_id' 	=> $this->session->userdata('tienda_id'),

						'compra_id' 	=> $compra_id,
						'usuario_id' 	=> $this->session->userdata('usuario_id'),
						'rowid' 		=> $producto['rowid'],
						'nombre' 		=> $producto['name'],
						'producto_id' 	=> $producto['id'],
						'cantidad' 		=> $producto['qty'],
						'precio' 		=> $producto['price'],
						'subtotal' 		=> $producto['subtotal'],

						'estado' 		=> 1,
						'creado' 		=> date('Y-m-d H:i:s'),
						'actualizado' 	=> date('Y-m-d H:i:s')
		    		);

		    		$this->carrito_model->alta($data);
		    	}

	    		$data = array(
	    			'error' => 0,
	    			'error_texto' => NULL
	    		);

	    		$this->cart->destroy();
	    		redirect(base_url().'tienda');
	    		exit();
	    	}else{
	    		$data = array(
	    			'error' => 1,
	    			'error_texto' => 'No se pudo realizar la operación'
	    		);

		    	redirect(base_url());
	    	}
    	}else{
    		redirect(base_url().'carrito');
    	}

    	// echo json_encode($data);
    }

    public function generateRandomString($length, $id)
	{
		$id = strlen($id);
	    $characters = '1A2B3C4D5E6F7G8H9I0J1K2L3M4N5O6P7Q8R9S0T1U2V3W4X5Y6Z7';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < ($length - $id); $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

    public function lista_mis_compras()
    {
    	$tienda_id = $this->session->userdata('tienda_id');
    	$usuario_id = $this->session->userdata('usuario_id');

		$this->datatables->select('tienda_stk_compras.id as id,
			tienda_stk_compras.cantidad as cantidad,
			tienda_stk_compras.total as total,

			tienda_stk_compras.estado as estado,
			DATE_FORMAT(tienda_stk_compras.creado, "%d/%m/%Y") as creado_formateado,
			TIME_FORMAT(tienda_stk_compras.creado, "%H:%i") as hora_formateado');
		$this->datatables->from('tienda_stk_compras');
		$this->datatables->where('tienda_stk_compras.tienda_id', $tienda_id);
		$this->datatables->where('tienda_stk_compras.usuario_id', $usuario_id);
		$this->datatables->where('tienda_stk_compras.estado', 1);
		$this->datatables->where('tienda_stk_compras.tipo_id', 1);

  		echo $this->datatables->generate();
	}

}