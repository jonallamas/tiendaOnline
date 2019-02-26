<?php

class Usuario_model extends CI_Model {

    private $tabla;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->tabla  = 'tienda_usuarios';
    }

    public function alta($data)
    {
        return $this->db->insert($this->tabla, $data);
    }

    public function modifica($data, $id)
    {
        $this->db->where($this->tabla.'.id', $id);
        return $this->db->update($this->tabla, $data);
    }

    public function obtener($id)
    {
        $this->db->select($this->tabla.'.*');
        $this->db->from($this->tabla);
        $this->db->where($this->tabla.'.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // public function validar_usuario($usuario)
    // {
    //     $this->db->select($this->tabla.'.*');
    //     $this->db->from($this->tabla);
    //     $this->db->where($this->tabla.'.usuario', $usuario);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    public function validar_correo($correo)
    {
        $this->db->select($this->tabla.'.*');
        $this->db->from($this->tabla);
        $this->db->where($this->tabla.'.correo', $correo);
        $query = $this->db->get();
        return $query->row();

    }

    public function validar_cuenta($keymaster)
    {
        $this->db->select($this->tabla.'.*');
        $this->db->from($this->tabla);
        $this->db->where($this->tabla.'.keymaster', $keymaster);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function login($correo, $password)
    {
        $this->db->select($this->tabla.'.*');
        $this->db->from($this->tabla);
        $this->db->where($this->tabla.'.log_correo', $correo);
        $this->db->where($this->tabla.'.log_pass', $password);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

}
