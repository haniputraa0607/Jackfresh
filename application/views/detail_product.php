<!-- Page Heading -->
<?php 
	$product_units = [];
	$product_units = array_column($units, 'id_unit');
?>
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Detail data produk yang terdaftar</p>
<div class="row">
	<div class="col-lg-6">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-secondary">Detail</h6>
			</div>
			<div class="card-body">
				<form role="form" action="<?php echo base_url().'product/edit_product/'.$products->id_product; ?>" method="post" enctype="multipart/form-data">
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-4 col-form-label">Nama Produk</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="product_name" value="<?= $products->product_name ?>" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-4 col-form-label">Kode Produk</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="product_code" value="<?= $products->product_code; ?>" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-4 col-form-label">Catatan</label>
						<div class="col-sm-6">
							<textarea name="notes" class="form-control"><?php echo $products->notes ?> </textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-4 col-form-label">Gambar</label>
						<div class="col-sm-6">
							<div class="input-group">
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="product_photo" accept="image/*" > 
									<label class="custom-file-label" for="exampleInputFile">Pilih Gambar</label>
									<!-- <?php echo $products->product_photo ?> -->
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-4"></div>
						<div class="col-sm-10">
							<button type="submit" class="btn btn-primary">Edit</button>
						</div>
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
					<table class="table table-bordered table_unit" cellspacing="0">
						<thead class="text-center">
							<tr>
								<th>Unit</th>
								<th>Stock</th>
								<th>Harga Cash</th>
								<th>Harga Tempo</th>
								<th>Detail</th>
							</tr>
						</thead>
						<tbody class="text-center">
							<?php foreach ($units ?? [] as $key => $unit){ ?>
								<tr>
									<td><?php echo $unit->unit_name ?></td>
									<td><?php echo $unit->stock ?></td>
									<td><?php echo $unit->pricecash ?></td>
									<td><?php echo $unit->pricetempo ?></td>

									<td class="text-center">
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal<?php echo $unit->id_product_unit; ?>">Detail</button>
										<a href="<?php echo base_url().'product/delete_product_unit/'.$products->id_product.'/'.$unit->id_product_unit; ?>" class="btn btn-danger btn-icon-split"><span class="text">Hapus</span></a>
									</td>
								</tr>
								<div class="modal fade" id="modal<?php echo $unit->id_product_unit; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Detail <?= $products->product_name.' Unit '.$unit->unit_name ?> </h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<form role="form" action="<?php echo base_url().'product/update_product_unit/'.$products->id_product.'/'.$unit->id_product_unit; ?>" method="post" enctype="multipart/form-data">
													<div class="form-group row">
														<div class="col-sm-2"></div>
														<label for="inputEmail3" class="col-sm-3 col-form-label">Unit</label>
														<div class="col-sm-4">
															<input type="text" class="form-control" readonly value="<?php echo $unit->unit_name ?>">
														</div>
													</div>
													<div class="form-group row">
														<div class="col-sm-2"></div>
														<label for="inputEmail3" class="col-sm-3 col-form-label">Stock</label>
														<div class="col-sm-4">
															<input type="number" step="0.1" class="form-control" name="stock" required value="<?php echo $unit->stock ?>">
														</div>
													</div>
													<div class="form-group row">
														<div class="col-sm-2"></div>
														<label for="inputEmail3" class="col-sm-3 col-form-label">Harga Cash</label>
														<div class="col-sm-4">
															<input type="number" class="form-control" name="pricecash" required value="<?php echo $unit->pricecash ?>">
														</div>
													</div>
													<div class="form-group row">
														<div class="col-sm-2"></div>
														<label for="inputEmail3" class="col-sm-3 col-form-label">Harga Tempo</label>
														<div class="col-sm-4">
															<input type="number" class="form-control" name="pricetempo" required value="<?php echo $unit->pricetempo ?>">
														</div>
													</div>
											</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-primary">Update</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalAddNewUnitProduct">
					Tambah Unit
				</button>
			</div>
		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalAddNewUnitProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Unit Baru</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form role="form" action="<?php echo base_url().'product/input_product_unit/'.$products->id_product; ?>" method="post" enctype="multipart/form-data">
					<div class="form-group row">
						<div class="col-sm-2"></div>
						<label for="inputEmail3" class="col-sm-3 col-form-label">Unit</label>
						<div class="col-sm-4">
							<select class="form-control" name="id_unit" required>
								<option value="" selected disabled></option>
								<?php foreach($all_units ?? [] as $all_unit){ ?>
									<?php if(!in_array($all_unit->id_unit,$product_units)) { ?>	
										<option value="<?= $all_unit->id_unit ?>" ><?= $all_unit->unit_name ?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2"></div>
						<label for="inputEmail3" class="col-sm-3 col-form-label">Stock</label>
						<div class="col-sm-4">
							<input type="number" step="0.1" class="form-control" name="stock" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2"></div>
						<label for="inputEmail3" class="col-sm-3 col-form-label">Harga Cash</label>
						<div class="col-sm-4">
							<input type="number" class="form-control" name="pricecash" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2"></div>
						<label for="inputEmail3" class="col-sm-3 col-form-label">Harga Tempo</label>
						<div class="col-sm-4">
							<input type="number" class="form-control" name="pricetempo" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalEditUnitProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Unit/Harga Produk</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form role="form" action="<?php echo base_url().'product/edit_product_unit/'.$products->id_product; ?>" method="post" enctype="multipart/form-data">
						<div class="form-group row">
							<div class="col-sm-2"></div>
							<label for="inputEmail3" class="col-sm-3 col-form-label">Unit</label>
							<div class="col-sm-4">
								<select class="form-control" name="id_unit" required>
									<option value="" selected disabled></option>
									<?php foreach($all_units ?? [] as $all_unit){ ?>
										
											<option value="<?= $all_unit->id_unit ?>" ><?= $all_unit->unit_name ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group row">
								<div class="col-sm-2"></div>
								<label for="inputEmail3" class="col-sm-3 col-form-label">Stock</label>
								<div class="col-sm-4">
									<input type="text" step="0.1" class="form-control" name="stock" value="<?= $value_product_units->stock ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-2"></div>
								<label for="inputEmail3" class="col-sm-3 col-form-label">Harga Cash</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="pricecash"  value="<?= $value_product_units->pricecash ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-2"></div>
								<label for="inputEmail3" class="col-sm-3 col-form-label">Harga Tempo</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="pricetempo"  value="<?= $value_product_units->pricetempo ?>" required>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Edit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<style> 
 .table_unit{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>
