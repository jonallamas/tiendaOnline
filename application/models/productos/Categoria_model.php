<?php
class Categoria_model extends CI_Model {

    private $tabla;

    public function __construct()
    {
        parent::__construct();
    }

    public function alta($data)
    {
        return $this->db->insert('tienda_productos_categoria', $data);
    }

    public function modifica($data, $id)
    {
        $this->db->where('tienda_productos_categoria.id', $id);

        return $this->db->update('tienda_productos_categoria', $data);
    }

    public function obtener($id)
    {
        $this->db->select('tienda_productos_categoria.*,
            DATE_FORMAT(tienda_productos_categoria.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_productos_categoria');
        $this->db->where('tienda_productos_categoria.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function obtener_todos()
    {
        $this->db->select('tienda_productos_categoria.*,
            DATE_FORMAT(tienda_productos_categoria.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_productos_categoria');
        $this->db->where('tienda_productos_categoria.estado', 1);

        $query = $this->db->get();
        return $query->result();
    } 
}
