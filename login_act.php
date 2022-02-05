<?php
//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値 login.phpからのIDとpassを受け取る
$lid = $_POST['lid'];
$lpw = $_POST['lpw']; 
// $pass = password_hash($_POST["lpw"],PASSWORD_DEFAULT);

//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//2. データ登録SQL作成 SQL(gs_user_table)分で上のIDかつパスワードも合致した人がいるかを探す
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid=:lid");//AND lpw=:lpwは消去。SQLは暗号を読み解けない。
$stmt->bindValue(':lid',$lid, PDO::PARAM_STR);
// $stmt->bindValue(':lpw',$lpw, PDO::PARAM_STR); //* Hash化する場合はコメントする
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();         //データ取得できたら、$valという変数の中に結果を返す。ユーザー情報なので1レコードだけ取得する。
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()

//5. 該当レコードがあればSESSIONに値を代入
//* if(password_verify($lpw, $val["lpw"])){
// if( $val['id']!="" ){   //「valにidが空っぽ''でなければ!=」すなわちIDが存在した場合、ログイン成功(hash化しない場合)
if( password_verify($lpw, $val["lpw"]) ){ //ユーザーから送られてきた普通の文字列のパスワード$lpwとデータベースに保存されているhash化されたパスワードをpassword_verifyという関数の中でチェックする
  //Login成功時
  $_SESSION['chk_ssid']  = session_id();//SESSION変数に現在のsession_idを保存 idとクッキーの結合作業をする。
  //ログイン処理とログインチェックは別物であり、この処理はログイン処理
  //chk_ssidの中に保持されているsession_idが他のページでも一致するかどうかをチェックすることにより、ログインしているかしていないかを確認している。
  //ログインチェックはfuncs.phpに関数用意
  $_SESSION['kanri_flg'] = $val['kanri_flg'];//SESSION変数に管理者権限のflagを保存
  $_SESSION['name']      = $val['name'];//SESSION変数にnameを保存
  redirect('select_copy.php');//成功したらselect_copy.phpに返してあげる
}else{
  //Login失敗時(Logout経由)
  redirect('login.php');
}

exit();


