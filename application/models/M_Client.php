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

    public function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}

?>
