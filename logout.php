<?php
//必ずsession_startは最初に記述
session_start();

//SESSIONを初期化（空っぽにする）セッションidのファイルの中身を白紙にする（tempフォルダにはファイルは残るが中身がなくなる）
//万が一後からハイジャックされないために、情報は消しておく必要があるため
$_SESSION = array();

//Cookieに保存してある"SessionIDの保存期間を過去にして破棄（有効期限切れにする）
if (isset($_COOKIE[session_name()])) { //session_name()は、セッションID名を返す関数
    setcookie(session_name(), '', time()-42000, '/');
}

//サーバ側での、セッションIDの破棄
session_destroy();

//処理後、index.phpへリダイレクト
header("Location: login.php");
exit();

?>
