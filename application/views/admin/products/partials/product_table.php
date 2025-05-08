<table id="products-table" class="table table-striped" style="width:100%">
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
    <tbody>
        <?php foreach($products as $product): ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->name ?></td>
            <td>$<?= number_format($product->price, 2) ?></td>
            <td><?= $product->category ?></td>
            <td>
                <img src="<?= base_url('uploads/products/'.$product->image) ?>" 
                     alt="<?= $product->name ?>" 
                     style="height:50px">
            </td>
            <td>
                <a href="<?= base_url('index.php/admin/products/edit/'.$product->id) ?>" 
                   class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('index.php/admin/products/delete/'.$product->id) ?>" 
                   class="btn btn-sm btn-danger">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready(function() {
    $('#products-table').DataTable();
});
</script>