<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class productos extends CI_Controller {

	public function __construct(){
		parent::__construct();

		//Carga de los modelos
		$this->load->model('productos_model');

		//Configurando el data_header
		$this->data_header['titulo'] = 'Administración de productos';
		$this->data_header['seccion_menu'] = 'tienda_productos';
		// $this->data_header['menu']   = $this->load->view('menu',$this->dataMenu,true);

		if(!$this->session->userdata('conectado')){
			redirect(base_url().'panel');
		}
	}

	public function index()
	{
		// $this->data_header['js_productos']	= $this->load->view('productos/js_productos', $this->data_header, true);
		$this->data_header['categorias'] = $this->productos_model->obtener_todos_categorias();

		$this->load->view('template/panel_v1/header', $this->data_header);
		$this->load->view('productos/productos');
		$this->load->view('template/panel_v1/footer');
	}

	// public function producto()
	// {
	// 	$producto_id = $this->uri->segment(4);
	// 	$this->data_header['producto'] = $this->productos_model->obtener($producto_id);

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
		$producto_id = $this->input->post('f_producto_id');

		if($producto_id)
		{
			$datos_producto = array(
				'nombre'		=> $this->input->post('f_nombre'),
				
				'estado' 		=> 1,
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->productos_model->modifica($datos_producto, $producto_id))
			{
				$this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				$this->session->set_userdata(array('alerta' => 33));
			}
		}else{
			$datos_producto = array(
				'nombre'		=> $this->input->post('f_nombre'),

				'estado' 		=> 1,
				'creado'		=> date('Y-m-d H:i:s'),
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->productos_model->alta($datos_producto))
			{
				$this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				$this->session->set_userdata(array('alerta' => 33));
			}
		}

		if(!$this->input->is_ajax_request()){
			redirect(base_url().'productos');
		}
	}

	public function editar(){
		$producto_id	= $this->uri->segment(4);

		$this->data_header['producto'] = $this->productos_model->obtener($producto_id);

		if($this->data_header['producto'])
		{
			// $this->data_header['js_productos'] = $this->load->view('productos/js_productos', $this->data_header, true);

			$this->load->view('template/panel_v1/header', $this->data_header);
			$this->load->view('productos/editar');
			$this->load->view('template/panel_v1/footer');
		}
		else{
			redirect(base_url().'productos');
		}
	}

	public function activar(){
		$producto_id = $this->uri->segment(4);

		$datos_producto = array(
			'estado' 		=> 1,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->productos_model->modifica($datos_producto, $producto_id))
		{
			$this->session->set_userdata(array('alerta' => 4));
		}
		else
		{
			$this->session->set_userdata(array('alerta' => 44));
		}

		redirect(base_url().'productos');
	}

	public function eliminar(){
		$producto_id = $this->uri->segment(4);

		$datos_producto = array(
			'estado' 		=> 2,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->productos_model->modifica($datos_producto, $producto_id))
		{
			$this->session->set_userdata(array('alerta' => 9));
		}
		else
		{
			$this->session->set_userdata(array('alerta' => 99));
		}

		redirect(base_url().'productos');
	}

	public function suspender(){
		$producto_id = $this->uri->segment(4);

		$datos_producto = array(
			'estado' 		=> 0,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->productos_model->modifica($datos_producto, $producto_id))
		{
			$this->session->set_userdata(array('alerta' => 2));
		}
		else
		{
			$this->session->set_userdata(array('alerta' => 22));
		}

		redirect(base_url().'productos');
	}

	public function lista()
	{
		$this->datatables->add_column('icono', '<i class="fa fa-circle"></i>', 'icono');
		$this->datatables->select('tienda_productos.id as id,
			tienda_productos.nombre as nombre,
			tienda_productos.precio as precio,
			tienda_productos.categoria_id as categoria_id,
			
			tienda_productos_categoria.nombre as categoria_nombre,

			tienda_productos.creado as creado,
			DATE_FORMAT(tienda_productos.creado, "%d/%m/%Y") as creado_formateado,
			tienda_productos.estado as estado');
		$this->datatables->from('tienda_productos');
		$this->datatables->join('tienda_productos_categoria', 'tienda_productos_categoria.id = tienda_productos.categoria_id');
		$this->datatables->where('tienda_productos.estado !=', 2);

  		echo $this->datatables->generate();
	}
}
