<?php
//insert.phpの処理を持ってくる
//1. POSTデータ取得
$name   = $_POST["name"];
$author  = $_POST["author"];
$url    = $_POST["url"];
$naiyou = $_POST["naiyou"];
$id = $_POST["id"];


//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();


//３．データ更新SQL作成（UPDATE テーブル名 SET 更新対象1=:更新データ ,更新対象2=:更新データ2,... WHERE id = 対象ID;）
$stmt = $pdo->prepare( 
    "UPDATE gs_book_table SET name = :name, author = :author, url = :url, naiyou = :naiyou, indate = sysdate() 
    WHERE id = :id;" );//変更するidの指定

  
  // 4. バインド変数を用意 idがないので、追加
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);/// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':author', $author, PDO::PARAM_STR);// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':url', $url, PDO::PARAM_INT);// 数値の場合 PDO::PARAM_INT
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':id', $id, PDO::PARAM_INT);// 数値の場合 PDO::PARAM_INT


  // 5. 実行
  $status = $stmt->execute();
  

//４．データ登録処理後 insert.phpからコピペ
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('select_copy.php');
}


