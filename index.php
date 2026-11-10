<?php
require_once 'db.php';

$stmt = $pdo->query("SELECT * FROM items ORDER BY id DESC");
$items = $stmt->fetchAll();
?>

<h1>Items List</h1>
<ul>
    <?php foreach ($items as $item): ?>
       <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <span><?= htmlspecialchars($item['name']) ?></span>
            
            <!-- 編集リンク -->
            <a href="update.php?id=<?= $item['id'] ?>">[編集]</a>
            
            <!-- 削除ボタン（POSTで送信するフォーム） -->
            <form action="delete.php" method="POST" onsubmit="return confirm('本当に削除しますか？');" style="display: inline;">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <button type="submit" style="color: red; cursor: pointer;">削除</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
