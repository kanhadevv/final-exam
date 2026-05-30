<?php

declare(strict_types=1);

require __DIR__ . '/db.php';
require __DIR__ . '/layout.php';

$pdo = db();

$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$total = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$totalPages = max(1, (int) ceil($total / $perPage));
if ($page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $perPage;
}

$stmt = $pdo->prepare('SELECT * FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();

renderHeader('Products CRUD');
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Product List</h2>
    <a class="btn btn-primary" href="create.php">Create Product</a>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?= h((string) $_GET['success']) ?></div>
<?php endif; ?>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Quality</th>
        <th>Status</th>
        <th width="240">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($products) === 0): ?>
        <tr>
            <td colspan="7" class="text-center">No products found.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= (int) $product['id'] ?></td>
                <td><?= h((string) $product['product_name']) ?></td>
                <td><?= h((string) $product['category']) ?></td>
                <td><?= h((string) $product['price']) ?></td>
                <td><?= h((string) $product['quality']) ?></td>
                <td><?= h((string) $product['status']) ?></td>
                <td>
                    <a class="btn btn-info btn-sm" href="show.php?id=<?= (int) $product['id'] ?>">Show</a>
                    <a class="btn btn-warning btn-sm" href="edit.php?id=<?= (int) $product['id'] ?>">Edit</a>
                    <form action="delete.php" method="POST" class="d-inline">
                        <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<nav>
    <ul class="pagination">
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
        </li>
    </ul>
</nav>

<?php
renderFooter();

