<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">List of unit can use by product</p>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Unit</th>
                        <th>Visibilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Unit</th>
                        <th>Visibilitas</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($units ?? [] as $key => $unit) : ?>
                    <tr>
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td><?php echo $unit->unit_name ?></td>
                        <td class="text-center"><?php echo $unit->unit_visibility == 'Visible' ? 'True' : 'False' ?></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-primary btn-icon-split"><span class="text">Detail</span></a>
                            <a href="#" class="btn btn-danger btn-icon-split"><span class="text">Delete</span></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>