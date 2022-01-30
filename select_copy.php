<?php
//1.  DB接続します
// try {
//   //Password:MAMP='root',XAMPP=''
//   $pdo = new PDO('mysql:dbname=gs_book_db;charset=utf8;host=localhost','root','root');
  
// } catch (PDOException $e) {
//   exit('DBConnectError:'.$e->getMessage());
// }

require_once('funcs.php'); 
$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT)データベースにある情報をすべて取ってくる
$stmt = $pdo->prepare("SELECT * FROM gs_book_table");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view = "";
if ($status == false) {
    sql_error($status);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //GETデータ送信リンク作成
        // <a>で囲う。
        $view .= '<p>';
        $view .= '<a href="detail.php?id='.$result['id'].'">';// 「?id='.$result['id'].'」を追記
        $view .= $result["indate"] . "：" . $result["name"] . "：" . $result["author"] . "：" . $result["naiyou"] . "：" . $result["url"];
        $view .= '</a>';
        $view .= '<a href="delete.php?id='.$result['id'].'">';// 「?id='.$result['id'].'」を追記
        $view .= '[ 削除 ]';
        $view .= '</a>';
        $view .= '</p>';
    }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>書籍データベース</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">データ登録</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron">
            <a href="detail.php"></a>
            <?= $view ?>
        </div>
    </div>
    <!-- Main[End] -->

</body>

</html>
