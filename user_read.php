<?php
include("functions.php");

// DB接続
$pdo = connect_to_db();

$sql = 'SELECT * FROM users_table ORDER BY username ASC';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
  $output .= "
    <tr>
      <td>{$record["username"]}</td>
      <td>{$record["password"]}</td>
      <td>{$record["is_admin"]}</td>
      <td>{$record["is_deleted"]}</td>
      <td>
        <a href='user_edit.php?id={$record["id"]}'>edit</a>
      </td>
      <td>
        <a href='user_logicaldelete.php?id={$record["id"]}'>logical delete</a>
      </td>
      <td>
        <a href='user_delete.php?id={$record["id"]}'>delete</a>
      </td>
    </tr>
  ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型userリスト（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>DB連携型userリスト（一覧画面）</legend>
    <a href="user_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>username</th>
          <th>password</th>
          <th>administrator</th>
          <th>logical deleted</th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>