<?php
class Pedido_model extends CI_Model {

    private $tabla;

    public function __construct()
    {
        parent::__construct();
    }

    public function alta($data)
    {
        return $this->db->insert('tienda_stk_compras', $data);
    }

    public function modifica($data, $id)
    {
        $this->db->where('tienda_stk_compras.id', $id);

        return $this->db->update('tienda_stk_compras', $data);
    }

    public function obtener($codigo)
    {
        $this->db->select('tienda_stk_compras.*,
            DATE_FORMAT(tienda_stk_compras.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_stk_compras');
        $this->db->where('tienda_stk_compras.codigo', $codigo);

        $query = $this->db->get();
        return $query->row();
    }

    public function obtener_todos()
    {
        $this->db->select('tienda_stk_compras.*,
            DATE_FORMAT(tienda_stk_compras.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_stk_compras');
        $this->db->where('tienda_stk_compras.estado', 1);

        $query = $this->db->get();
        return $query->result();
    } 

    // Widgets
    public function obtener_cant_compras($tienda_id)
    {
        $this->db->select('tienda_stk_compras.id,
            tienda_stk_compras.cantidad,
            tienda_stk_compras.total');
        $this->db->from('tienda_stk_compras');
        $this->db->where('tienda_stk_compras.tienda_id', $tienda_id);
        $this->db->where('tienda_stk_compras.estado', 1);

        $query = $this->db->get();
        return $query->result();
    }
}
