<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Daftarkan Klien Baru</p>
<div class="card shadow mb-4">
    <div class="card-body">
        <form role="form" action="<?php echo base_url().'client/input_client'; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Klein</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="client_name" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Kode Klein</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="client_code" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">No. HP Klein</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="client_phone" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email Klein</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" name="client_email" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email Klein</label>
                <div class="col-sm-3">
                    <select class="form-control" name="client_type">
                        <option value="" selected disabled></option>
                        <option value="Hotel">Hotel</option>
                        <option value="Restoran">Restoran</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat Klein</label>
                <div class="col-sm-3">
                    <textarea name="client_address" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-3">
                    <textarea name="notes" class="form-control"></textarea>
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