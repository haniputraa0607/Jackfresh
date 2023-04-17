<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->library('form_validation');
		$this->load->model('M_Transaction');
		$this->load->model('M_Client');
		$this->load->model('M_Product');

		if(!$this->session->userdata('logged_in')){
			redirect ('auth/index');
		}
	}

    public function index(){
		$transactions = $this->M_Transaction->getTransaction([])->result();
		$data = [
			'content' => 'list_transaction',
			'result'  => [
				'title' => 'Daftar Transaksi',
                'menu_active' => 'transaction',
                'submenu_active' => 'list-transaction',
				'transactions' 	 => $transactions
			],
		];
		$this->load->view('template/main',$data);
    }

    public function create_transaction(){
    	$id_transaction = $this->M_Transaction->getID_transaction();
		$clients = $this->M_Client->getClient([])->result();
		$products = $this->M_Product->getProduct([])->result();
		$products = array_map(function($val){
			$val->units = $this->M_Product->getProductUnits($val->id_product)->result();
			$val->units = json_encode($val->units);
			// $val->units = str_replace('"', '\'', $val->units);
			return $val;
		},$products);
		$data = [
			'content' => 'create_transaction',
			'result'  => [
				'title' => 'Buat Transaksi Baru',
                'menu_active' => 'transaction',
                'submenu_active' => 'create-transaction',
                'id_transaction' => $id_transaction,
				'clients' 	 => $clients,
				'products' 	 => $products
			],
		];
		$this->load->view('template/main',$data);
    }

    public function purchase_list(){
		$purchases = $this->M_Transaction->getPurchase([])->result();
		$clients = $this->M_Client->getClient([])->result();
		$data = [
			'content' => 'list_purchase',
			'result'  => [
				'title' 		 => 'Daftar Permintaan Pembelian',
                'menu_active' 	 => 'transaction',
                'submenu_active' => 'list-purchase',
				'purchases' 	 => $purchases,
				'clients' 	 	 => $clients
			],
		];
		$this->load->view('template/main',$data);
    }

    public function create_purchase(){
    	$id_purchase = $this->M_Transaction->getID_purchase();
		$clients = $this->M_Client->getClient([])->result();
		$products = $this->M_Product->getProduct([])->result();
		$products = array_map(function($val){
			$val->units = $this->M_Product->getProductUnits($val->id_product)->result();
			$val->units = json_encode($val->units);
			// $val->units = str_replace('"', '\'', $val->units);
			return $val;
		},$products);
		$data = [
			'content' => 'create_purchase',
			'result'  => [
				'title' => 'Buat Permintaan Baru',
                'menu_active' => 'transaction',
                'submenu_active' => 'create-purchase',
                'id_purchase' => $id_purchase,
				'clients' 	 => $clients,
				'products' 	 => $products
			],
		];

		$this->load->view('template/main',$data);
    }

	public function delete($id){
		$where = array ('id_transaction' => $id);
        $this->M_Transaction->delete($where, 'transactions');
        redirect('transaction');
	}

	public function delete_purchase($id){
		$where = array ('id_purchase' => $id);
        $this->M_Transaction->delete($where, 'purchase');
        redirect('transaction/purchase_list');
	}

	public function input_transaction(){
		$data = [
			'transaction_code' => $this->input->post('transaction_code'),
			'id_client' => $this->input->post('id_client') ?? null,
			'transaction_date' => $this->input->post('transaction_date'),
			'payment_type' => $this->input->post('payment_type'),
			'notes' => $this->input->post('notes'),
		];
		$product = $this->input->post('products') ?? null;
		$input = $this->M_Transaction->inputTransaction($data, $product);
		redirect('transaction');
	}

	public function input_purchase(){
		$data = [
			'purchase_code' => $this->input->post('purchase_code'),
			'id_client' => $this->input->post('id_client') ?? null,
			'purchase_date' => $this->input->post('purchase_date'),
			'payment_type' => $this->input->post('payment_type'),
			'notes' => $this->input->post('notes'),
			'status' => 'Pending'
		];
		$product = $this->input->post('products') ?? null;
		$input = $this->M_Transaction->inputPurchase($data, $product);
		redirect('transaction/purchase_list');
	}

	public function detail_purchase($id){
		$purchase = $this->M_Transaction->getPurchase(['purchase.id_purchase' => $id])->result();
		$purchase_products = $this->M_Transaction->purchaseProduct($id)->result();
		$clients = $this->M_Client->getClient([])->result();
		$products = $this->M_Product->getProduct([])->result();
		$products = array_map(function($val){
			$val->units = $this->M_Product->getProductUnits($val->id_product)->result();
			$val->product_units = $val->units;
			$val->units = json_encode($val->units);
			// $val->units = str_replace('"', '\'', $val->units);
			return $val;
		},$products);
		// var_dump($products);
		$data = [
			'content' => 'detail_purchase',
			'result'  => [
				'title' => 'Detail Permintaan',
                'menu_active' => 'transaction',
                'submenu_active' => 'list-purchase',
				'purchase' => $purchase,
				'purchase_products' => $purchase_products,
				'clients' 	 => $clients,
				'products' 	 => $products
			],
		];

		$this->load->view('template/main',$data);
	}

	public function detail($id){
		$transaction = $this->M_Transaction->getTransaction(['transactions.id_transaction' => $id])->result();
		$products = $this->M_Transaction->transactionProduct($id)->result();
		$data = [
			'content' => 'detail_transaction',
			'result'  => [
				'title' => 'Detail Transaksi',
                'menu_active' => 'transaction',
                'submenu_active' => 'list-transaction',
				'transaction' 	 => $transaction,
				'products' 	 => $products
			],
		];

		$this->load->view('template/main',$data);
	}

	public function update_purchase($id){
		$data = [
			'purchase_code' => $this->input->post('purchase_code'),
			'id_client' => $this->input->post('id_client') ?? null,
			'purchase_date' => $this->input->post('purchase_date'),
			'payment_type' => $this->input->post('payment_type'),
			'notes' => $this->input->post('notes'),
			'status' => 'Pending'
		];
		$product = $this->input->post('products') ?? null;
		$where = [
			'id_purchase' => $id
		];
		$input = $this->M_Transaction->updatePurhcase($data, $product,$where);
		redirect('transaction/detail_purchase/'.$id);

	}

	public function check(){
		$data = [
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date'),
			'id_client' => $this->input->post('id_client')
		];

		$need = $this->M_Transaction->checkNeed($data)->result();
		$stocks = $this->M_Transaction->checkStock()->result();
		$need = array_map(function($val) use($stocks){
			foreach($stocks ?? [] as $stock){
				if($val->id_product_unit == $stock->id_product_unit){
					$val->qty = $val->qty - $stock->stock;
				}
			}
			return $val;
		},$need);
		
		echo json_encode($need);

	}

	public function export_requirement(){
		$data = [
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date'),
			'id_client' => $this->input->post('id_client')
		];

		if($data['id_client'] == 'all'){
			$cleints = $this->M_Client->getClient([])->result();
		}else{
			$cleints = $this->M_Client->getClient(['id_client'=>$data['id_client']])->result();
		}

		$result = [];
		foreach($cleints ?? [] as $client){
			
			$data['id_client'] = $client->id_client;
			$need = $this->M_Transaction->checkNeed($data)->result();
			$stocks = $this->M_Transaction->checkStock()->result();
			$need = array_map(function($val) use($stocks){
				foreach($stocks ?? [] as $stock){
					if($val->id_product_unit == $stock->id_product_unit){
						$val->qty = $val->qty - $stock->stock;
					}
				}
				return $val;
			},$need??[]);

			if($need){
				$result[] = [
					'id_client' => $client->id_client,
					'client_name' => $client->client_name,
					'need' => $need
				];
			}
		}

		echo json_encode($result);

	}

	public function nota($id_transaction){
		$transaction = $this->M_Transaction->getTransaction(['transactions.id_transaction' => $id_transaction])->result();
		$transaction['products'] = $this->M_Transaction->transactionProduct($id_transaction)->result();
		// var_dump($transaction);
		redirect ('transaction');
	}

}
