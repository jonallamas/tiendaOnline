<?php

class Usuario_model extends CI_Model {

    // private $tabla;

    public function __construct()
    {
        parent::__construct();
        // $this->tabla  = 'tienda_usuarios';
    }

    public function alta($data)
    {
        return $this->db->insert('tienda_usuarios', $data);
    }

    public function modifica($data, $codigo)
    {
        $this->db->where('tienda_usuarios.id', $id);

        return $this->db->update('tienda_usuarios', $data);
    }

    public function obtener($id)
    {
        $this->db->select('tienda_usuarios.*');
        $this->db->from('tienda_usuarios');
        $this->db->where('tienda_usuarios.id', $id);

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
        $this->db->select('tienda_usuarios.*');
        $this->db->from('tienda_usuarios');
        $this->db->where('tienda_usuarios.correo', $correo);

        $query = $this->db->get();
        return $query->row();

    }

    public function validar_cuenta($keymaster)
    {
        $this->db->select('tienda_usuarios.*');
        $this->db->from('tienda_usuarios');
        $this->db->where('tienda_usuarios.keymaster', $keymaster);

        $query = $this->db->get();
        return $query->row();
    }
    
    public function login($correo, $password)
    {
        $this->db->select('tienda_usuarios.*');
        $this->db->from('tienda_usuarios');
        $this->db->where('tienda_usuarios.log_correo', $correo);
        $this->db->where('tienda_usuarios.log_pass', $password);
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row();
    }

    // Funciones categorías
    public function alta_categoria($data)
    {
        return $this->db->insert('tienda_productos_categoria', $data);
    }

    public function modifica_categoria($data, $id)
    {
        $this->db->where('tienda_productos_categoria.id', $id);

        return $this->db->update('tienda_productos_categoria', $data);
    }

    public function obtener_categoria($id)
    {
        $this->db->select('tienda_productos_categoria.*,
            DATE_FORMAT(tienda_productos_categoria.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_productos_categoria');
        $this->db->where('tienda_productos_categoria.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function obtener_todos_categorias()
    {
        $this->db->select('tienda_productos_categoria.*,
            DATE_FORMAT(tienda_productos_categoria.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_productos_categoria');
        $this->db->where('tienda_productos_categoria.estado', 1);

        $query = $this->db->get();
        return $query->result();
    } 

}
