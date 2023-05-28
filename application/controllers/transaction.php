<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Transaction extends CI_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->library('form_validation');
		$this->load->model('M_Transaction');
		$this->load->model('M_Client');
		$this->load->model('M_Product');

		if(!$this->session->userdata('logged_in')){
			redirect ('auth/index');
		}
	}

    public function index(){
		$transactions = $this->M_Transaction->getTransaction([])->result();
		$data = [
			'content' => 'list_transaction',
			'result'  => [
				'title' => 'Daftar Transaksi',
                'menu_active' => 'transaction',
                'submenu_active' => 'list-transaction',
				'transactions' 	 => $transactions
			],
		];
		$this->load->view('template/main',$data);
    }

    public function create_transaction(){
    	$id_transaction = $this->M_Transaction->getID_transaction();
		$clients = $this->M_Client->getClient([])->result();
		$products = $this->M_Product->getProduct([])->result();
		$products = array_map(function($val){
			$val->units = $this->M_Product->getProductUnits($val->id_product)->result();
			$val->units = json_encode($val->units);
			// $val->units = str_replace('"', '\'', $val->units);
			return $val;
		},$products);
		$data = [
			'content' => 'create_transaction',
			'result'  => [
				'title' => 'Buat Transaksi Baru',
                'menu_active' => 'transaction',
                'submenu_active' => 'create-transaction',
                'id_transaction' => $id_transaction,
				'clients' 	 => $clients,
				'products' 	 => $products
			],
		];
		$this->load->view('template/main',$data);
    }

    public function purchase_list(){
		$purchases = $this->M_Transaction->getPurchase([])->result();
		$clients = $this->M_Client->getClient([])->result();
		$data = [
			'content' => 'list_purchase',
			'result'  => [
				'title' 		 => 'Daftar Permintaan Pembelian',
                'menu_active' 	 => 'transaction',
                'submenu_active' => 'list-purchase',
				'purchases' 	 => $purchases,
				'clients' 	 	 => $clients
			],
		];
		$this->load->view('template/main',$data);
    }

    public function create_purchase(){
    	$id_purchase = $this->M_Transaction->getID_purchase();
		$clients = $this->M_Client->getClient([])->result();
		$products = $this->M_Product->getProduct([])->result();
		$products = array_map(function($val){
			$val->units = $this->M_Product->getProductUnits($val->id_product)->result();
			$val->units = json_encode($val->units);
			// $val->units = str_replace('"', '\'', $val->units);
			return $val;
		},$products);
		$data = [
			'content' => 'create_purchase',
			'result'  => [
				'title' => 'Buat Permintaan Baru',
                'menu_active' => 'transaction',
                'submenu_active' => 'create-purchase',
                'id_purchase' => $id_purchase,
				'clients' 	 => $clients,
				'products' 	 => $products
			],
		];

		$this->load->view('template/main',$data);
    }

	public function delete($id){
		$where = array ('id_transaction' => $id);
        $this->M_Transaction->delete($where, 'transactions');
        redirect('transaction');
	}

	public function delete_purchase($id){
		$where = array ('id_purchase' => $id);
        $this->M_Transaction->delete($where, 'purchase');
        redirect('transaction/purchase_list');
	}

	public function input_transaction(){
		$data = [
			'transaction_code' => $this->input->post('transaction_code'),
			'id_client' => $this->input->post('id_client') ?? null,
			'transaction_date' => $this->input->post('transaction_date'),
			'payment_type' => $this->input->post('payment_type'),
			'notes' => $this->input->post('notes'),
		];
		$product = $this->input->post('products') ?? null;
		$input = $this->M_Transaction->inputTransaction($data, $product);
		redirect('transaction');
	}

	public function input_purchase(){
		$data = [
			'purchase_code' => $this->input->post('purchase_code'),
			'id_client' => $this->input->post('id_client') ?? null,
			'purchase_date' => $this->input->post('purchase_date'),
			'payment_type' => $this->input->post('payment_type'),
			'notes' => $this->input->post('notes'),
			'status' => 'Pending'
		];
		$product = $this->input->post('products') ?? null;
		$input = $this->M_Transaction->inputPurchase($data, $product);
		redirect('transaction/purchase_list');
	}

	public function detail_purchase($id){
		$purchase = $this->M_Transaction->getPurchase(['purchase.id_purchase' => $id])->result();
		$purchase_products = $this->M_Transaction->purchaseProduct($id)->result();
		$clients = $this->M_Client->getClient([])->result();
		$products = $this->M_Product->getProduct([])->result();
		$products = array_map(function($val){
			$val->units = $this->M_Product->getProductUnits($val->id_product)->result();
			$val->product_units = $val->units;
			$val->units = json_encode($val->units);
			// $val->units = str_replace('"', '\'', $val->units);
			return $val;
		},$products);
		// var_dump($products);
		$data = [
			'content' => 'detail_purchase',
			'result'  => [
				'title' => 'Detail Permintaan',
                'menu_active' => 'transaction',
                'submenu_active' => 'list-purchase',
				'purchase' => $purchase,
				'purchase_products' => $purchase_products,
				'clients' 	 => $clients,
				'products' 	 => $products
			],
		];

		$this->load->view('template/main',$data);
	}

	public function detail($id){
		$transaction = $this->M_Transaction->getTransaction(['transactions.id_transaction' => $id])->result();
		$products = $this->M_Transaction->transactionProduct($id)->result();
		$data = [
			'content' => 'detail_transaction',
			'result'  => [
				'title' => 'Detail Transaksi',
                'menu_active' => 'transaction',
                'submenu_active' => 'list-transaction',
				'transaction' 	 => $transaction,
				'products' 	 => $products
			],
		];

		$this->load->view('template/main',$data);
	}

	public function update_purchase($id){
		$data = [
			'purchase_code' => $this->input->post('purchase_code'),
			'id_client' => $this->input->post('id_client') ?? null,
			'purchase_date' => $this->input->post('purchase_date'),
			'payment_type' => $this->input->post('payment_type'),
			'notes' => $this->input->post('notes'),
			'status' => 'Pending'
		];
		$product = $this->input->post('products') ?? null;
		$where = [
			'id_purchase' => $id
		];
		$input = $this->M_Transaction->updatePurhcase($data, $product,$where);
		redirect('transaction/detail_purchase/'.$id);

	}

	public function check(){
		$data = [
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date'),
			'id_client' => $this->input->post('id_client')
		];

		$need = $this->M_Transaction->checkNeed($data)->result();
		$stocks = $this->M_Transaction->checkStock()->result();
		$need = array_map(function($val) use($stocks){
			foreach($stocks ?? [] as $stock){
				if($val->id_product_unit == $stock->id_product_unit){
					$val->qty = $val->qty - $stock->stock;
				}
			}
			return $val;
		},$need);
		
		echo json_encode($need);

	}


	public function nota($id_transaction){

		$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();

		$transaction = $this->M_Transaction->getTransaction(['transactions.id_transaction' => $id_transaction])->result()[0];
		$products = $this->M_Transaction->transactionProduct($id_transaction)->result();

		$style_header = [
			'alignment' => [
			   'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			   'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			]
		];

		// A-Q

		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Paid');
		$drawing->setDescription('Paid');
		$drawing->setPath('assets/img/logo_excel.png'); /* put your path and image here */
		$drawing->setCoordinates('B2');
		$drawing->setWidthAndHeight(180, 180);
		$drawing->setOffsetX(28);
		$drawing->setRotation(0);
		$drawing->getShadow()->setVisible(true);
		$drawing->getShadow()->setDirection(45);
		$drawing->setWorksheet($sheet);

		$sheet->setCellValue('G2', "NOTA PENJUALAN");
		$sheet->mergeCells('G2:K2');
		$sheet->getStyle('G2')->getFont()->setBold(true);
		$sheet->setCellValue('G3', "JACK FRESH");
		$sheet->mergeCells('G3:K4');
		$sheet->getStyle('G3')->getFont()->setBold(true);
		
		$sheet->setCellValue('M4', "NO TRANSAKSI");
		$sheet->mergeCells('M4:N4');
		$sheet->getStyle('M4')->getFont()->setBold(true);
		$sheet->setCellValue('O4', $transaction->transaction_code);
		$sheet->mergeCells('O4:Q4');
		$sheet->setCellValue('M5', "TGL TRANSAKSI");
		$sheet->mergeCells('M5:N5');
		$sheet->getStyle('M5')->getFont()->setBold(true);
		$sheet->setCellValue('O5', date('d F Y', strtotime($transaction->transaction_date)));
		$sheet->mergeCells('O5:Q5');
		$sheet->setCellValue('M6', "KLIEN");
		$sheet->mergeCells('M6:N6');
		$sheet->getStyle('M6')->getFont()->setBold(true);
		$sheet->setCellValue('O6', $transaction->client_name);
		$sheet->mergeCells('O6:Q6');
		$sheet->setCellValue('M7', "TIPE PEMBAYARAN");
		$sheet->mergeCells('M7:N7');
		$sheet->getStyle('M7')->getFont()->setBold(true);
		$sheet->setCellValue('O7', $transaction->payment_type);
		$sheet->mergeCells('O7:Q7');
		$sheet->setCellValue('G8', "JL. ANGGUR VI NO");
		$sheet->mergeCells('G8:K8');
		$sheet->setCellValue('G9', "JAJAR LAWEYAN SURAKARTA");
		$sheet->mergeCells('G9:K9');
		$sheet->setCellValue('G10', "TELP/WA (0271) 734923 / 085642194292");
		$sheet->mergeCells('G10:K10');
		$sheet->getStyle('A1:Q12')->applyFromArray($style_header);

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

		$sheet->setCellValue('A13', "NO");
		$sheet->mergeCells('A13:A15');
		$sheet->setCellValue('B13', "PRODUK");
		$sheet->mergeCells('B13:F15');
		$sheet->setCellValue('G13', "JUMLAH (PCS/LUSIN)");
		$sheet->mergeCells('G13:I15');
		$sheet->setCellValue('J13', "HARGA (REFER TO TIPE BAYAR)");
		$sheet->mergeCells('J13:L15');
		$sheet->setCellValue('M13', "TOTAL");
		$sheet->mergeCells('M13:Q15');
		$sheet->getStyle('A13:A15')->applyFromArray($style_col);
		$sheet->getStyle('B13:F15')->applyFromArray($style_col);
		$sheet->getStyle('G13:I15')->applyFromArray($style_col);
		$sheet->getStyle('J13:L15')->applyFromArray($style_col);
		$sheet->getStyle('M13:Q15')->applyFromArray($style_col);
		$sheet->getStyle('A13:Q15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD2D2D2');

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
		$numrow = 16;
		foreach($products as $prod){ 
			$sheet->setCellValue('A'.$numrow, $no);
			$sheet->setCellValue('B'.$numrow, $prod->product_name);
			$sheet->mergeCells('B'.$numrow.':F'.$numrow);

			$sheet->setCellValue('G'.$numrow, $prod->qty.' '.$prod->unit_name);
			$sheet->mergeCells('G'.$numrow.':I'.$numrow);

			$sheet->setCellValue('J'.$numrow, $transaction->payment_type == 'Cash' ? $prod->pricecash : $prod->pricetempo);
			$sheet->mergeCells('J'.$numrow.':L'.$numrow);

			$sheet->setCellValue('M'.$numrow, $prod->price);
			$sheet->mergeCells('M'.$numrow.':Q'.$numrow);
			

			$sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
			$sheet->getStyle('B'.$numrow.':F'.$numrow)->applyFromArray($style_row);
			$sheet->getStyle('G'.$numrow.':I'.$numrow)->applyFromArray($style_row);
			$sheet->getStyle('J'.$numrow.':L'.$numrow)->applyFromArray($style_row);
			$sheet->getStyle('M'.$numrow.':Q'.$numrow)->applyFromArray($style_row);

			$no++;
			$numrow++;
		}

		$style_ttd = [
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER 
			]
		];
		$style_ttd_under = [
			'borders' => [
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
			]
		];

		$row_ttd = $numrow + 2;
		$row_ttd_under = $numrow + 5;
		$sheet->setCellValue('B'.$row_ttd, "Tanda Terima");
		$sheet->mergeCells('B'.$row_ttd.':C'.$row_ttd);
		$sheet->setCellValue('F'.$row_ttd, "Hormat Kami");
		$sheet->mergeCells('F'.$row_ttd.':G'.$row_ttd);
		$sheet->getStyle('B'.$row_ttd.':C'.$row_ttd)->applyFromArray($style_ttd);
		$sheet->getStyle('F'.$row_ttd.':G'.$row_ttd)->applyFromArray($style_ttd);
		$sheet->mergeCells('B'.$row_ttd_under.':C'.$row_ttd_under);
		$sheet->mergeCells('F'.$row_ttd_under.':G'.$row_ttd_under);
		$sheet->getStyle('B'.$row_ttd_under.':C'.$row_ttd_under)->applyFromArray($style_ttd_under);
		$sheet->getStyle('F'.$row_ttd_under.':G'.$row_ttd_under)->applyFromArray($style_ttd_under);

		$row_sub = $numrow + 6;
		$sheet->setCellValue('J'.$row_sub, "SUB TOTAL");
		$sheet->mergeCells('J'.$row_sub.':L'.$row_sub);
		$sheet->setCellValue('M'.$row_sub, $transaction->grand_total);
		$sheet->mergeCells('M'.$row_sub.':Q'.$row_sub);
		$sheet->getStyle('J'.$row_sub.':L'.$row_sub)->applyFromArray($style_row);
		$sheet->getStyle('M'.$row_sub.':Q'.$row_sub)->applyFromArray($style_row);


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
		$sheet->getColumnDimension('L')->setWidth(10);
		$sheet->getColumnDimension('M')->setWidth(10);
		$sheet->getColumnDimension('N')->setWidth(10);
		$sheet->getColumnDimension('O')->setWidth(10);
		$sheet->getColumnDimension('P')->setWidth(10);
		$sheet->getColumnDimension('Q')->setWidth(10);

		$sheet->getDefaultRowDimension()->setRowHeight(-1);

		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		$sheet->setTitle("NOTA PENJUALAN");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Nota Penjualan '.$transaction->client_name.' '.date('d F Y').'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');

	}

	public function export_requirement($start,$end,$id_client){

		$data = [
			'start_date' => $start,
			'end_date' => $end,
			'id_client' => $id_client
		];

		$cleints = [];
		if($data['id_client'] != 'all'){
			$cleints = $this->M_Client->getClient(['id_client'=>$data['id_client']])->result()[0] ?? [];
		}

		$need = $this->M_Transaction->checkNeed($data)->result();
		$stocks = $this->M_Transaction->checkStock()->result();
		$need = array_map(function($val) use($stocks){
			foreach($stocks ?? [] as $stock){
				if($val->id_product_unit == $stock->id_product_unit){
					$val->qty = $val->qty - $stock->stock;
				}
			}
			return $val;
		},$need);

		$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();

		// A-M
		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Paid');
		$drawing->setDescription('Paid');
		$drawing->setPath('assets/img/logo_excel.png'); /* put your path and image here */
		$drawing->setCoordinates('B2');
		$drawing->setWidthAndHeight(150, 150);
		$drawing->setOffsetX(28);
		$drawing->setRotation(0);
		$drawing->getShadow()->setVisible(true);
		$drawing->getShadow()->setDirection(45);
		$drawing->setWorksheet($sheet);

		$style_header = [
			'alignment' => [
			   'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			   'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			]
		];

		$sheet->setCellValue('F2', "KEBUTUHAN PER HARI");
		$sheet->mergeCells('F2:I2');
		$sheet->getStyle('F2')->getFont()->setBold(true);
		$sheet->setCellValue('F3', "JACK FRESH");
		$sheet->mergeCells('F3:I4');
		$sheet->getStyle('F3')->getFont()->setBold(true);

		$sheet->setCellValue('J5', "DARI");
		$sheet->mergeCells('J5:K5');
		$sheet->getStyle('J5')->getFont()->setBold(true);
		$sheet->setCellValue('L5', date('d F Y', strtotime($data['start_date'])));
		$sheet->mergeCells('L5:N5');		
		$sheet->setCellValue('J6', "SAMPAI");
		$sheet->mergeCells('J6:K6');
		$sheet->getStyle('J6')->getFont()->setBold(true);
		$sheet->setCellValue('L6', date('d F Y', strtotime($data['end_date'])));
		$sheet->mergeCells('L6:N6');	
		$sheet->setCellValue('J7', "KLIEN");
		$sheet->mergeCells('J7:K7');
		$sheet->getStyle('J7')->getFont()->setBold(true);	
		$sheet->setCellValue('L7', $data['id_client'] == 'all' ? 'SEMUA' : $cleints->client_name);
		$sheet->mergeCells('L7:N7');	

		$sheet->setCellValue('F8', "JL. ANGGUR VI NO");
		$sheet->mergeCells('F8:I8');
		$sheet->setCellValue('F9', "JAJAR LAWEYAN SURAKARTA");
		$sheet->mergeCells('F9:I9');
		$sheet->setCellValue('F10', "TELP/WA (0271) 734923 / 085642194292");
		$sheet->mergeCells('F10:I10');
		$sheet->getStyle('A1:N12')->applyFromArray($style_header);

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

		$sheet->setCellValue('A13', "NO");
		$sheet->mergeCells('A13:A15');
		$sheet->setCellValue('B13', "PRODUK");
		$sheet->mergeCells('B13:F15');
		$sheet->setCellValue('G13', "UNIT (PCS/LUSIN)");
		$sheet->mergeCells('G13:I15');
		$sheet->setCellValue('J13', "JUMLAH KEBUTUHAN");
		$sheet->mergeCells('J13:N15');
		$sheet->getStyle('A13:A15')->applyFromArray($style_col);
		$sheet->getStyle('B13:F15')->applyFromArray($style_col);
		$sheet->getStyle('G13:I15')->applyFromArray($style_col);
		$sheet->getStyle('J13:N15')->applyFromArray($style_col);
		$sheet->getStyle('A13:N15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD2D2D2');

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
		$numrow = 16;
		foreach($need as $prod){ 
			$sheet->setCellValue('A'.$numrow, $no);
			$sheet->setCellValue('B'.$numrow, $prod->product_name);
			$sheet->mergeCells('B'.$numrow.':F'.$numrow);

			$sheet->setCellValue('G'.$numrow, $prod->qty.' '.$prod->unit_name);
			$sheet->mergeCells('G'.$numrow.':I'.$numrow);

			$sheet->setCellValue('J'.$numrow, $prod->qty);
			$sheet->mergeCells('J'.$numrow.':N'.$numrow);

			$sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
			$sheet->getStyle('B'.$numrow.':F'.$numrow)->applyFromArray($style_row);
			$sheet->getStyle('G'.$numrow.':I'.$numrow)->applyFromArray($style_row);
			$sheet->getStyle('J'.$numrow.':N'.$numrow)->applyFromArray($style_row);

			$no++;
			$numrow++;
		}

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
		$sheet->getColumnDimension('L')->setWidth(10);
		$sheet->getColumnDimension('M')->setWidth(10);
		$sheet->getColumnDimension('N')->setWidth(10);

		$sheet->getDefaultRowDimension()->setRowHeight(-1);

		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		$sheet->setTitle("KEBUTUHAN");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		if($data['id_client'] == 'all'){
			header('Content-Disposition: attachment; filename="Kebutuhan Semua '.date('d F Y').'.xlsx"'); // Set nama file excel nya
		}else{
			header('Content-Disposition: attachment; filename="Kebutuhan '.$cleints->client_name.' '.date('d F Y').'.xlsx"'); // Set nama file excel nya
		}
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}

}
