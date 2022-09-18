<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	public function __construct(){
		parent::__construct();		

		if(!$this->session->userdata('logged_in')){
			redirect ('auth/index');
		}
	}

    public function index(){
		$data = [
			'content' => 'main',
			'result'  => [
				'title' => 'List Transaction',
                'menu_active' => 'transaction',
                'submenu_active' => 'list-transaction'
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
		$data = [
			'content' => 'main',
			'result'  => [
				'title' => 'List Purchase Request',
                'menu_active' => 'transaction',
                'submenu_active' => 'list-purchase'
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
