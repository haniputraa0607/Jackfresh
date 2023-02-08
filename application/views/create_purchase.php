<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Buat Permintaan Pembelian Baru</p>
<div class="card shadow mb-4">
    <div class="card-body">
        <form role="form" action="<?php echo base_url().'transaction/input_purchase'; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Kode Permintaan</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="purchase_code" value="<?php echo $id_purchase; ?>" required readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Pelanggan</label>
                <div class="col-sm-4">
					<select class="form-control" name="id_client" >
						<option value="" selected disabled></option>
						<?php foreach($clients ?? [] as $client){ ?>
						<option value="<?= $client->id_client ?>" ><?= $client->client_name ?></option>
						<?php }  ?>
					</select>
                </div>
            </div>
			<div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Tanggal Permintaan</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="purchase_date" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-4">
                    <textarea name="notes" class="form-control"></textarea>
                </div>
            </div>
			<div id="list_product">
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-2 col-form-label text-center">Nama Produk</label>
					<label for="inputEmail3" class="col-sm-2 col-form-label text-center">Unit Produk</label>
					<label for="inputEmail3" class="col-sm-1 col-form-label text-center">Jumlah</label>
				</div>
				<div class="form-group row product0">
					<div class="col-sm-2">
						<select class="form-control" name="products[0][id_product]" id="products_0_name_product" onchange="changeProduct(0)" required>
							<option value="" selected disabled></option>
							<?php foreach($products ?? [] as $product){ ?>
							<option value="<?= $product->id_product ?>" data-unit='<?= $product->units ?>' ><?= $product->product_name ?></option>
							<?php }  ?>
						</select>
					</div>
					<div class="col-sm-2">
						<select class="form-control" name="products[0][id_unit]" id="products_0_id_unit" required>
							<option value="" selected disabled></option>
						</select>
					</div>
					<div class="col-sm-1">
                    	<input type="number" class="form-control" name="products[0][qty]" required>
					</div>
					<div class="col-sm-1">
						<button class="btn btn-danger" disabled>Hapus</button>
					</div>
				</div>
			</div>
			<a class="btn btn-success" onclick="addProduct()">Tambah Produk</a>
			<div class="form-group row mt-4">
                <div class="col-sm-2">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

	var no_product = 1;
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
                    	<input type="number" class="form-control" name="products[${no_product}][qty]" required>
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
