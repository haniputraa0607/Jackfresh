<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">Daftar klien yang terdaftar</p>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Kode Pelanggan</th>
                        <th>Jenis Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Kode Pelanggan</th>
                        <th>Jenis Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($clients ?? [] as $key => $client) : ?>
                    <tr>
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td><?php echo $client->client_name ?></td>
                        <td><?php echo $client->client_code ?></td>
                        <td><?php echo $client->client_type ?> </td> 
                        <!-- == 'Hotel' ? 'Hotel' : $client->client_type == 'Restaurant' ? 'Restoran' : $client->client_type == 'Personal' ? 'Personal' ?> </td> -->
                        <td class="text-center">
                            <a href="<?php echo base_url().'client/detail_client/'.$client->id_client; ?>" class="btn btn-primary btn-icon-split"><span class="text">Detail</span></a>
                            <a href="<?php echo base_url().'client/delete/'.$client->id_client; ?>" class="btn btn-danger btn-icon-split"><span class="text">Delete</span></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
