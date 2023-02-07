<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<div class="row">
	<div class="col-md-10">
		<p class="mb-4">List of unit can use by product</p>
	</div>
	<div class="col-md-2">
		<button type="button" class="btn btn-secondary ml-4" data-toggle="modal" data-target="#modalCheckRequirement">Cek Kebutuhan</button>
	</div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pembelian</th>
                        <th>Kode Pembelian</th>
                        <th>Nama Klien</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pembelian</th>
                        <th>Kode Pembelian</th>
                        <th>Nama Klien</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($purchases ?? [] as $key => $purchase) : ?>
                    <tr>
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td class="text-center"><?php echo date('d F Y', strtotime($purchase->purchase_date)) ?></td>
                        <td class="text-center"><?php echo $purchase->purchase_code ?></td>
                        <td class="text-center"><?php echo $purchase->client_name ?? '-' ?></td>
                        <td class="text-center"><?php echo $purchase->status == 'Pending' ? 'Menunggu Produk' : ($purchase->status == 'Finished' ? 'Selesai' : 'Proses') ?></td>
                        <td class="text-center">
                            <a href="<?php echo base_url().'transaction/detail_purchase/'.$purchase->id_purchase; ?>" class="btn btn-primary btn-icon-split"><span class="text">Detail</span></a>
                            <a href="<?php echo base_url().'transaction/delete_purchase/'.$purchase->id_purchase; ?>" class="btn btn-danger btn-icon-split"><span class="text">Delete</span></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCheckRequirement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cek Kebutuhan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form role="form" action="javascript:;" onsubmit="submitCheck()" method="post" >
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Awal</label>
						<div class="col-sm-5">
							<input type="date" class="form-control" name="start_date" id="start_date" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Akhir</label>
						<div class="col-sm-5">
							<input type="date" class="form-control" name="end_date" id="end_date" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<label for="inputEmail3" class="col-sm-4 col-form-label">Client</label>
						<div class="col-sm-5">
							<select class="form-control" name="id_client" id="id_client" required>
								<option value="all" selected>Semua</option>
								<?php foreach($clients ?? [] as $client){ ?>
								<option value="<?= $client->id_client ?>"><?= $client->client_name ?></option>
								<?php }  ?>
							</select>
						</div>
					</div>
				</div>
				<div class= "output ml-2 mr-2">
						
                </div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Cek</button>
				</div>
			</form>
			
		</div>
	</div>
</div>


<script type="text/javascript">
	function submitCheck(){
		var data = {
			"start_date" : $(`#start_date`).val(),
			"end_date" : $(`#end_date`).val(),
			"id_client" : $("#id_client option:selected").val()
		}
		$.ajax({
        type: 'POST',
        url: "<?php echo base_url().'transaction/check'; ?>",
        data: data,
		dataType: 'json',
        success: function(response) {
			$('#modalCheckRequirement .output').empty();
			var tr = '';
			response.forEach(function(data, index){
				tr += `
					<tr>
						<td>${data.product_name}</td>
						<td class="text-center">${data.unit_name}</td>
						<td class="text-center">${data.qty}</td>
					</tr>
				`
			})
			var html = `
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Product Name</th>
							<th class="text-center">Unit</th>
							<th class="text-center">Stock</th>
						</tr>
					</thead>
					<tbody>
						${tr}
					</tbody>
				</table>
			`;
			$('#modalCheckRequirement .output').append(html);
        }
    });
	}
</script>
