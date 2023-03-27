<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Daftarkan Sebuah Unit Baru</p>
<div class="card shadow mb-4">
    <div class="card-body">
        <form role="form" action="<?php echo base_url().'product/input_unit'; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Unit</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="unit_name" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </div>
        </form>
    </div>
</div>
