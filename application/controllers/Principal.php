<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('cart');

		$this->load->model('carrito_model');
	}

	public function index()
	{
		$this->load->model('productos_model');

		$this->data_header['productos'] = $this->productos_model->obtener_todos();
		$this->load->view('template/web_v1/header', $this->data_header);
		$this->load->view('template/web_v1/principal');
		$this->load->view('template/web_v1/footer');
	}

}