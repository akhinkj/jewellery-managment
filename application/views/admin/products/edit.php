<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Product</h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('index.php/admin/products/edit/'.$product->id) ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= $product->name ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required><?= $product->description ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" step="0.01" class="form-control" value="<?= $product->price ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category ?>" <?= ($category == $product->category) ? 'selected' : '' ?>>
                            <?= $category ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img src="<?= base_url('uploads/products/'.$product->image) ?>" height="100" class="mb-2">
                <input type="file" name="image" class="form-control">
                <small class="text-muted">Leave blank to keep existing image</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="<?= base_url('index.php/admin/products') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>