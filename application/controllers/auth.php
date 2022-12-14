<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();	
		$this->load->library('form_validation');
		$this->load->model('User');

	}

	public function index(){
		if($this->session->userdata('logged_in')){
			redirect ('dashboard');
		}
		$this->load->view('login');
	}

	public function login(){

		$username= $this->input->post("username");
		$password= $this->input->post("password");
		
		//cek input validation
		$this->form_validation->set_rules('username','Username','trim|required|max_length[10]');
		$this->form_validation->set_rules('password','Password','trim|required|max_length[10]');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message','Input username atau password tidak valid!');
			$this->session->set_flashdata('type','danger');
			redirect('/');
		}
		else
		{
			$statuslogin = $this->User->checklogin($username, $password);
			if($statuslogin){
				redirect('main/index');
			}
			else{
				$this->session->set_flashdata('message','Username atau password salah!');
				$this->session->set_flashdata('type','danger');
				redirect('/');
			}
		}
		
	}

	public function logout(){
		$this->User->logout();
		redirect('auth');
	}
}
?>