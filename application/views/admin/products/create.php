<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Product</h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('index.php/admin/products/create') ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" step="0.01" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category ?>"><?= $category ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
                <small class="text-muted">Max size 2MB (will be resized to 500x500px)</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Product</button>
            <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>