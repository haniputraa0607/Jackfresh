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
				'title' 		 => 'Daftar Produk',
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

    public function detail_product($id){
        $products = $this->M_Product->getProduct_by_id($id);
		$units = $this->M_Product->getProductUnits($id)->result();
		$list_unit = $this->M_Product->getUnit([])->result();
		$value_product_units = $this->M_Product->getProductUnit_by_id($id);
        $data = [
			'content' => 'detail_product',
			'result'  => [
				'title' => 'Detail Produk',
                'menu_active' => 'product',
                'submenu_active' => 'list-product',
                'products' 		 => $products,
				'units'			 => $units,
				'all_units'		 => $list_unit,	
				'value_product_units'   => $value_product_units,	
			],
		];
		$this->load->view('template/main',$data);
    }


    public function unit_list(){
		$units = $this->M_Product->getUnit([])->result();
        $data = [
			'content' => 'list_unit',
			'result'  => [
				'title' 		 => 'Daftar Unit',
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
			// 'product_photo'  	 => $this->input->post('product_photo'),
			'is_active'     	 => 1,
			'product_visibility' => 'Visible',
		];
		// $config['upload_path']   = './assets/img/product';
		// $config['allowed_types'] = 'gif|jpg|jpeg|png';
		// $config['max_size']      = 2000;
		// $config['file_name']     = $data['product_name'];
		// $this->load->library('upload', $config);
		// if ( ! $this->upload->do_upload('product_photo')){
		// 	$error = array('error' => $this->upload->display_errors());
		// 	// $this->load->view('v_upload', $error);
		// 	redirect('product/create_product');
		// }else{
		// 	$upload = array('upload_data' => $this->upload->data());
		// 	$data['product_photo'] = 'assets/img/product/'.$upload['upload_data']['file_name'];
		// 	// $this->load->view('v_upload_sukses', $data);
		// 	$input = $this->M_Product->input($data,'products');
		// 	redirect('product');
		// }
		$input = $this->M_Product->input($data,'products');
		redirect('product');
    }

    public function edit_product($id_product){
		$product_photo = $this->input->post('product_photo');
		if($product_photo == NULL){
			$data = [
				'product_name'  	 => $this->input->post('product_name'),
				'product_code'  	 => $this->input->post('product_code'),
				'notes'       		 => $this->input->post('notes'),
				'is_active'     	 => 1,
				'product_visibility' => 'Visible',
			];
			$update = $this->M_Product->update($data,'products', $id_product);
			redirect('product');
		} else {
			$data = [
				'product_name'  	 => $this->input->post('product_name'),
				'product_code'  	 => $this->input->post('product_code'),
				'notes'       		 => $this->input->post('notes'),
				'product_photo'  	 => $$product_photo,
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
				$update = $this->M_Product->update($data,'products', $id_product);
				redirect('product');
			}
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

	public function detail_unit($id){
        $units = $this->M_Product->getUnit_by_id($id);

        $data = [
			'content' => 'detail_unit',
			'result'  => [
				'title' => 'Detail Unit',
                'menu_active' => 'product',
                'submenu_active' => 'list-unit',
                'units' 		 => $units
			],
		];
		$this->load->view('template/main',$data);
    }

	public function update_unit($id){
		$data = [
			'unit_name'  	 => $this->input->post('unit_name'),
		];
		$input = $this->M_Product->update($data,'units',$id);
		redirect('product/detail_unit/'.$id);

	}

	public function input_product_unit($id){
		$data = [
			'id_product' => $id,
			'id_unit'  	 => $this->input->post('id_unit'),
			'stock'  	 => $this->input->post('stock'),
			'pricecash'  => $this->input->post('pricecash'),
			'pricetempo' => $this->input->post('pricetempo'),
		];
		$input = $this->M_Product->input($data,'product_units');
		redirect('product/detail_product/'.$id);
	}

	public function delete_product_unit($id_product, $id_product_unit){
		$where = array ('id_product_unit' => $id_product_unit);
        $this->M_Product->delete($where, 'product_units');
        redirect('product/detail_product/'.$id_product);
	}

	public function update_product_unit($id_product, $id_product_unit){
		$data = [
			'stock'  	 => $this->input->post('stock'),
			'pricecash'  	 => $this->input->post('pricecash'),
			'pricetempo'  	 => $this->input->post('pricetempo'),
		];
		$where = [
			'id_product_unit' => $id_product_unit,
		];
		$update = $this->M_Product->update_product_unit($data,$where);
		redirect('product/detail_product/'.$id_product);
	}

}
