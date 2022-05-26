<?php
include("functions.php");

// id受け取り
$id = $_GET['id'];

// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM users_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型userリスト（編集画面）</title>
</head>

<body>
  <form action="user_update.php" method="POST">
    <fieldset>
      <legend>DB連携型userリスト（編集画面）</legend>
      <a href="user_read.php">一覧画面</a>
      <div>
        Username: <input type="text" name="username" value="<?= $record['username'] ?>" readonly>
      </div>
      <div>
        Passward: <input type="password" name="password">
      </div>
      <div>
        Administrator: <input type="checkbox" name="is_admin">
      </div>
      <div>
      <input type="hidden" name="id" value="<?= $record['id'] ?>">
    </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>