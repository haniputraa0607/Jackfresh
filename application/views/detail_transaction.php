<!-- Page Heading -->
<?php 
	$transaction = $transaction[0];
?>
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Detail Transaksi Pembelian</p>
<div class="row">
	<div class="col-lg-6">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-secondary">Transaksi</h6>
			</div>
			<div class="card-body">
				<form role="form" action="<?php echo base_url().'transaction/input_transaction'; ?>" method="post" enctype="multipart/form-data">
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Kode Transaksi</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="transaction_code" value="<?= $transaction->transaction_code ?>" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Pelanggan</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" value="<?= $transaction->client_name ?>" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Tanggal Permintaan</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" value="<?= date('j F Y', strtotime($transaction->transaction_date)) ?>" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Tipe Pembayaran</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" value="<?= $transaction->payment_type ?>" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Catatan</label>
						<div class="col-sm-6">
							<textarea name="notes" class="form-control" disabled><?= $transaction->notes ?></textarea>
						</div>
					</div>
					<div id="list_product">
						
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-secondary">Unit</h6>
			</div>
			<div class="card-body">
			<div class="table">
					<table class="table table-bordered" cellspacing="0">
						<thead class="text-center">
							<tr>
								<th>Nama</th>
								<th>Unit</th>
								<th>Jumlah</th>
								<th>Harga</th>
							</tr>
						</thead>
						<tbody class="text-center">
							<?php foreach ($products ?? [] as $key => $product){ ?>
								<tr>
									<td><?php echo $product->product_name ?></td>
									<td><?php echo $product->unit_name ?></td>
									<td><?php echo $product->qty ?></td>
									<td><?php echo $product->price ?></td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="3">Total</td>
								<td><?php echo $transaction->grand_total ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

