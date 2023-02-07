<?php

class M_Product extends CI_Model{

    public function getProduct($where)
    {
        $this->db->where($where);
        return $this->db->get('products');
    }

    public function getProduct_by_id($id_product)
    {
        $this->db->where('id_product', $id_product);
        $query = $this->db->get('products');
        return $query->row();
    }

    public function getUnit_by_id($id_unit)
    {
        $this->db->where('id_unit', $id_unit);
        $query = $this->db->get('units');
        return $query->row();
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

    public function update($data, $table, $id_product)
    {
		if($table=='products'){
			$key = 'id_product';
		}else{
			$key = 'id_unit';
		}
        $this->db->where($key, $id_product);
        $input = $this->db->update($table,$data);
        return $input;
    }

    public function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

	public function getProductUnits($id){
		$this->db->select('product_units.*, products.product_name, units.unit_name');
		$this->db->from('product_units');
        $this->db->where('product_units.id_product',$id);
		$this->db->join('products', 'products.id_product = product_units.id_product');
		$this->db->join('units', 'units.id_unit = product_units.id_unit');
        return $this->db->get();
	}

	public function update_product_unit($data,$where){
		$this->db->where($where);
        $this->db->update('product_units',$data);
	}
}

?>
