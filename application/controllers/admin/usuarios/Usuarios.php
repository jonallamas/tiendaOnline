<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct(){
		parent::__construct();

		//Carga de los modelos
		$this->load->model('usuario_model');

		//Configurando el data_header
		$this->data_header['titulo'] = 'Administración de usuarios';
		$this->data_header['seccion_menu'] = 'tienda_usuarios';
		// $this->data_header['menu']   = $this->load->view('menu',$this->dataMenu,true);

		if(!$this->session->userdata('conectado') || $this->session->userdata('usuario_tipo') != 1){
			redirect(base_url());
		}
	}

	public function index()
	{
		// $this->data_header['js_usuarios']	= $this->load->view('usuarios/js_usuarios', $this->data_header, true);
		// $this->data_header['categorias'] = $this->usuario_model->obtener_todos_categorias();

		$this->load->view('template/panel_v1/header', $this->data_header);
		$this->load->view('usuarios/usuarios');
		$this->load->view('template/panel_v1/footer');
	}

	// public function usuario()
	// {
	// 	$usuario_id = $this->uri->segment(3);
	// 	$this->data_header['usuario'] = $this->usuario_model->obtener($usuario_id);

	// 	if($this->input->is_ajax_request()){
	// 		echo json_encode($this->data_header['usuario']);
	// 	}
	// 	else {
	// 		$this->load->view('template/'.TEMPLATE.'/header', $this->data_header);
	// 		$this->load->view('usuarios/usuario');
	// 		$this->load->view('template/'.TEMPLATE.'/footer');
	// 	}
	// }

	public function guardar()
	{
		if(!$this->input->post()){
			redirect(base_url().'admin/usuarios/usuarios');
			exit();
		}

		$codigo = $this->input->post('f_usuario_codigo');
		
		if($codigo)
		{
			$datos_usuario = array(
				'apellido'		=> $this->input->post('f_usuario_apellido'),
				'nombre'		=> $this->input->post('f_usuario_nombre'),
				'telefono'		=> $this->input->post('f_usuario_telefono'),
				'correo'		=> $this->input->post('f_usuario_correo'),

				'log_correo'	=> $this->input->post('f_usuario_correo'),
				'log_pass'		=> md5($this->input->post('f_usuario_pass')),
				
				'validado'		=> 0,
				'keymaster'		=> NULL,
				'tipo_id'		=> $this->input->post('f_usuario_categoria_id'),
				
				'estado' 		=> 1,
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->usuario_model->modifica($datos_usuario, $codigo))
			{
				$this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				$this->session->set_userdata(array('alerta' => 33));
			}
		}else{
			$datos_usuario = array(
				'tienda_id'		=> $this->session->userdata('tienda_id'),

				'apellido'		=> $this->input->post('f_usuario_apellido'),
				'nombre'		=> $this->input->post('f_usuario_nombre'),
				'telefono'		=> $this->input->post('f_usuario_telefono'),
				'correo'		=> $this->input->post('f_usuario_correo'),

				'log_correo'	=> $this->input->post('f_usuario_correo'),
				'log_pass'		=> md5($this->input->post('f_usuario_pass')),
				
				'validado'		=> 0,
				'keymaster'		=> NULL,
				'tipo_id'		=> $this->input->post('f_usuario_categoria_id'),

				'estado' 		=> 1,
				'creado'		=> date('Y-m-d H:i:s'),
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			if($this->usuario_model->alta($datos_usuario))
			{
				// $usuario_id = $this->db->insert_id();
				// $codigo = $this->generateRandomString(16, $usuario_id).$usuario_id;
				// $datos_codigo = array(
				// 	'codigo' 	=> $codigo
				// );
				// $this->usuario_model->modifica($datos_codigo, $usuario_id);

				// $this->session->set_userdata(array('alerta' => 3));
			}
			else
			{
				// $this->session->set_userdata(array('alerta' => 33));
			}
		}

		if(!$this->input->is_ajax_request()){
			redirect(base_url().'admin/usuarios/usuarios');
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

		$this->data_header['usuario'] = $this->usuario_model->obtener($codigo);
		$this->data_header['categorias'] = $this->usuario_model->obtener_todos_categorias();

		if($this->data_header['usuario'])
		{
			// $this->data_header['js_usuarios'] = $this->load->view('usuarios/js_usuarios', $this->data_header, true);

			$this->load->view('template/panel_v1/header', $this->data_header);
			$this->load->view('usuarios/editar');
			$this->load->view('template/panel_v1/footer');
		}
		else{
			redirect(base_url().'admin/usuarios/usuarios');
		}
	}

	public function activar(){
		$codigo = $this->uri->segment(5);

		$datos_usuario = array(
			'estado' 		=> 1,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->usuario_model->modifica($datos_usuario, $codigo))
		{
			// $this->session->set_userdata(array('alerta' => 4));
		}
		else
		{
			// $this->session->set_userdata(array('alerta' => 44));
		}

		redirect(base_url().'admin/usuarios/usuarios');
	}

	public function eliminar(){
		$codigo = $this->uri->segment(5);

		$datos_usuario = array(
			'estado' 		=> 2,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->usuario_model->modifica($datos_usuario, $codigo))
		{
			// $this->session->set_userdata(array('alerta' => 9));
		}
		else
		{
			// $this->session->set_userdata(array('alerta' => 99));
		}

		redirect(base_url().'admin/usuarios/usuarios');
	}

	public function suspender(){
		$codigo = $this->uri->segment(5);

		$datos_usuario = array(
			'estado' 		=> 0,
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		if($this->usuario_model->modifica($datos_usuario, $codigo))
		{
			// $this->session->set_userdata(array('alerta' => 2));
		}
		else
		{
			// $this->session->set_userdata(array('alerta' => 22));
		}

		redirect(base_url().'admin/usuarios/usuarios');
	}

	public function lista()
	{
		$tienda_id = $this->session->userdata('tienda_id');

		$this->datatables->add_column('icono', '<i class="fa fa-circle"></i>', 'icono');
		$this->datatables->select('tienda_usuarios.id as id,
			tienda_usuarios.tienda_id as tienda_id,
			tienda_usuarios.apellido as apellido,
			tienda_usuarios.nombre as nombre,
			tienda_usuarios.telefono as telefono,
			tienda_usuarios.correo as correo,
			tienda_usuarios.validado as validado,
			tienda_usuarios.tipo_id as tipo_id,

			CONCAT(tienda_usuarios.apellido, " ", tienda_usuarios.nombre) as nombre_completo,

			tienda_usuarios.creado as creado,
			DATE_FORMAT(tienda_usuarios.creado, "%d/%m/%Y") as creado_formateado,
			tienda_usuarios.estado as estado');
		$this->datatables->from('tienda_usuarios');
		// $this->datatables->join('tienda_usuarios_categoria', 'tienda_usuarios_categoria.id = tienda_usuarios.categoria_id');
		$this->datatables->where('tienda_usuarios.tienda_id', $tienda_id);
		$this->datatables->where('tienda_usuarios.estado !=', 2);

  		echo $this->datatables->generate();
	}
}
