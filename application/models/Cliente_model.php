<?php
class Cliente_model extends CI_Model {

    private $tabla;

    public function __construct()
    {
        parent::__construct();
    }

    public function alta($data)
    {
        return $this->db->insert('tienda_clientes', $data);
    }

    public function modifica($data, $id)
    {
        $this->db->where('tienda_clientes.id', $id);

        return $this->db->update('tienda_clientes', $data);
    }

    public function obtener($id)
    {
        $this->db->select('tienda_clientes.*,
            DATE_FORMAT(tienda_clientes.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_clientes');
        $this->db->where('tienda_clientes.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function obtener_todos()
    {
        $this->db->select('tienda_clientes.*,
            DATE_FORMAT(tienda_clientes.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_clientes');
        $this->db->where('tienda_clientes.estado', 1);

        $query = $this->db->get();
        return $query->result();
    }


    // Datos de configuración - Clientes
    public function alta_direccion($data)
    {
        return $this->db->insert('tienda_clientes_direcciones_envio', $data);
    }

    public function modifica_direccion($data, $id)
    {
        $this->db->where('tienda_clientes_direcciones_envio.id', $id);

        return $this->db->update('tienda_clientes_direcciones_envio', $data);
    }

    public function obtener_direcciones($usuario_id)
    {
        $tienda_id = $this->session->userdata('tienda_id');

        $this->db->select('tienda_clientes_direcciones_envio.*,
            DATE_FORMAT(tienda_clientes_direcciones_envio.creado, "%d/%m/%Y") as creado_format');
        $this->db->from('tienda_clientes_direcciones_envio');
        $this->db->where('tienda_clientes_direcciones_envio.tienda_id', $tienda_id);
        $this->db->where('tienda_clientes_direcciones_envio.usuario_id', $usuario_id);
        $this->db->where('tienda_clientes_direcciones_envio.estado', 1);

        $query = $this->db->get();
        return $query->row();
    }
}
