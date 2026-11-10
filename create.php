<?php
require_once 'db.php';

$error = '';

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 送信された値の取得と前後の余白削除
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if ($name !== '') {
        try {
            // SQLインジェクションを防ぐため、プリペアドステートメントを使用
            $stmt = $pdo->prepare("INSERT INTO items (name) VALUES (:name)");
            $stmt->execute([':name' => $name]);

            // 成功したらメイン画面（一覧）へ戻る
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "データベースエラー: " . $e->getMessage();
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
    <title>アイテム追加</title>
</head>
<body>
    <h1>新しいアイテムを追加</h1>

    <!-- エラーメッセージの表示 -->
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <!-- 入力フォーム -->
    <form action="create.php" method="POST">
        <label for="name">名前:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">追加する</button>
    </form>

    <p><a href="index.php">一覧に戻る</a></p>
</body>
</html>
