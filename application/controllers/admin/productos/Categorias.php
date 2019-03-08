<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

	public function __construct(){
		parent::__construct();

		//Carga de los modelos
		$this->load->model('productos/categoria_model');

		//Configurando el data_header
		$this->data_header['titulo'] = 'Administración de categorias';
		$this->data_header['seccion_menu'] = 'tienda_productos';
		// $this->data_header['menu']   = $this->load->view('menu',$this->dataMenu,true);

		if(!$this->session->userdata('conectado') || $this->session->userdata('usuario_tipo') != 1){
			redirect(base_url());
		}
	}

	public function index()
	{
		// $this->data_header['js_categorias']	= $this->load->view('categorias/js_categorias', $this->data_header, true);
		$this->data_header['categorias'] = $this->categoria_model->obtener_todos();

		$this->load->view('template/panel_v1/header', $this->data_header);
		$this->load->view('productos/categorias/categorias');
		$this->load->view('template/panel_v1/footer');
	}

	// public function categoria()
	// {
	// 	$categoria_id = $this->uri->segment(4);
	// 	$this->data_header['categoria'] = $this->categoria_model->obtener_categoria($categoria_id);

	// 	if($this->input->is_ajax_request()){
	// 		echo json_encode($this->data_header['categoria']);
	// 	}
	// 	else {
	// 		$this->load->view('template/'.TEMPLATE.'/header', $this->data_header);
	// 		$this->load->view('categorias/categoria');
	// 		$this->load->view('template/'.TEMPLATE.'/footer');
	// 	}
	// }

	public function guardar()
	{
		if(!$this->input->post()){
			redirect(base_url().'admin/productos/categorias');
			exit();
		}

		$categoria_id = $this->input->post('f_categoria_id');

		if($categoria_id)
		{
			$datos_categoria = array(
				'nombre'		=> $this->input->post('f_categoria_nombre'),
				'descripcion'	=> $this->input->post('f_categoria_descripcion'),
				
				'estado' 		=> 1,
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->categoria_model->modifica($datos_categoria, $categoria_id))
			{
				$this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				$this->session->set_userdata(array('alerta' => 33));
			}
		}else{
			$datos_categoria = array(
				'tienda_id'		=> $this->session->userdata('tienda_id'),

				'nombre'		=> $this->input->post('f_categoria_nombre'),
				'descripcion'	=> $this->input->post('f_categoria_descripcion'),

				'estado' 		=> 1,
				'creado'		=> date('Y-m-d H:i:s'),
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->categoria_model->alta($datos_categoria))
			{
				$categoria_id = $this->db->insert_id();
				$codigo = $this->generateRandomString(16, $categoria_id).$categoria_id;
				$datos_codigo = array(
					'codigo' 	=> $codigo
				);
				$this->categoria_model->modifica($datos_codigo, $categoria_id);
				// $this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				// $this->session->set_userdata(array('alerta' => 33));
			}
		}

		if(!$this->input->is_ajax_request()){
			redirect(base_url().'admin/productos/categorias');
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

	public function editar(){
		$categoria_id	= $this->uri->segment(4);

		$this->data_header['categoria'] = $this->categoria_model->obtener($categoria_id);

		if($this->data_header['categoria'])
		{
			// $this->data_header['js_categorias'] = $this->load->view('categorias/js_categorias', $this->data_header, true);

			$this->load->view('template/panel_v1/header', $this->data_header);
			$this->load->view('categorias/editar');
			$this->load->view('template/panel_v1/footer');
		}
		else{
			redirect(base_url().'admin/productos/categorias');
		}
	}

	public function activar(){
		$categoria_id = $this->uri->segment(4);

		$datos_categoria = array(
			'estado' 		=> 1,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->categoria_model->modifica($datos_categoria, $categoria_id))
		{
			// $this->session->set_userdata(array('alerta' => 4));
		}
		else
		{
			// $this->session->set_userdata(array('alerta' => 44));
		}

		redirect(base_url().'admin/productos/categorias');
	}

	public function eliminar(){
		$categoria_id = $this->uri->segment(4);

		$datos_categoria = array(
			'estado' 		=> 2,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->categoria_model->modifica($datos_categoria, $categoria_id))
		{
			// $this->session->set_userdata(array('alerta' => 9));
		}
		else
		{
			// $this->session->set_userdata(array('alerta' => 99));
		}

		redirect(base_url().'admin/productos/categorias');
	}

	public function suspender(){
		$categoria_id = $this->uri->segment(4);

		$datos_categoria = array(
			'estado' 		=> 0,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->categoria_model->modifica($datos_categoria, $categoria_id))
		{
			// $this->session->set_userdata(array('alerta' => 2));
		}
		else
		{
			// $this->session->set_userdata(array('alerta' => 22));
		}

		redirect(base_url().'admin/productos/categorias');
	}

	public function lista()
	{
		$tienda_id = $this->session->userdata('tienda_id');

		$this->datatables->add_column('icono', '<i class="fa fa-circle"></i>', 'icono');
		$this->datatables->select('tienda_productos_categoria.id as id,
			tienda_productos_categoria.nombre as nombre,
			
			COUNT(tienda_productos.id) as cant_productos,

			tienda_productos_categoria.creado as creado,
			DATE_FORMAT(tienda_productos_categoria.creado, "%d/%m/%Y") as creado_formateado,
			tienda_productos_categoria.estado as estado');
		$this->datatables->from('tienda_productos_categoria');
		$this->datatables->join('tienda_productos', 'tienda_productos.categoria_id = tienda_productos_categoria.id', 'left');
		$this->datatables->where('tienda_productos_categoria.tienda_id', $tienda_id);
		$this->datatables->where('tienda_productos_categoria.estado !=', 2);
		$this->datatables->group_by('tienda_productos_categoria.id');

  		echo $this->datatables->generate();
	}
}
