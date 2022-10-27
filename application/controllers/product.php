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
			'content' => 'create_product',
			'result'  => [
				'title' => 'Produk Baru',
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
			'content' => 'create_unit',
			'result'  => [
				'title' => 'Unit Baru',
                'menu_active' => 'product',
                'submenu_active' => 'create-unit'
			],
		];
		$this->load->view('template/main',$data);
    }

	public function input_product(){
		$data = [
			'product_name'  	 => $this->input->post('product_name'),
			'product_code'  	 => $this->input->post('product_code'),
			'notes'       		 => $this->input->post('notes'),
			'product_code'  	 => $this->input->post('product_code'),
			'is_active'     	 => 1,
			'product_visibility' => 'Visible',
		];
		$config['upload_path']   = './assets/img/product';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']      = 2000;
		$config['file_name']     = $data['product_name'];
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('product_photo')){
			$error = array('error' => $this->upload->display_errors());
			// $this->load->view('v_upload', $error);
			redirect('product/create_product');
		}else{
			$upload = array('upload_data' => $this->upload->data());
			$data['product_photo'] = 'assets/img/product/'.$upload['upload_data']['file_name'];
			// $this->load->view('v_upload_sukses', $data);
			$input = $this->M_Product->input($data,'products');
			redirect('product');
		}
    }

	public function input_unit(){
		$data = [
			'unit_name'  	 => $this->input->post('unit_name'),
		];
		$input = $this->M_Product->input($data,'units');
		redirect('product/unit_list');
    }

	public function delete($id){
		$where = array ('id_product' => $id);
        $this->M_Product->delete($where, 'products');
        redirect('product');
	}

	public function delete_unit($id){
		$where = array ('id_unit' => $id);
        $this->M_Product->delete($where, 'units');
        redirect('product/unit_list');
	}
}
