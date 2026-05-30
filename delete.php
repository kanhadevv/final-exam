<?php

declare(strict_types=1);

require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
if ($id > 0) {
    $stmt = db()->prepare('DELETE FROM products WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

header('Location: index.php?success=' . urlencode('Product deleted successfully.'));
exit;

