<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Daftarkan Sebuah Produk Baru</p>
<div class="card shadow mb-4">
    <div class="card-body">
        <form role="form" action="<?php echo base_url().'product/input_product'; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Produk</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="product_name" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Kode Produk</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="product_code" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-3">
                    <textarea name="notes" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Gambar</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="product_photo" accept="image/*">
                            <label class="custom-file-label" for="exampleInputFile">Pilih Gambar</label>
                        </div>
                    </div>
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