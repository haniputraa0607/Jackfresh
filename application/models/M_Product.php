<?php

class M_Product extends CI_Model{

    public function getProduct($where)
    {
        $this->db->where($where);
        return $this->db->get('products');
    }

    public function getUnit($where)
    {
        $this->db->where($where);
        return $this->db->get('units');
    }
}

?>