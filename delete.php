<?php
//selsect.phpから処理を持ってくる
//1.対象のIDを取得
$id = $_GET['id'];


//2.DB接続します
require_once('funcs.php');
$pdo = db_conn();

//3.削除SQLを作成 検索した対象の一件を削除する
$stmt = $pdo->prepare("DELETE FROM gs_book_table WHERE id=:id;");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//４．データ登録処理後

if ($status == false) {
    sql_error($stmt);
} else {
    redirect('select_copy.php');
}




