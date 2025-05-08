<!DOCTYPE html>
<html>
<head>
	
</head>
<body>

<div class="container">
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Product Management</h5>
        <a href="<?= base_url('index.php/admin/products/create') ?>" class="btn btn-primary btn-sm">
            Add New Product
        </a>
    </div>
    <div class="card-body">
        <?php $this->load->view('admin/products/partials/product_table', [
            'products' => $products
        ]); ?>
    </div>
</div>
    <h2>Product List</h2>
    <table id="products-table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $('#products-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?= base_url('admin/products/ajax_list') ?>",
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { 
                "data": "price",
                "render": function(data) {
                    return '$' + parseFloat(data).toFixed(2);
                }
            },
            { "data": "category" },
            { 
                "data": "image",
                "render": function(data) {
                    return '<img src="<?= base_url('uploads/products/') ?>' + data + '" height="50">';
                }
            },
            { 
                "data": "id",
                "render": function(data) {
                    return '<a href="<?= base_url('admin/products/edit/') ?>' + data + '" class="btn btn-sm btn-warning">Edit</a>' +
                           '<a href="<?= base_url('admin/products/delete/') ?>' + data + '" class="btn btn-sm btn-danger">Delete</a>';
                }
            }
        ],
        "dom": 'Bfrtip',
        "buttons": [
            'colvis'
        ]
    });
});
</script>
</body>
</html>
