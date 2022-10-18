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
				'title' 		 => 'List Client',
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
				'title' => 'Klien Baru',
                'menu_active' => 'client',
                'submenu_active' => 'create-client'
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

}
