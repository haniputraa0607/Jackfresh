<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<p class="mb-4">List of products stored in the warehouse </p>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Visibility</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot class="text-center">
                    <tr>
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Visibility</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>Sampo</td>
                        <td>SHMP-1</td>
                        <td>true</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-primary btn-icon-split"><span class="text">Detail</span></a>
                            <a href="#" class="btn btn-danger btn-icon-split"><span class="text">Delete</span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>