<?php
include("functions.php");

//var_dump($_POST);

if (
  !isset($_POST['username']) || $_POST['username'] == '' ||
  !isset($_POST['password']) || $_POST['password'] == ''
  // checkboxはチェック未状態でPOSTされるとPOST変数へ値が入ってこないため入力チェックはPASS
  //!isset($_POST['is_admin']) || $_POST['is_admin'] == ''
) {
  exit('paramError');
}

$username = $_POST['username'];
$password = $_POST['password'];
$is_admin = NOT_ADMIN;
if (isset($_POST['is_admin'])){
  $is_admin = ADMIN;
};
$is_deleted = NOT_DELETED;

// DB接続
$pdo = connect_to_db();

$sql = 'INSERT INTO users_table(id, username, password, is_admin, is_deleted, created_at, updated_at) VALUES(NULL, :username, :password, :is_admin, :is_deleted, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_STR);
$stmt->bindValue(':is_deleted', $is_deleted, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:user_input.php");
exit();
