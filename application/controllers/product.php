<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->library('form_validation');
		$this->load->model('M_Product');

		if(!$this->session->userdata('logged_in')){
			redirect ('auth/index');
		}
	}

    public function index(){
		$products = $this->M_Product->getProduct([])->result();
        $data = [
			'content' => 'list_product',
			'result'  => [
				'title' 		 => 'List Product',
                'menu_active' 	 => 'product',
                'submenu_active' => 'list-product',
				'products' 		 => $products
			],
		];
		$this->load->view('template/main',$data);
    }

    public function create_product(){
        $data = [
			'content' => 'main',
			'result'  => [
				'title' => 'Create Product',
                'menu_active' => 'product',
                'submenu_active' => 'create-product'
                
			],
		];
		$this->load->view('template/main',$data);
    }

    public function unit_list(){
		$units = $this->M_Product->getUnit([])->result();
        $data = [
			'content' => 'list_unit',
			'result'  => [
				'title' 		 => 'List Unit',
                'menu_active'    => 'product',
                'submenu_active' => 'list-unit',
				'units' 		 => $units
			],
		];
		$this->load->view('template/main',$data);
    }

    public function unit_create(){
        $data = [
			'content' => 'main',
			'result'  => [
				'title' => 'Create Unit',
                'menu_active' => 'product',
                'submenu_active' => 'create-unit'
			],
		];
		$this->load->view('template/main',$data);
    }
}
