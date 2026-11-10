<?php
require_once 'db.php';

$stmt = $pdo->query("SELECT * FROM items ORDER BY id DESC");
$items = $stmt->fetchAll();
?>

<h1>Items List</h1>
<ul>
    <?php foreach ($items as $item): ?>
        <li><?= htmlspecialchars($item['name']) ?></li>
    <?php endforeach; ?>
</ul>
