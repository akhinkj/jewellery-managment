<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewellery Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('index.php/admin/products') ?>">Jewellery Admin</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('index.php/admin/products') ?>">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('index.php/auth/logout') ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <?php $this->load->view($content); ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <?php if(isset($datatable) && $datatable): ?>
    <script>
    $(document).ready(function() {
        $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= base_url('index.php/admin/products/ajax_list') ?>",
            columns: [
                { data: 'id' },
                { data: 'name' },
                { 
                    data: 'price',
                    render: function(data) {
                        return '$' + parseFloat(data).toFixed(2);
                    }
                },
                { data: 'category' },
                { 
                    data: 'image',
                    render: function(data) {
                        return `<img src="<?= base_url('index.php/uploads/products/') ?>${data}" height="50">`;
                    }
                },
                { 
                    data: 'id',
                    render: function(data) {
                        return `
                            <a href="<?= base_url('index.php/admin/products/edit/') ?>${data}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('index.php/admin/products/delete/') ?>${data}" class="btn btn-sm btn-danger">Delete</a>
                        `;
                    }
                }
            ]
        });
    });
    </script>
    <?php endif; ?>
</body>
</html>