<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {

	public function __construct(){
		parent::__construct();

		// Carga de los modelos
		$this->load->model('usuario_model');

		//Configurando el data_header
		$this->data_header['titulo'] = 'Panel';
		$this->data_header['seccion_menu'] = 'tienda_principal';
	}

	public function index()
	{
		if($this->session->userdata('conectado')){
			$this->load->view('template/panel_v1/header', $this->data_header);
			$this->load->view('principal');
			$this->load->view('template/panel_v1/footer');
		}else{
			redirect(base_url().'panel/ingresar');
		}
	}

	public function ingresar()
	{
		if($this->session->userdata('conectado')){
			redirect(base_url().'panel');
		}else{
			$this->load->view('template/panel_v1/login');
		}
	}

	public function ingreso(){
		if($this->session->userdata('conectado'))
		{
			$data = array(
				'conectado' => 1,
				'error' 	=> 1,
				'error_tipo' => 2,
				'error_text' => 'Sessión iniciada'
			);

			echo json_encode($data);
			exit();
		}

		$login_correo 	= $this->input->post('f_login_correo');
		$login_pass 	= $this->input->post('f_login_pass');
		$login_pass 	= md5($login_pass);

		$validacion = $this->usuario_model->login($login_correo, $login_pass);

		if($validacion){
			$data_session = array(
				'conectado' 				=> 1,
				'usuario_id' 				=> $validacion->id,
				'usuario_validado' 			=> $validacion->validado,
				'usuario_nombre' 			=> $validacion->nombre,
				'usuario_apellido' 			=> $validacion->apellido,
				'usuario_nombre_completo' 	=> $validacion->apellido.' '.$validacion->nombre,
				'usuario_correo' 			=> $validacion->correo,
				'usuario_tipo' 				=> $validacion->tipo_id,
				'tienda_id' 				=> $validacion->tienda_id
			);

			$this->session->set_userdata($data_session);

			$data = array(
				'conectado' => 1,
				'usuario_tipo' => $validacion->tipo_id,
				'error' 	=> 0,
				'error_tipo' => 0,
				'error_text' => NULL
			);

			echo json_encode($data);
			exit();
		}
		else
		{
			$data = array(
				'conectado' => 0,
				'usuario_tipo' => $validacion->tipo_id,
				'error' 	=> 1,
				'error_tipo' => 1,
				'error_text' => 'Información incorrecta'
			);

			echo json_encode($data);
			exit();
		}
	}

	public function validar_correo()
	{
		$correo = $this->input->post('f_correo');
		if($this->usuario_model->validar_correo($correo)){
			$data = array(
				'error' => 1,
				'error_texto' => 'El correo ya existe'
			);
		}else{
			$data = array(
				'error' => 0,
				'error_texto' => NULL
			);
		}

		echo json_encode($data);
	}

	public function registro()
	{
		if($this->session->userdata('conectado'))
		{
			$data = array(
				'conectado' => 1,
				'error' 	=> 1,
				'error_tipo' => 2,
				'error_text' => 'Sessión iniciada'
			);

			echo json_encode($data);
			exit();
		}

		$registro_apellido 	= $this->input->post('f_registro_apellido');
		$registro_nombre 	= $this->input->post('f_registro_nombre');
		$registro_correo 	= $this->input->post('f_registro_correo');

		$registro_pass 		= $this->input->post('f_registro_pass');
		$registro_pass 		= md5($registro_pass);

		$data = array(
			'tienda_id' 	=> 1,
			'apellido' 		=> $registro_apellido,
			'nombre' 		=> $registro_nombre,
			'telefono' 		=> NULL,
			'correo' 		=> $registro_correo,

			'log_correo' 	=> $registro_correo,
			'log_pass' 		=> $registro_pass,

			'validado' 		=> 0,
			'keymaster' 	=> NULL,
			'tipo_id' 		=> 2,

			'estado' 		=> 1,
			'creado'	 	=> date('Y-m-d H:i:s'),
			'actualizado' 	=> date('Y-m-d H:i:s')
		);

		$this->usuario_model->alta($data);

		$validacion = $this->usuario_model->login($registro_correo, $registro_pass);

		if($validacion){
			$datos_envio = array(
				'tienda_id' 	=> $validacion->tienda_id,
				'usuario_id' 	=> $validacion->id,
				
				'codigo_postal' => '',
				
				'calle_nombre' 	=> '',
				'calle_numero' 	=> '',
				
				'piso' 			=> '',
				'departamento' 	=> '',

				'estado' 		=> 1,
				'creado' 		=> date('Y-m-d H:i:s'),
				'actualizado' 	=> date('Y-m-d H:i:s')
			);

			$this->load->model('cliente_model');
			$this->cliente_model->alta_direccion($datos_envio);

			$data_session = array(
				'conectado' 				=> 1,
				'usuario_id' 				=> $validacion->id,
				'usuario_validado' 			=> $validacion->validado,
				'usuario_nombre' 			=> $validacion->nombre,
				'usuario_apellido' 			=> $validacion->apellido,
				'usuario_nombre_completo' 	=> $validacion->apellido.' '.$validacion->nombre,
				'usuario_correo' 			=> $validacion->correo,
				'usuario_tipo' 				=> $validacion->tipo_id,
				'tienda_id' 				=> $validacion->tienda_id
			);

			$this->session->set_userdata($data_session);

			$data = array(
				'conectado' => 1,
				'error' 	=> 0,
				'error_tipo' => 0,
				'error_text' => NULL
			);

			echo json_encode($data);
			exit();
		}
		else
		{
			$data = array(
				'conectado' => 0,
				'error' 	=> 1,
				'error_tipo' => 1,
				'error_text' => 'Información incorrecta'
			);

			echo json_encode($data);
			exit();
		}

	}

	public function salir()
	{
		$this->session->sess_destroy();
		redirect(base_url().'panel/ingresar');
	}
}
