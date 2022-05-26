<?php
include("functions.php");

//var_dump($_GET);

// 入力項目のチェック
if (
  !isset($_GET['id']) || $_GET['id'] == ''
) {
  exit('paramError');
}

$is_deleted = DELETED;
$id = $_GET['id'];

// DB接続
$pdo = connect_to_db();

// SQL実行]
$sql = 'UPDATE users_table SET is_deleted=:is_deleted, updated_at=now() WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':is_deleted', $is_deleted, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:user_read.php');
exit();
