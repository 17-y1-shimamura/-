<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>タスク新規登録</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link href="css/style.css" rel="stylesheet">
  <!-- <style>div{padding: 10px;font-size:16px;}</style> -->
</head>
<body>

<div class="menu_header">
  <h1>タスク管理システム</h1>
  <ul class="menu_header_list">
    <li class="menu_header_list_insert">
    <a href="insert.php">タスクを新規登録</a>
    </li>
    <li>
      <a href="menu.php">トップ画面に戻る</a>
    </li>
  </ul>
</div>

<!-- 登録完了しましたメッセージ -->
<!-- 以下の内容で登録しました。 -->
<!-- 続けて登録しますか？ -->
<!-- 続けて登録 -->
<!-- タスクを表示 -->

<?php

//0. POSTデータ取得
$staff = $_POST['staff'];
$importance = $_POST['importance'];
$title = $_POST['title'];
$body = $_POST['body'];
$deadline = $_POST['deadline'];

// デバッグ
// echo $staff;
// echo $importance;
// echo $title;
// echo $body;
// echo $deadline;

//1. 入力値チェック
$error_value = "";
$foo = False; 
if(empty($staff)) {
  $error_value .= "!! 担当者が入力されていません。<br> ";
  $foo = True; 
}
  
if (empty($importance)) {
  $error_value .= "!! 重要度が入力されていません。<br>  ";
  $foo = True; 
}

if (empty($title)) {
  $error_value .= "!! タスクのタイトルが入力されていません。<br>  ";
  $foo = True; 
}

if (empty($deadline)) {
  $error_value .= "!! タスクの期限が入力されていません。<br>  ";
  $foo = True; 
}

// var_dump($error_value);

$message = "";
if($foo){
  //入力にエラーがある場合はエラー文
  $message .= "<div class ='
  '>";
  $message .= "<p class='error_message'>";
  $message .= $error_value."</p>";
  $message .= "</div>";
  $message .= "<a href='insert.php'>登録しなおす場合はこちら</a>";
} else {
  $message .= "<p class='success_message'>以下の内容で登録完了しました</p>";
}
// var_dump($message);
?>
<div class="jumbotron"><?= $message ?></div>

<?php

if ($foo) {
  exit;
}

//2. DB接続
try {
  //Password:MAMP='root''
  // mysql:データベース名,root,rootにはそれぞれユーザー名とパスワードが入る
  $pdo = new PDO('mysql:dbname=ymt_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成(INSERT文)
// $name→:name $body→:body(バインド変数)
// $stmt = $pdo->prepare("INSERT INTO task_table(id, name, body, indate) 
// VALUES (null,:name,:body,sysdate())");
$stmt = $pdo->prepare("INSERT INTO task_table
(id, staff, importance, title, body, status, deadline, indate)
 VALUES (null,:staff,:importance,:title,:body,'未着手',:deadline,sysdate())");

//バインド変数を変数に変換
$stmt->bindValue(':staff', $staff, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':importance', $importance, PDO::PARAM_STR);  
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':body', $body, PDO::PARAM_STR);
// 期限はdate型
$stmt->bindValue(":deadline", date("Y-m-d", strtotime($deadline)), PDO::PARAM_STR);

//var_dump($stmt);

//DBにSQL文を実行
$result = $stmt->execute();

//var_dump($result);

$view="";//空っぽの変数viewを作成（ここにHTMLタグを追加していく）

// ４．データ登録処理後
if($result==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMessage:".$error[2]);
}else{
  
  $view .= "<div class='jumbotron'>";
  // $view .= "<p class='success_message'>以下の内容で登録完了しました</p>";
  $view .= "担当者：<input type='text' value='".$staff."' size='15'>";
  $view .= "重要度：<input type='text' value='".$importance."' size='1'>";
  $view .= "<br>";
  $view .= "タスク名：<input type='text' value='".$title."' size='45' >";
  $view .= "<br>";
  // $view .= "内容";
  // $view .= "<br>";
  $view .= "<textArea name='body' rows='3' cols='60'>".$body."</textArea>";
  $view .= "<br>";
  $view .= "期限：<input type='text' value='".$deadline."'>";
  $view .= "</div>";
  $view .= "<a href='insert.php'>つづいて登録する場合はこちら</a>";
  $view .= "<br>";
  $view .= "<a href='menu.php'>TOPに戻る場合はこちら</a>";
  //var_dump($view);
}

?>
<!-- 登録内容の表示エリア -->
<div class=" jumbotron"><?= $view ?></div>

</body>
</html>