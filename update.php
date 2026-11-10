<?php
require_once 'db.php';

$error = '';
$item = null;

// 1. URLパラメータからIDを取得
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    die("不正なアクセスです（IDが指定されていません）。");
}

// 2. 現在のデータをデータベースから取得してフォームに初期表示する
try {
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $item = $stmt->fetch();

    if (!$item) {
        die("指定されたデータが見つかりません。");
    }
} catch (PDOException $e) {
    die("データベースエラー: " . $e->getMessage());
}

// 3. フォームが送信された場合の更新処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if ($name !== '') {
        try {
            // データを安全に更新
            $stmt = $pdo->prepare("UPDATE items SET name = :name WHERE id = :id");
            $stmt->execute([
                ':name' => $name,
                ':id'   => $id
            ]);

            // 成功したら一覧画面へ戻る
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "更新エラー: " . $e->getMessage();
        }
    } else {
        $error = "名前を入力してください。";
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アイテム編集</title>
</head>
<body>
    <h1>アイテムの編集</h1>

    <!-- エラーメッセージの表示 -->
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <!-- 編集フォーム -->
    <form action="update.php?id=<?= $id ?>" method="POST">
        <label for="name">名前:</label>
        <!-- 既存の値をフォームにセット -->
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
        <button type="submit">更新する</button>
    </form>

    <p><a href="index.php">一覧に戻る</a></p>
</body>
</html>
