<?php
// 1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ

$name= $_POST["name"];
$author= $_POST["author"];
$url= $_POST["url"];
$naiyou= $_POST["naiyou"];


// 2. DB接続します エラーか成功かの分岐をする.PDO＝PHPとデータベースを接続する機能
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_book_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}


// ３．SQL文を用意(データ登録：INSERT)文字列として入れる.IDはNULL
$stmt = $pdo->prepare(
  "INSERT INTO gs_book_table( id , name , author , url , naiyou , indate )
  VALUES(NULL, :name, :author, :url, :naiyou, sysdate() )"
);

// 4. バインド変数を用意 SQL Injectionハッキングを防止するため、外部からかけないようにする。上記のVALUESの中身に「:」を追記して仮想的な変数に書き換える
//('仮想的な変数',$実際の変数,PDO::PARAM_STR=無効な変数に書き換える)
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':author', $author, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// 5. 実行.$statusに実行結果が返ってくる。
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト.トップページに返す
  header('Location: index.php');
  
}
?>
