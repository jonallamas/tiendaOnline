<?php
class Carrito_model extends CI_Model {

    private $tabla;

    public function __construct()
    {
        parent::__construct();
    }

    public function alta($data)
    {
        return $this->db->insert('tienda_stk_compras_egreso', $data);
    }

    public function alta_compra($data)
    {
        return $this->db->insert('tienda_stk_compras', $data);
    }

    public function modifica($data, $id)
    {
        $this->db->where('tienda_stk_compras_egreso.id', $id);

        return $this->db->update('tienda_stk_compras_egreso', $data);
    }

    public function modifica_compra($data, $id)
    {
        $this->db->where('tienda_stk_compras.id', $id);

        return $this->db->update('tienda_stk_compras', $data);
    }

    public function obtener($id)
    {
        $this->db->select('tienda_stk_compras_egreso.*,
            DATE_FORMAT(tienda_stk_compras_egreso.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_stk_compras_egreso');
        $this->db->where('tienda_stk_compras_egreso.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function obtener_todos()
    {
        $this->db->select('tienda_stk_compras_egreso.*,
            DATE_FORMAT(tienda_stk_compras_egreso.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_stk_compras_egreso');
        $this->db->where('tienda_stk_compras_egreso.estado', 1);

        $query = $this->db->get();
        return $query->result();
    } 

    // Widgets
    public function obtener_cant_compras($tienda_id, $usuario_id)
    {
        $this->db->select('tienda_stk_compras.id,
            tienda_stk_compras.cantidad,
            tienda_stk_compras.total');
        $this->db->from('tienda_stk_compras');
        $this->db->where('tienda_stk_compras.tienda_id', $tienda_id);
        $this->db->where('tienda_stk_compras.usuario_id', $usuario_id);
        $this->db->where('tienda_stk_compras.estado', 1);

        $query = $this->db->get();
        return $query->result();
    }
}
