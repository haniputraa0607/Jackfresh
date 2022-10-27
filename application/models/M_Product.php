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