<p>
    <a href="/products" class="btn btn-secondary">Go back to Products</a>
</p>
<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?= $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<!-- En este formulario las variables $title, $description y $price obtienen el valor de POST -->
<form action="" method="post" enctype="multipart/form-data">
    <?php if($product['image']): ?>
        <img width="100px" src="/<?= $product['image'] ?>">
    <?php endif; ?>
    <div class="form-group">
        <label>Product Image</label>
        <br>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label>Product Title</label>
        <input type="text" name="title" class="form-control" value="<?= $product['title'] ?>">
    </div>
    <div class="form-group">
        <label>Product Description</label>
        <textarea name="description" class="form-control"><?= $product['description'] ?></textarea>
    </div>
    <div class="form-group">
        <label>Product Price</label>
        <input type="number" name="price" step=".01" class="form-control" value="<?= $product['price'] ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>