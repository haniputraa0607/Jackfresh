<!-- Page Heading -->
<?php 
	$purchase = $purchase[0];
?>
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Detail Permintaan Pembelian</p>
<div class="card shadow mb-4">
    <div class="card-body">
        <form role="form" action="<?php echo base_url().'transaction/update_purchase/'.$purchase->id_purchase; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Kode Permintaan</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="purchase_code" value="<?= $purchase->purchase_code ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Pelanggan</label>
                <div class="col-sm-4">
					<select class="form-control" name="id_client" >
						<option value="" selected disabled></option>
						<?php foreach($clients ?? [] as $client){ ?>
						<option value="<?= $client->id_client ?>" <?= $purchase->id_client == $client->id_client ? 'selected' : '' ?>><?= $client->client_name ?></option>
						<?php }  ?>
					</select>
                </div>
            </div>
			<div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Tanggal Permintaan</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="purchase_date" value="<?= date('Y-m-d', strtotime($purchase->purchase_date)) ?>" required>
                </div>
            </div>
			<div class="form-group row">
				<label for="inputEmail3" class="col-sm-2 col-form-label">Tipe Pembayaran</label>
				<div class="col-sm-4">
					<select class="form-control" name="payment_type" >
						<option value="" selected disabled></option>
						<option value="Cash" <?= $purchase->payment_type == 'Cash' ? 'selected' : '' ?>>Cash</option>
						<option value="Tempo" <?= $purchase->payment_type == 'Tempo' ? 'selected' : '' ?>>Tempo</option>
					</select>
				</div>
			</div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-4">
                    <textarea name="notes" class="form-control"><?= $purchase->notes ?></textarea>
                </div>
            </div>
			<div id="list_product">
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-2 col-form-label text-center">Nama Produk</label>
					<label for="inputEmail3" class="col-sm-2 col-form-label text-center">Unit Produk</label>
					<label for="inputEmail3" class="col-sm-1 col-form-label text-center">Jumlah</label>
				</div>
				<?php foreach($purchase_products ?? [] as $key => $pur_pro){ ?>
		
				<div class="form-group row product<?= $key ?>">
					<div class="col-sm-2">
						<select class="form-control" name="products[<?= $key ?>][id_product]" id="products_<?= $key ?>_name_product" onchange="changeProduct(<?= $key ?>)" required>
							<option value="" selected disabled></option>
							<?php foreach($products ?? [] as $product){ ?>
							<option value="<?= $product->id_product ?>" data-unit='<?= $product->units ?>' <?= $pur_pro->id_product == $product->id_product ? 'selected' : '' ?> ><?= $product->product_name ?></option>
							<?php }  ?>
						</select>
					</div>
					<div class="col-sm-2">
						<select class="form-control" name="products[<?= $key ?>][id_unit]" id="products_<?= $key ?>_id_unit" required>
							<?php foreach($products ?? [] as $prod){ ?>
								<?php if($pur_pro->id_product == $prod->id_product) { ?>
									<option value="" selected disabled></option>
									<?php foreach($prod->product_units ?? [] as $unit){ ?>
									<option value="<?= $unit->id_unit ?>" <?= $pur_pro->id_unit == $unit->id_unit ? 'selected' : '' ?>><?= $unit->unit_name ?></option>
									<?php }  ?>
								<?php }  ?>
							<?php }  ?>
						</select>
					</div>
					<div class="col-sm-1">
                    	<input type="number" step="0.1" class="form-control" name="products[<?= $key ?>][qty]" value="<?= $pur_pro->qty ?>" required>
					</div>
					<div class="col-sm-1">
						<?php if($purchase->status != 'Finished') { ?>
						<button class="btn btn-danger" <?= $key == 0 ? 'disabled' : 'onclick="deleteProduct('.$key.')"' ?> >Hapus</button>
						<?php } ?>
					</div>
				</div>
				<?php }  ?>
			</div>
			<?php if($purchase->status != 'Finished') { ?>
			<a class="btn btn-success" onclick="addProduct()">Tambah Produk</a>
			<div class="form-group row mt-4">
                <div class="col-sm-2">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
            </div>
			<?php } ?>
        </form>
    </div>
</div>

<script type="text/javascript">

	var no_product = <?= isset($purchase_products) ? count($purchase_products) : 1 ?>;
	function addProduct(){
		var html = `
		<div class="form-group row product${no_product}">
					<div class="col-sm-2">
						<select class="form-control" name="products[${no_product}][id_product]" id="products_${no_product}_name_product" onchange="changeProduct(${no_product})" required>
							<option value="" selected disabled></option>
							<?php foreach($products ?? [] as $product){ ?>
							<option value="<?= $product->id_product ?>" data-unit='<?= $product->units ?>' ><?= $product->product_name ?></option>
							<?php }  ?>
						</select>
					</div>
					<div class="col-sm-2">
						<select class="form-control" name="products[${no_product}][id_unit]" id="products_${no_product}_id_unit" required>
							<option value="" selected disabled></option>
						</select>
					</div>
					<div class="col-sm-1">
                    	<input type="number" step="0.1" class="form-control" name="products[${no_product}][qty]" required>
					</div>
					<div class="col-sm-1">
						<button class="btn btn-danger" onclick="deleteProduct(${no_product})">Hapus</button>
					</div>
				</div>
		`;
		$('#list_product').append(html);
		no_product++;						
	}

	function deleteProduct(val){
        $(`#list_product .product${val}`).remove();
	}

	function changeProduct(val){
        $(`#list_product #products_${val}_id_unit`).empty();
		var units = $(`#products_${val}_name_product option:selected`).attr('data-unit');
		units = JSON.parse(units);
		var html = `<option value="" selected disabled></option>`;
		$.each(units, function(i, data) {
			html += `<option value="${data.id_unit}">${data.unit_name}</option>`;
		})
        $(`#list_product #products_${val}_id_unit`).append(html);
	}

</script>
