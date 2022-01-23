<?php
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_book_db;charset=utf8;host=localhost','root','root');
  
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//２．SQL文を用意(データ取得：SELECT)データベースにある情報をすべて取ってくる
$stmt = $pdo->prepare("SELECT * FROM gs_book_table");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="";//PHP側で HTMLを作る
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる（while分は()のデータの数だけ繰り返す）
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  //$stmtの中にデータが全て入っているが、それを扱いやすくする 

  // while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ //$resultの中には一周目（一つ目）のデータが入ってる
  //   // $view .= "<p>";
  //   // $view .= $result['indate'].':'.$result['name'].':'.$result['author'].':'.$result['url'].':'.$result['naiyou']; //「.=」で足し算ができる「.''.」で後ろにつづける「.':'.」のコロン:は文字列の意味
  //   // $view .= "</>"; //viewの中に一つ一つのデータが入っていくイメージ

  //   $view .= "<p>";
  //   $view .= $result['indate'].':'.$result['name'].':'.$result['author'].':'.$result['url'].':'.$result['naiyou']; //「.=」で足し算ができる「.''.」で後ろにつづける「.':'.」のコロン:は文字列の意味
  //   $view .= "</p>"; //viewの中に一つ一つのデータが入っていくイメージ
  // } 

  $view .= "<table>";

  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .= "<tr>";
    $view .= "<td>";
    $view .= $result['indate'];
    $view .= "</td>";
    $view .= "<td>";
    $view .= $result['name'];
    $view .= "</td>";
    $view .= "<td>";
    $view .= $result['url'];
    $view .= "</td>";
    $view .= "<td>";
    $view .= $result['naiyou'];
    $view .= "</td>";
    $view .= "</tr>";
  }
$view .= "</table>";

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>書籍データベース表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<style type="text/css">

table {
margin-bottom: 20px;
border: 2px #2b2b2b solid;
border-collapse: separate;

}
td, th {
border: 2px #2b2b2b solid;
}

table.result {
border-spacing: 5px;
padding-left: 5px
}
</style>


</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ表示</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<!-- <div>
  <table>
    <div class="container jumbotron"><?= $view ?></div>
</table>
</div> -->


<table class="result" cellpadding="25" cellspacing="10">
<tr>
<td><?= $view ?></td>
</tr>
</table>



<!-- Main[End] -->

</body>
</html>
