<?php
include("functions.php");

//var_dump($_POST);

// 入力項目のチェック
if (
  !isset($_POST['username']) || $_POST['username'] == '' ||
  !isset($_POST['password']) || $_POST['password'] == '' ||
  // checkboxはチェック未状態でPOSTされるとPOST変数へ値が入ってこないため入力チェックはPASS
  //!isset($_POST['is_admin']) || $_POST['is_admin'] == ''
  !isset($_POST['id']) || $_POST['id'] == ''
) {
  exit('paramError');
}

$username = $_POST['username'];
$password = $_POST['password'];
$is_admin = NOT_ADMIN;
if (isset($_POST['is_admin'])){
  $is_admin = ADMIN;
};
$id = $_POST['id'];

// DB接続
$pdo = connect_to_db();

// SQL実行]
$sql = 'UPDATE users_table SET password=:password, is_admin=:is_admin, updated_at=now() WHERE id=:id';

$stmt = $pdo->prepare($sql);
//$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:user_read.php');
exit();
