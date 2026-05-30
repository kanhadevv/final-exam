<?php

declare(strict_types=1);

require __DIR__ . '/db.php';
require __DIR__ . '/layout.php';

$pdo = db();
$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$stmt->execute([':id' => $id]);
$product = $stmt->fetch();

if ($product === false) {
    header('Location: index.php?success=' . urlencode('Product not found.'));
    exit;
}

renderHeader('Product Details');
?>

<h2>Product Details</h2>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= h((string) $product['product_name']) ?></h5>
        <p class="card-text mb-2"><strong>Category:</strong> <?= h((string) $product['category']) ?></p>
        <p class="card-text mb-2"><strong>Price:</strong> <?= h((string) $product['price']) ?></p>
        <p class="card-text mb-2"><strong>Quality:</strong> <?= h((string) $product['quality']) ?></p>
        <p class="card-text mb-0"><strong>Status:</strong> <?= h((string) $product['status']) ?></p>
    </div>
</div>

<a href="index.php" class="btn btn-secondary mt-3">Back</a>

<?php
renderFooter();

