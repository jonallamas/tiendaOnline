<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	public function __construct(){
		parent::__construct();

		//Carga de los modelos
		$this->load->model('productos/producto_model');
		$this->load->model('productos/categoria_model');

		//Configurando el data_header
		$this->data_header['titulo'] = 'Administración de productos';
		$this->data_header['seccion_menu'] = 'tienda_productos';
		// $this->data_header['menu']   = $this->load->view('menu',$this->dataMenu,true);

		if(!$this->session->userdata('conectado') || $this->session->userdata('usuario_tipo') != 1){
			redirect(base_url());
		}
	}

	public function index()
	{
		// $this->data_header['js_productos']	= $this->load->view('productos/js_productos', $this->data_header, true);
		$this->data_header['categorias'] = $this->categoria_model->obtener_todos();

		$this->load->view('template/panel_v1/header', $this->data_header);
		$this->load->view('productos/productos');
		$this->load->view('template/panel_v1/footer');
	}

	// public function producto()
	// {
	// 	$producto_id = $this->uri->segment(3);
	// 	$this->data_header['producto'] = $this->producto_model->obtener($producto_id);

	// 	if($this->input->is_ajax_request()){
	// 		echo json_encode($this->data_header['producto']);
	// 	}
	// 	else {
	// 		$this->load->view('template/'.TEMPLATE.'/header', $this->data_header);
	// 		$this->load->view('productos/producto');
	// 		$this->load->view('template/'.TEMPLATE.'/footer');
	// 	}
	// }

	public function guardar()
	{
		if(!$this->input->post()){
			redirect(base_url().'admin/productos/productos');
			exit();
		}

		$codigo = $this->input->post('f_producto_codigo');

		if($codigo)
		{
			$datos_producto = array(
				'nombre'		=> $this->input->post('f_producto_nombre'),
				'categoria_id'	=> $this->input->post('f_producto_categoria_id'),
				'precio'		=> $this->input->post('f_producto_precio'),
				
				'estado' 		=> 1,
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->producto_model->modifica($datos_producto, $codigo))
			{
				$this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				$this->session->set_userdata(array('alerta' => 33));
			}
		}else{
			$datos_producto = array(
				'tienda_id'		=> $this->session->userdata('tienda_id'),

				'nombre'		=> $this->input->post('f_producto_nombre'),
				'categoria_id'	=> $this->input->post('f_producto_categoria_id'),
				'precio'		=> $this->input->post('f_producto_precio'),

				'estado' 		=> 1,
				'creado'		=> date('Y-m-d H:i:s'),
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->producto_model->alta($datos_producto))
			{
				$producto_id = $this->db->insert_id();
				$codigo = $this->generateRandomString(16, $producto_id).$producto_id;
				$datos_codigo = array(
					'codigo' 	=> $codigo
				);
				$this->producto_model->modifica($datos_codigo, $producto_id);

				// $this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				// $this->session->set_userdata(array('alerta' => 33));
			}
		}

		if(!$this->input->is_ajax_request()){
			redirect(base_url().'admin/productos/productos');
		}
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

	public function editar()
	{
		$codigo	= $this->uri->segment(5);

		$this->data_header['producto'] = $this->producto_model->obtener($codigo);
		$this->data_header['categorias'] = $this->categoria_model->obtener_todos();

		if($this->data_header['producto'])
		{
			// $this->data_header['js_productos'] = $this->load->view('productos/js_productos', $this->data_header, true);

			$this->load->view('template/panel_v1/header', $this->data_header);
			$this->load->view('productos/editar');
			$this->load->view('template/panel_v1/footer');
		}
		else{
			redirect(base_url().'admin/productos/productos');
		}
	}

	public function activar(){
		$codigo = $this->uri->segment(5);

		$datos_producto = array(
			'estado' 		=> 1,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->producto_model->modifica($datos_producto, $codigo))
		{
			// $this->session->set_userdata(array('alerta' => 4));
		}
		else
		{
			// $this->session->set_userdata(array('alerta' => 44));
		}

		redirect(base_url().'admin/productos/productos');
	}

	public function eliminar(){
		$codigo = $this->uri->segment(5);

		$datos_producto = array(
			'estado' 		=> 2,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->producto_model->modifica($datos_producto, $codigo))
		{
			// $this->session->set_userdata(array('alerta' => 9));
		}
		else
		{
			// $this->session->set_userdata(array('alerta' => 99));
		}

		redirect(base_url().'admin/productos/productos');
	}

	public function suspender(){
		$codigo = $this->uri->segment(5);

		$datos_producto = array(
			'estado' 		=> 0,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->producto_model->modifica($datos_producto, $codigo))
		{
			// $this->session->set_userdata(array('alerta' => 2));
		}
		else
		{
			// $this->session->set_userdata(array('alerta' => 22));
		}

		redirect(base_url().'admin/productos/productos');
	}

	public function lista()
	{
		$tienda_id = $this->session->userdata('tienda_id');

		$this->datatables->add_column('icono', '<i class="fa fa-circle"></i>', 'icono');
		$this->datatables->select('tienda_productos.id as id,
			tienda_productos.codigo as codigo,
			tienda_productos.nombre as nombre,
			tienda_productos.precio as precio,
			tienda_productos.categoria_id as categoria_id,
			tienda_productos_categoria.nombre as categoria_nombre,

			tienda_productos.creado as creado,
			DATE_FORMAT(tienda_productos.creado, "%d/%m/%Y") as creado_formateado,
			tienda_productos.estado as estado');
		$this->datatables->from('tienda_productos');
		$this->datatables->join('tienda_productos_categoria', 'tienda_productos_categoria.id = tienda_productos.categoria_id');
		$this->datatables->where('tienda_productos.tienda_id', $tienda_id);
		$this->datatables->where('tienda_productos.estado !=', 2);

  		echo $this->datatables->generate();
	}
}
