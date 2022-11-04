<?php

class M_Client extends CI_Model{

    public function getClient($where)
    {
        $this->db->where($where);
        return $this->db->get('clients');
    }
	
	public function tes($where)
    {
        $this->db->where($where);
        return $this->db->get('clients');
    }

    public function input($data, $table)
    {
        $input = $this->db->insert($table,$data);
        return $input;
    }

    function getClient_by_id($id_client)
    {
        $this->db->where('id_client', $id_client);
        $query = $this->db->get('clients');
        return $query->result();
    }

    public function update($data, $table, $id_client)
    {
        $this->db->where('id_client', $id_client);
        $input = $this->db->update($table,$data);
        return $input;
    }

    public function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}

?>
