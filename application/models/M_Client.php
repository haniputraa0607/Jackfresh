<?php

class M_Client extends CI_Model{

    public function getClient($where)
    {
        $this->db->where($where);
        return $this->db->get('clients');
    }
}

?>