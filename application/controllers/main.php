<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
			'content' => 'main_new',
			'result'  => [
				'title' => 'Laporan Jackfresh',
                'menu_active' => 'dashboard',
				'submenu_active' => null,
				'data' => [
					'today_income' => $this->M_Transaction->getDayIncome(['start'=>$start,'end'=>$end])[0]->grand_total ?? 0,
					'month_income' => $this->M_Transaction->getDayIncome(['month'=>date('m'),'year'=>date('Y')])[0]->grand_total ?? 0,
					'total_income' => $this->M_Transaction->getDayIncome([])[0]->grand_total ?? 0,
					'total_transaction' => $this->M_Transaction->totalTransaction([]),
					'income_permonth' => $chart_month,
					'client_transaction' => $client_trx,
				]
			],
		];
		$this->load->view('template/main',$data);
	}

	public function change_date_trx(){
		$data = [
			'start' => $this->input->post('start_date'),
			'end' => $this->input->post('end_date'),
		];

		$result = $this->M_Transaction->getDayIncome($data)[0]->grand_total ?? 0;
		$result = 'Rp '.number_format((int)$result,0,",",".");
		
		echo json_encode($result);
	}


	public function export_dashboard(){

		$month = date('m');
		$year = date('Y');
		$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
		$data = $this->M_Transaction->clientTransaction(['month'=>$month,'year'=>$year]);
		
		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Paid');
		$drawing->setDescription('Paid');
		$drawing->setPath('assets/img/logo_excel.png'); /* put your path and image here */
		$drawing->setCoordinates('A1');
		$drawing->setWidthAndHeight(150, 150);
		$drawing->setOffsetX(28);
		$drawing->setRotation(0);
		$drawing->getShadow()->setVisible(true);
		$drawing->getShadow()->setDirection(45);
		$drawing->setWorksheet($sheet);

		// A-K

		$style_header = [
			'alignment' => [
			   'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			   'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			]
		];

		$sheet->setCellValue('E2', "LAPORAN OMZET");
		$sheet->mergeCells('E2:F2');
		$sheet->getStyle('E2')->getFont()->setBold(true);
		$sheet->setCellValue('E3', "JACK FRESH");
		$sheet->mergeCells('E3:F4');
		$sheet->getStyle('E3')->getFont()->setBold(true);

		$sheet->setCellValue('G5', "BULAN");
		$sheet->mergeCells('G5:H5');
		$sheet->getStyle('G5')->getFont()->setBold(true);
		$sheet->setCellValue('I5', date('F')." ".date('Y'));
		$sheet->mergeCells('I5:K5');
		$sheet->getStyle('A1:K8')->applyFromArray($style_header);

		$style_col = [
			'font' => ['bold' => true], 
			'color' => ['argb' => 'FFFF0000'],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER 
			],
			'borders' => [
				'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
			]
		];
		$sheet->setCellValue('A9', "NO");
		$sheet->mergeCells('A9:A11');
		$sheet->setCellValue('B9', "KLIEN");
		$sheet->mergeCells('B9:F11');
		$sheet->setCellValue('G9', "TOTAL PENJUALAN");
		$sheet->mergeCells('G9:K11');
		$sheet->getStyle('A9:A11')->applyFromArray($style_col);
		$sheet->getStyle('B9:F11')->applyFromArray($style_col);
		$sheet->getStyle('G9:K11')->applyFromArray($style_col);
		$sheet->getStyle('A9:K11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD2D2D2');

		$style_row = [
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER 
			],
			'borders' => [
				'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
			]
		];

		$no = 1;
		$numrow = 12;
		foreach($data as $d){ 
			$sheet->setCellValue('A'.$numrow, $no);
			$sheet->setCellValue('B'.$numrow, $d->client_name);
			$sheet->mergeCells('B'.$numrow.':F'.$numrow);
			$sheet->setCellValue('G'.$numrow, $d->total_transaction);
			$sheet->mergeCells('G'.$numrow.':K'.$numrow);
			
			$sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
			$sheet->getStyle('B'.$numrow.':F'.$numrow)->applyFromArray($style_row);
			$sheet->getStyle('G'.$numrow.':K'.$numrow)->applyFromArray($style_row);
			$no++;
			$numrow++;
		}
		$total =$this->M_Transaction->getDayIncome(['month'=>$month,'year'=>$year])[0]->grand_total ?? 0;
		$sheet->setCellValue('A'.$numrow, "TOTAL");
		$sheet->mergeCells('A'.$numrow.':F'.$numrow);
		$sheet->getStyle('A'.$numrow)->getFont()->setBold(true);
		$sheet->setCellValue('G'.$numrow, $total);
		$sheet->mergeCells('G'.$numrow.':K'.$numrow);
		$sheet->getStyle('G'.$numrow)->getFont()->setBold(true);
		$sheet->getStyle('A'.$numrow.':F'.$numrow)->applyFromArray($style_row);
		$sheet->getStyle('G'.$numrow.':K'.$numrow)->applyFromArray($style_row);

		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setWidth(10);
		$sheet->getColumnDimension('C')->setWidth(10);
		$sheet->getColumnDimension('D')->setWidth(10);
		$sheet->getColumnDimension('E')->setWidth(10);
		$sheet->getColumnDimension('F')->setWidth(10);
		$sheet->getColumnDimension('G')->setWidth(10);
		$sheet->getColumnDimension('H')->setWidth(10);
		$sheet->getColumnDimension('I')->setWidth(10);
		$sheet->getColumnDimension('J')->setWidth(10);
		$sheet->getColumnDimension('K')->setWidth(10);

		$sheet->getDefaultRowDimension()->setRowHeight(-1);

		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		$sheet->setTitle('Laporan Omzet JackFresh');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Omzet JackFresh '.date('F').' '.date('Y').'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}


}
