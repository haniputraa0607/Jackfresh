<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->library('form_validation');
		$this->load->model('M_Client');

		if(!$this->session->userdata('logged_in')){
			redirect ('auth/index');
		}
	}

	public function index(){
		$clients = $this->M_Client->getClient([])->result();
		$data = [
			'content' => 'list_client',
			'result'  => [
				'title' 		 => 'Daftar Klien',
				'menu_active' 	 => 'client',
				'submenu_active' => 'list-client',
				'clients' 		 => $clients
			],
		];
		$this->load->view('template/main',$data);
	}

	public function create_client(){
		$data = [
			'content' => 'create_client',
			'result'  => [
				'title' => 'Pelanggan Baru',
				'menu_active' => 'client',
				'submenu_active' => 'create-client'
			],
		];
		$this->load->view('template/main',$data);
	}

	public function detail_client(){
		$clients = $this->M_Client->getClient_by_id($this->uri->segment(3));

		$data = [
			'content' => 'detail_client',
			'result'  => [
				'title' 		 => 'Detail Klien',
				'menu_active' 	 => 'client',
				'submenu_active' => 'detail-client',
				'clients' 		 => $clients
			],
		];
		$this->load->view('template/main',$data);
	}

	public function input_client(){
		$data = [
			'client_name'  	 => $this->input->post('client_name'),
			'client_code'  	 => $this->input->post('client_code'),
			'client_phone'   => $this->input->post('client_phone'),
			'client_email'   => $this->input->post('client_email'),
			'client_type'  	 => $this->input->post('client_type'),
			'client_address' => $this->input->post('client_address'),
			'notes'  	     => $this->input->post('notes'),
		];
		$input = $this->M_Client->input($data,'clients');
		redirect('client');
	}

	public function edit_client($id){
		$data = [
			'client_name'  	 => $this->input->post('client_name'),
			'client_code'  	 => $this->input->post('client_code'),
			'client_phone'   => $this->input->post('client_phone'),
			'client_email'   => $this->input->post('client_email'),
			'client_type'  	 => $this->input->post('client_type'),
			'client_address' => $this->input->post('client_address'),
			'notes'  	     => $this->input->post('notes'),
		];
		$input = $this->M_Client->update($data,'clients',$id);
		redirect('client');
	}

	public function delete($id){
		$where = array ('id_client' => $id);
		$this->M_Client->delete($where, 'clients');
		redirect('client');
	}

}
