<?php

class M_Product extends CI_Model{

    public function getProduct($where)
    {
        $this->db->where($where);
        return $this->db->get('products');
    }

     function getProduct_by_id($id_product)
    {
        $this->db->where('id_product', $id_product);
        $query = $this->db->get('products');
        return $query->result();
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