<?php
//selsect.phpから処理を持ってくる
//1.外部ファイル読み込みしてDB接続(funcs.phpを呼び出して)
require_once('funcs.php'); //funcs.phpのファイルを呼び出す、読み込む（許可するファイル名はfuncs.phpでなくても良い）
$pdo = db_conn();//先ほどfunc.php内で作った関数を呼び出す、データベースの接続に成功したら$pdoに情報が返ってくるしくみ


//2.対象のIDを取得
$id= $_GET['id']; //URLにも書いてあったidを取得

//3．データ取得SQLを作成（SELECT文）
$stmt = $pdo->prepare("SELECT * FROM gs_book_table WHERE id=:id;");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();


//4．データ表示
$view = '';
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();
}
?>


<!-- 以下はindex.phpのHTMLをまるっと持ってくる 更新画面は登録画面を流用する-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select_copy.php">データ一覧</a></div>
            </div>
        </nav>
    </header>

    <!-- method, action, 各inputのnameを確認してください。  value=を入れる。textareaだけ書き方違う action=update.phpに書き換える
methodがGETであればurlから取れるが、POSTなのでどのidを取ってくるかがわからないのでinput type hoddenでユーザーには見せないようにどのidをとるかを指示して情報を送る-->
    <form method="POST" action="update.php">
        <div class="jumbotron">
     <fieldset>
    <legend>以下に情報を登録してください</legend>
     <label>書籍名：<input type="text" name="name" value="<?= $result['name'] ?>"></label><br>
     <label>作者：<input type="text" name="author" value="<?= $result['author'] ?>"></label><br>
     <label>URL：<input type="text" name="url" value="<?= $result['url'] ?>"></label><br>
     <label>コメント：<br><textArea name="naiyou" rows="4" cols="40"><?= $result['naiyou'] ?></textArea></label><br>
     <input type="hidden" name="id" value="<?= $result['id'] ?>">
            <input type="submit" value="送信">
            </fieldset>
    

</body>

</html>

