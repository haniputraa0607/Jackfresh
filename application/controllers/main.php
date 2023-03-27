<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct(){
		parent::__construct();		

		if(!$this->session->userdata('logged_in')){
			redirect ('auth/index');
		}
		$this->load->library('form_validation');
		$this->load->model('M_Transaction');

	}

	public function index()
	{
		$start = date('Y-m-d 00:00:00');
		$end = date('Y-m-d 00:00:00',strtotime("+1 days"));

		$chart_month = [];
		$client_trx = $this->M_Transaction->clientTransaction(['month'=>date('m'),'year'=>date('Y')]);
		for($i = 1; $i <= 12; $i++){
			$chart_month[] = $this->M_Transaction->getDayIncome(['month'=>$i,'year'=>date('Y')])[0]->grand_total;
		}
		
		$data = [
			'content' => 'tes_main',
			'result'  => [
				'title' => 'Laporan Jackfresh',
                'menu_active' => 'dashboard',
				'submenu_active' => null,
				'data' => [
					'today_income' => $this->M_Transaction->getDayIncome(['start'=>$start,'end'=>$end])[0]->grand_total,
					'month_income' => $this->M_Transaction->getDayIncome(['month'=>date('m'),'year'=>date('Y')])[0]->grand_total,
					'total_income' => $this->M_Transaction->getDayIncome([])[0]->grand_total,
					'total_transaction' => $this->M_Transaction->totalTransaction(),
					'income_permonth' => $chart_month,
					'client_transaction' => $client_trx,
				]
			],
		];
		$this->load->view('template/main',$data);
	}
}
