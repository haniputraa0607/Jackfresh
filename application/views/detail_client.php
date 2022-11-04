<!-- Page Heading -->

<?php 
 foreach ($clients as $row) :     
      $client_name = $row->client_name;
      $client_code = $row->client_code;
      $client_phone = $row->client_phone;
      $client_email = $row->client_email;
      $client_type = $row->client_type;
      $client_address = $row->client_address;
      $notes = $row->notes;

  endforeach;
?>



<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Edit Info Klien</p>
<div class="card shadow mb-4">
    <div class="card-body">
        <form role="form" action="<?php echo base_url().'client/edit_client'; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Klein</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="client_name" value="<?= $client_name; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Kode Klein</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="client_code" value="<?= $client_code; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">No. HP Klein</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="client_phone" value="<?= $client_phone; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email Klein</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" name="client_email" value="<?= $client_email; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Jenis Klein</label>
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
                    <textarea name="client_address" class="form-control"> <?php echo $client_address ?> </textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-3">
                    <textarea name="notes" class="form-control"> <?php echo $notes ?> </textarea>
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