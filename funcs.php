<?php
//XSS対応（ echoする場所で使用！）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn() 
//※関数を作成し、内容をreturnさせる。
//※ DBname等、今回の授業に合わせる。
//db_connは好きな名前でOK
//fb_connが呼び出されると失敗するとエラー、成功したら$pdo（成功した結果が入っている）を返してあげる
function db_conn(){
    try {
        // $db_name = "gs_book_db";    //データベース名
        // $db_id   = "root";      //アカウント名
        // $db_pw   = "root";      //パスワード：XAMPPはパスワード無しに修正してください。
        // $db_host = "localhost"; //DBホスト

        $db_name = "";    //データベース名
        $db_id   = "";      //アカウント名
        $db_pw   = "";      //パスワード
        $db_host = ""; //DBホスト
        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        return $pdo;//ここを追記

       

    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }

}




//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){ //$stmtはfuncs.phpには存在しない関数なので、()内に引数を入れてあげる
    $error = $error = $stmt->errorInfo();
    exit("SQLError:" . print_r($error, true));//エラー処理,insert.phpからコピペ
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name){//引数に下でつけた変数名を入れる
    // header("Location: index.php");//毎回index.phpに戻すのではなく、変数にすることで、戻る場所を自由に後から変えられるようにする
    header("Location: ".$file_name);//$file.nameは適当な変数名つける

    exit();
}


//ログインチェック
function loginCheck(){
    if( $_SESSION["chk_ssid"] != session_id() ){//セッションに保存してあるidと今のidがイコールではなければ（一致していなければ）
      exit('LOGIN ERROR');//エラーとなる
    }else{//揃っていれば（一致していたら）処理が走る
      session_regenerate_id(true);//idを更新して
      $_SESSION['chk_ssid'] = session_id();//保存し直す（ログイン中もページを跨ぐたびにハックされにくい状態にする）
    }
  }
