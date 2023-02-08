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
		$this->db->select('purchase.*, clients.client_name, clients.id_client, COUNT(purchase_product_units.id_purchase) as total');
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

	public function inputTransaction($data,$product)
	{
		$this->db->trans_begin();

		$input = $this->db->insert('transactions',$data);
		$id_input = $this->db->insert_id();
		if($input){
			$grand_total = 0;
			foreach($product ?? [] as $prod){
				$check = $this->checkProduct($prod);
				if($check["status"] == false){
					$this->db->trans_rollback();
					return false;
				}
				$prod_transction = [
					"id_transaction" => $id_input,
					"id_product_unit" => $check["id_product_unit"],
					"qty" => $prod["qty"],
					"price" => $check["price"],
					"status" => 1
				];
				$grand_total += $prod_transction["price"];
				$input_prod = $this->db->insert('transaction_product_units',$prod_transction);
				$update_stock = $this->db->where(["id_product"=> $prod["id_product"], "id_unit"=> $prod["id_unit"]])->update('product_units',["stock"=>$check['stock_after']]);
			}
			$update_trans = $this->db->where(["id_transaction"=> $id_input])->update('transactions',["grand_total"=>$grand_total,"status"=>"Finished"]);
			$this->db->trans_commit();
			return true;
		}
		$this->db->trans_rollback();
		return false;
	}

	public function checkProduct($data){
		$prod_unit = $this->db->select('product_units.*')->from('product_units')->where(["id_product"=> $data["id_product"], "id_unit"=> $data["id_unit"]])->get()->row();
		if($prod_unit->stock >= $data["qty"]){
			return [
				"status" => true,
				"id_product_unit" => $prod_unit->id_product_unit,
				"price" => $data["qty"]*$prod_unit->price,
				"stock_after" => $prod_unit->stock - $data["qty"]
			];
		}
		return [
			"status" => false
		];

	}

	public function inputPurchase($data,$product)
	{
		$this->db->trans_begin();

		$input = $this->db->insert('purchase',$data);
		$id_input = $this->db->insert_id();
		if($input){
			$to_trans = true;
			$pending = true;
			foreach($product ?? [] as $prod){
				$check = $this->checkProductPurhcase($prod);
				$prod_purchase = [
					"id_purchase" => $id_input,
					"id_product_unit" => $check["id_product_unit"],
					"qty" => $prod["qty"],
					"status" => $check["status"] == false ? 0 : 1
				];
				$input_prod = $this->db->insert('purchase_product_units',$prod_purchase);
				if($check["status"]==false){
					$to_trans = false;
				}else{
					$pending = false;
				}
			}
			if($to_trans){
				$data_trans = [
					'transaction_code' => $data["purchase_code"],
					'id_client' => $data["id_client"] ?? null,
					'transaction_date' => $data["purchase_date"],
					'notes' => $data["notes"],
				];
				$input_trans = $this->inputTransaction($data_trans, $product);
				if(!$input_trans){
					$this->db->trans_rollback();
					return false;
				}
				$update_purchase = $this->db->where(["id_purchase"=> $id_input])->update('purchase',["status"=>"Finished"]);
			}elseif(!$to_trans && !$pending){
				$update_purchase = $this->db->where(["id_purchase"=> $id_input])->update('purchase',["status"=>"Process"]);
			}
			$this->db->trans_commit();
			return true;
		}
		$this->db->trans_rollback();
		return false;
	}

	public function checkProductPurhcase($data){
		$prod_unit = $this->db->select('product_units.*')->from('product_units')->where(["id_product"=> $data["id_product"], "id_unit"=> $data["id_unit"]])->get()->row();
		if($prod_unit->stock >= $data["qty"]){
			return [
				"status" => true,
				"id_product_unit" => $prod_unit->id_product_unit,
			];
		}
		return [
			"status" => false,
			"id_product_unit" => $prod_unit->id_product_unit,
		];

	}

	public function transactionProduct($id){
		$this->db->select('transaction_product_units.*, products.product_name, units.unit_name');
		$this->db->from('transaction_product_units');
        $this->db->where('transaction_product_units.id_transaction',$id);
		$this->db->join('product_units', 'product_units.id_product_unit = transaction_product_units.id_product_unit');
		$this->db->join('products', 'products.id_product = product_units.id_product');
		$this->db->join('units', 'units.id_unit = product_units.id_unit');
        return $this->db->get();
	}

	public function purchaseProduct($id){
		$this->db->select('purchase_product_units.*, products.product_name, products.id_product, units.unit_name, units.id_unit');
		$this->db->from('purchase_product_units');
        $this->db->where('purchase_product_units.id_purchase',$id);
		$this->db->join('product_units', 'product_units.id_product_unit = purchase_product_units.id_product_unit');
		$this->db->join('products', 'products.id_product = product_units.id_product');
		$this->db->join('units', 'units.id_unit = product_units.id_unit');
        return $this->db->get();
	}

	public function updatePurhcase($data,$product,$where){
		
		$this->db->trans_begin();

		$update = $this->db->where($where);
		$update = $update->update('purchase',$data);
		$id_input = $where['id_purchase'];
		if($update){
			$to_trans = true;
			$pending = true;
			$delete_prod = $this->db->where('id_purchase',$id_input)->delete('purchase_product_units');
			foreach($product ?? [] as $prod){
				$check = $this->checkProductPurhcase($prod);
				$prod_purchase = [
					"id_purchase" => $id_input,
					"id_product_unit" => $check["id_product_unit"],
					"qty" => $prod["qty"],
					"status" => $check["status"] == false ? 0 : 1
				];
				$input_prod = $this->db->insert('purchase_product_units',$prod_purchase);
				if($check["status"]==false){
					$to_trans = false;
				}else{
					$pending = false;
				}
			}
			if($to_trans){
				$data_trans = [
					'transaction_code' => $data["purchase_code"],
					'id_client' => $data["id_client"] ?? null,
					'transaction_date' => $data["purchase_date"],
					'notes' => $data["notes"],
				];
				$input_trans = $this->inputTransaction($data_trans, $product);
				if(!$input_trans){
					$this->db->trans_rollback();
					return false;
				}
				$update_purchase = $this->db->where(["id_purchase"=> $id_input])->update('purchase',["status"=>"Finished"]);
			}elseif(!$to_trans && !$pending){
				$update_purchase = $this->db->where(["id_purchase"=> $id_input])->update('purchase',["status"=>"Process"]);
			}
			$this->db->trans_commit();
			return true;
		}
		$this->db->trans_rollback();
		return false;
	}

	public function checkNeed($data){
		$this->db->select('product_units.id_product_unit, products.product_name, units.unit_name, SUM(purchase_product_units.qty) as qty');
		$this->db->from('purchase_product_units');
		$this->db->group_by('product_units.id_product_unit');
		if(isset($data['id_client']) && $data['id_client'] != 'all'){
			$this->db->where('purchase.id_client',$data['id_client']);
		}
		$this->db->where('purchase.purchase_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
		$this->db->where('purchase.status <>', 'Finished');
		$this->db->join('purchase', 'purchase.id_purchase = purchase_product_units.id_purchase');
		$this->db->join('clients', 'clients.id_client = purchase.id_client', 'left');
		$this->db->join('product_units', 'product_units.id_product_unit = purchase_product_units.id_product_unit');
		$this->db->join('products', 'products.id_product = product_units.id_product');
		$this->db->join('units', 'units.id_unit = product_units.id_unit');
        return $this->db->get();
	}

	public function checkStock(){
		$this->db->select('product_units.*');
		$this->db->from('product_units');
        return $this->db->get();
	}

    public function getID_purchase(){
        $this->db->select('MAX(RIGHT(id_purchase,5)) as id_purchase ', FALSE);
          $this->db->order_by('id_purchase','DESC');    
          $this->db->limit(1);    
          $query = $this->db->get('purchase');  //cek dulu apakah ada sudah ada kode di tabel.    
          if($query->num_rows() <> 0){      
               //cek kode jika telah tersedia    
               $data = $query->row();      
               $kode = intval($data->id_purchase) + 1; 
          }
          else{      
               $kode = 1;  //cek jika kode belum terdapat pada table
          }
              $tgl=date('dm'); 
              $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);    
              $kodetampil = "PR-".$tgl."-".$batas;  //format kode
              return $kodetampil;  
    }

      public function getID_transaction(){
        $this->db->select('MAX(RIGHT(id_transaction,5)) as id_transaction ', FALSE);
          $this->db->order_by('id_transaction','DESC');    
          $this->db->limit(1);    
          $query = $this->db->get('transactions');  //cek dulu apakah ada sudah ada kode di tabel.    
          if($query->num_rows() <> 0){      
               //cek kode jika telah tersedia    
               $data = $query->row();      
               $kode = intval($data->id_transaction) + 1; 
          }
          else{      
               $kode = 1;  //cek jika kode belum terdapat pada table
          }
              $tgl=date('dm'); 
              $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);    
              $kodetampil = "TR-".$tgl."-".$batas;  //format kode
              return $kodetampil;  
    }

}

?>
