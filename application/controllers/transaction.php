<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->library('form_validation');
		$this->load->model('M_Transaction');

		if(!$this->session->userdata('logged_in')){
			redirect ('auth/index');
		}
	}

    public function index(){
		$transactions = $this->M_Transaction->getTransaction([])->result();
		$data = [
			'content' => 'list_transaction',
			'result'  => [
				'title' => 'List Transaction',
                'menu_active' => 'transaction',
                'submenu_active' => 'list-transaction',
				'transactions' 	 => $transactions
			],
		];
		$this->load->view('template/main',$data);
    }

    public function create_transaction(){
		$data = [
			'content' => 'main',
			'result'  => [
				'title' => 'New Transaction',
                'menu_active' => 'transaction',
                'submenu_active' => 'create-transaction'
			],
		];
		$this->load->view('template/main',$data);
    }

    public function purchase_list(){
		$purchases = $this->M_Transaction->getPurchase([])->result();
		$data = [
			'content' => 'list_purchase',
			'result'  => [
				'title' 		 => 'List Purchase Request',
                'menu_active' 	 => 'transaction',
                'submenu_active' => 'list-purchase',
				'purchases' 	 => $purchases
			],
		];
		$this->load->view('template/main',$data);
    }

    public function create_purchase(){
		$data = [
			'content' => 'main',
			'result'  => [
				'title' => 'New Purchase Request',
                'menu_active' => 'transaction',
                'submenu_active' => 'create-purchase'
			],
		];
		$this->load->view('template/main',$data);
    }

}
