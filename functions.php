<?php

/* =====================================定数定義===================================== */
// 管理者権限なし
const NOT_ADMIN = 0;
// 管理者権限あり
const ADMIN = 1;
// 未削除
const NOT_DELETED = 0;
// 削除済
const DELETED = 1;
/* ================================================================================= */

// DBへ接続
function connect_to_db(){
  $dbn = 'mysql:dbname=gsacf_l07_06;charset=utf8mb4;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';

  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
}
