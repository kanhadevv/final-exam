<?php

declare(strict_types=1);

require __DIR__ . '/db.php';
require __DIR__ . '/layout.php';

$pdo = db();
$allowedStatuses = ['active', 'inactive'];

$errors = [];
$data = [
    'product_name' => '',
    'category' => '',
    'price' => '',
    'quality' => '',
    'status' => 'active',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['product_name'] = trim((string) ($_POST['product_name'] ?? ''));
    $data['category'] = trim((string) ($_POST['category'] ?? ''));
    $data['price'] = trim((string) ($_POST['price'] ?? ''));
    $data['quality'] = trim((string) ($_POST['quality'] ?? ''));
    $data['status'] = trim((string) ($_POST['status'] ?? ''));

    if ($data['product_name'] === '') {
        $errors[] = 'Product name is required.';
    }
    if ($data['category'] === '') {
        $errors[] = 'Category is required.';
    }
    if ($data['price'] === '' || !is_numeric($data['price']) || (float) $data['price'] < 0) {
        $errors[] = 'Price must be a valid non-negative number.';
    }
    if ($data['quality'] === '') {
        $errors[] = 'Quality is required.';
    }
    if (!in_array($data['status'], $allowedStatuses, true)) {
        $errors[] = 'Status must be active or inactive.';
    }

    if (count($errors) === 0) {
        $stmt = $pdo->prepare(
            'INSERT INTO products (product_name, category, price, quality, status, created_at, updated_at)
             VALUES (:product_name, :category, :price, :quality, :status, :created_at, :updated_at)'
        );
        $now = date('Y-m-d H:i:s');
        $stmt->execute([
            ':product_name' => $data['product_name'],
            ':category' => $data['category'],
            ':price' => (float) $data['price'],
            ':quality' => $data['quality'],
            ':status' => $data['status'],
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        header('Location: index.php?success=' . urlencode('Product created successfully.'));
        exit;
    }
}

renderHeader('Create Product');
?>

<h2>Create Product</h2>

<?php if (count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= h($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="create.php" method="POST">
    <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="product_name" class="form-control" value="<?= h($data['product_name']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control" value="<?= h($data['category']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" step="0.01" min="0" name="price" class="form-control" value="<?= h($data['price']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Quality</label>
        <input type="text" name="quality" class="form-control" value="<?= h($data['quality']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <?php foreach ($allowedStatuses as $statusOption): ?>
                <option value="<?= h($statusOption) ?>" <?= $data['status'] === $statusOption ? 'selected' : '' ?>>
                    <?= h(ucfirst($statusOption)) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php
renderFooter();
