<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

	public function __construct(){
		parent::__construct();

		//Carga de los modelos
		$this->load->model('productos/pedido_model');

		//Configurando el data_header
		$this->data_header['titulo'] = 'Administración de pedidos';
		$this->data_header['seccion_menu'] = 'tienda_productos';
		// $this->data_header['menu']   = $this->load->view('menu',$this->dataMenu,true);

		if(!$this->session->userdata('conectado') || $this->session->userdata('usuario_tipo') != 1){
			redirect(base_url());
		}
	}

	public function index()
	{
		$tienda_id = $this->session->userdata('tienda_id');

		$cant_compras = $this->pedido_model->obtener_cant_compras($tienda_id);

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

		$this->load->view('template/panel_v1/header', $this->data_header);
		$this->load->view('productos/pedidos/pedidos');
		$this->load->view('template/panel_v1/footer');
	}

	public function pedido()
	{
		$codigo = $this->uri->segment(5);
		$this->data_header['pedido'] = $this->pedido_model->obtener($codigo);

		// echo '<pre>';
		// print_r($this->data_header['pedido']);
		// exit();

		if($this->input->is_ajax_request()){
			echo json_encode($this->data_header['pedido']);
		}
		else {
			$this->load->view('template/panel_v1/header', $this->data_header);
			$this->load->view('productos/pedidos/pedido');
			$this->load->view('template/panel_v1/footer');
		}
	}

	public function guardar()
	{
		if(!$this->input->post()){
			redirect(base_url().'admin/productos/pedidos');
			exit();
		}

		$pedido_id = $this->input->post('f_pedido_id');

		if($pedido_id)
		{
			$datos_pedido = array(
				'nombre'		=> $this->input->post('f_pedido_nombre'),
				'descripcion'	=> $this->input->post('f_pedido_descripcion'),
				
				'estado' 		=> 1,
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->pedido_model->modifica($datos_pedido, $pedido_id))
			{
				$this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				$this->session->set_userdata(array('alerta' => 33));
			}
		}else{
			$datos_pedido = array(
				'tienda_id'		=> $this->session->userdata('tienda_id'),

				'nombre'		=> $this->input->post('f_pedido_nombre'),
				'descripcion'	=> $this->input->post('f_pedido_descripcion'),

				'estado' 		=> 1,
				'creado'		=> date('Y-m-d H:i:s'),
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->pedido_model->alta_pedido($datos_pedido))
			{
				$this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				$this->session->set_userdata(array('alerta' => 33));
			}
		}

		if(!$this->input->is_ajax_request()){
			redirect(base_url().'admin/productos/pedidos');
		}
	}

	public function editar(){
		$pedido_id	= $this->uri->segment(4);

		$this->data_header['pedido'] = $this->pedido_model->obtener_pedido($pedido_id);

		if($this->data_header['pedido'])
		{
			// $this->data_header['js_pedidos'] = $this->load->view('pedidos/js_pedidos', $this->data_header, true);

			$this->load->view('template/panel_v1/header', $this->data_header);
			$this->load->view('pedidos/editar');
			$this->load->view('template/panel_v1/footer');
		}
		else{
			redirect(base_url().'admin/productos/pedidos');
		}
	}

	public function activar(){
		$pedido_id = $this->uri->segment(4);

		$datos_pedido = array(
			'estado' 		=> 1,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->pedido_model->modifica($datos_pedido, $pedido_id))
		{
			$this->session->set_userdata(array('alerta' => 4));
		}
		else
		{
			$this->session->set_userdata(array('alerta' => 44));
		}

		redirect(base_url().'admin/productos/pedidos');
	}

	public function eliminar(){
		$pedido_id = $this->uri->segment(4);

		$datos_pedido = array(
			'estado' 		=> 2,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->pedido_model->modifica($datos_pedido, $pedido_id))
		{
			$this->session->set_userdata(array('alerta' => 9));
		}
		else
		{
			$this->session->set_userdata(array('alerta' => 99));
		}

		redirect(base_url().'admin/productos/pedidos');
	}

	public function suspender(){
		$pedido_id = $this->uri->segment(4);

		$datos_pedido = array(
			'estado' 		=> 0,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->pedido_model->modifica($datos_pedido, $pedido_id))
		{
			$this->session->set_userdata(array('alerta' => 2));
		}
		else
		{
			$this->session->set_userdata(array('alerta' => 22));
		}

		redirect(base_url().'admin/productos/pedidos');
	}

	public function lista()
    {
    	$tienda_id = $this->session->userdata('tienda_id');

    	$this->datatables->add_column('icono', '<i class="fa fa-circle"></i>', 'icono');
		$this->datatables->select('tienda_stk_compras.id as id,
			tienda_stk_compras.cantidad as cantidad,
			tienda_stk_compras.total as total,
			0 as icono,
			tienda_stk_compras.codigo as codigo,
			tienda_stk_compras.estado as estado,
			tienda_stk_compras.creado as creado,
			DATE_FORMAT(tienda_stk_compras.creado, "%d/%m/%Y") as creado_formateado,
			TIME_FORMAT(tienda_stk_compras.creado, "%H:%i") as hora_formateado,

			CONCAT(tienda_usuarios.apellido, " ", tienda_usuarios.nombre) as cliente_nombre_completo,
			tienda_usuarios.apellido as cliente_apellido,
			tienda_usuarios.nombre as cliente_nombre');
		$this->datatables->from('tienda_stk_compras');

		$this->datatables->join('tienda_usuarios', 'tienda_usuarios.id = tienda_stk_compras.usuario_id');

		$this->datatables->where('tienda_stk_compras.tienda_id', $tienda_id);
		$this->datatables->where('tienda_stk_compras.estado', 1);
		$this->datatables->where('tienda_stk_compras.tipo_id', 1);

  		echo $this->datatables->generate();
	}

	public function lista_pedido_productos()
    {
    	$tienda_id = $this->session->userdata('tienda_id');
    	$compra_id = $this->input->post('f_compra_id'); 

    	$this->datatables->add_column('icono', '<i class="fa fa-circle"></i>', 'icono');
		$this->datatables->select('tienda_stk_compras_egreso.id as id,
			tienda_stk_compras_egreso.tienda_id as tienda_id,
			tienda_stk_compras_egreso.rowid as rowid,
			tienda_stk_compras_egreso.nombre as nombre,
			tienda_stk_compras_egreso.cantidad as cantidad,
			tienda_stk_compras_egreso.precio as precio,
			tienda_stk_compras_egreso.subtotal as subtotal,
			tienda_stk_compras_egreso.estado as estado');
		$this->datatables->from('tienda_stk_compras_egreso');
		$this->datatables->where('tienda_stk_compras_egreso.tienda_id', $tienda_id);
		$this->datatables->where('tienda_stk_compras_egreso.compra_id', $compra_id);
		$this->datatables->where('tienda_stk_compras_egreso.estado', 1);

  		echo $this->datatables->generate();
	}
}
