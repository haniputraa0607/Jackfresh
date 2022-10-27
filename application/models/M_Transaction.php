<?php

class M_Transaction extends CI_Model{

    public function getTransaction($where)
    {
        $this->db->select('transactions.*, clients.client_name, COUNT(transaction_product_units.id_transaction) as total');
		$this->db->from('transactions');
		$this->db->group_by('transactions.id_transaction');
        $this->db->where($where);
		$this->db->join('transaction_product_units', 'transaction_product_units.id_transaction = transactions.id_transaction');
		$this->db->join('clients', 'clients.id_client = transactions.id_client', 'left');
        return $this->db->get();
    }

    public function getPurchase($where)
    {
		$this->db->select('purchase.*, clients.client_name, COUNT(purchase_product_units.id_purchase) as total');
		$this->db->from('purchase');
		$this->db->group_by('purchase.id_purchase');
        $this->db->where($where);
		$this->db->join('purchase_product_units', 'purchase_product_units.id_purchase = purchase.id_purchase');
		$this->db->join('clients', 'clients.id_client = purchase.id_client', 'left');
        return $this->db->get();
    }

    public function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}

?>