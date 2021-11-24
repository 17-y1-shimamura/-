<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>MENU</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link href="css/style.css" rel="stylesheet">
  <!-- <style>div{padding: 10px;font-size:16px;}</style> -->
</head>
<body>

<div class="menu_header">
  <h1>タスク管理システム</h1>
  <ul class="menu_header_list">
    <li class="menu_header_list_insert">
    <a href="insert.php">タスクを新規登録する</a>
    </li>
    <li>
      <a href="menu.php">トップ画面に戻る</a>
    </li>
  </ul>
</div>

<?php
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  // mysql:データベース名,root,rootにはそれぞれユーザー名とパスワードが入る
  $pdo = new PDO('mysql:dbname=ymt_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//２．SQL文を用意(データ取得：SELECT文)
$stmt = $pdo->prepare("SELECT * FROM chat_table");
// 実行結果がtrueもしくはfalseで返る
$status = $stmt->execute();

//３．データ表示
$view="";//空っぽの変数viewを作成（ここにHTMLタグを追加していく）

if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //「2.」で取得したデータの数だけ自動でループしてくれるwhile文
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    // .=は追加(+=と同じ)
    // .が+と同じ機能を果たす
    // カラム名で指定
    // 日時
    $view .= "<div class='arrow_box'>";
    $view .= $result['indate'].':'.$result['name'];
    $view .= "<br><br>";
    $view .= $result['body'];
    $view .= "</div>";
  }

}
?>

<!-- チャット内容の表示エリア -->
<div class=" jumbotron"><?= $view ?></div>


</body>
</html>
