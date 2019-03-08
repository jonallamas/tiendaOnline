<?php
class Producto_model extends CI_Model {

    private $tabla;

    public function __construct()
    {
        parent::__construct();
    }

    public function alta($data)
    {
        return $this->db->insert('tienda_productos', $data);
    }

    public function modifica($data, $codigo)
    {
        $this->db->where('tienda_productos.codigo', $codigo);

        return $this->db->update('tienda_productos', $data);
    }

    public function obtener($codigo)
    {
        $this->db->select('tienda_productos.*,
            DATE_FORMAT(tienda_productos.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_productos');
        $this->db->where('tienda_productos.codigo', $codigo);

        $query = $this->db->get();
        return $query->row();
    }

    public function obtener_todos()
    {
        $this->db->select('tienda_productos.*,
            tienda_productos_categoria.nombre as categoria_nombre,
            DATE_FORMAT(tienda_productos.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_productos');
        $this->db->join('tienda_productos_categoria', 'tienda_productos_categoria.id = tienda_productos.categoria_id');
        $this->db->where('tienda_productos.estado', 1);
        $this->db->order_by('tienda_productos.creado', 'desc');

        $query = $this->db->get();
        return $query->result();
    }
}
