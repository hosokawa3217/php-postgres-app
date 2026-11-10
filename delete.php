<!-- <?php
require_once 'db.php';

// 安全のため、POSTリクエスト以外のアクセスは拒否
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("不正なアクセス方法です（POSTリクエストが必要です）。");
}

// フォーム（またはJavaScript）から送信されたIDを取得
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    try {
        // プリペアドステートメントを使って安全に削除
        $stmt = $pdo->prepare("DELETE FROM items WHERE id = :id");
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        die("削除エラー: " . $e->getMessage());
    }
}

// 削除完了後、またはIDが不正な場合は一覧画面にリダイレクト
header("Location: index.php");
exit;
 -->
