<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Daftar Transaksi Setiap Klien</p>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Klien</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot class="text-center">
                    <tr>
                         <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Klien</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($transactions ?? [] as $key => $transaction) : ?>
                    <tr>
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td class="text-center"><?php echo date('d F Y', strtotime($transaction->transaction_date)) ?></td>
                        <td class="text-center"><?php echo $transaction->transaction_code ?></td>
                        <td class="text-center"><?php echo $transaction->client_name ?? '-' ?></td>
                        <td class="text-center"><?php echo $transaction->total ?></td>
                        <td class="text-center">
                            <a href="<?php echo base_url().'transaction/detail/'.$transaction->id_transaction; ?>" class="btn btn-primary btn-icon-split"><span class="text">Detail</span></a>
                            <a href="<?php echo base_url().'transaction/delete/'.$transaction->id_transaction; ?>" class="btn btn-danger btn-icon-split"><span class="text">Delete</span></a>
                            <a href="<?php echo base_url().'transaction/nota/'.$transaction->id_transaction; ?>" class="btn btn-success btn-icon-split"><span class="text">Nota</span></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
