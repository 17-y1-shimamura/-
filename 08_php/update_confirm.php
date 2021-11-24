<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>タスク更新画面</title>
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

<?php
  //0. POSTデータ取得
  $id = $_POST['id'];
  $staff = $_POST['staff'];
  $importance = $_POST['importance'];
  $title = $_POST['title'];
  $body = $_POST['body'];
  $status = $_POST['status'];
  $deadline = $_POST['deadline'];
  //デバッグ
  // echo $id;
  // echo $staff;
  // echo $importance;
  // echo $title;
  // echo $body;
  // echo $status;
  // echo $deadline;

  //1.  DB接続します
  try {
  //Password:MAMP='root',XAMPP=''
  // mysql:データベース名,root,rootにはそれぞれユーザー名とパスワードが入る
    $pdo = new PDO('mysql:dbname=ymt_db;charset=utf8;host=localhost','root','root');
  } catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
  }

  //$pdo->autocommit(false);

  //２．SQL文を用意(UPDATE文)
  $stmt = $pdo->prepare("UPDATE task_table 
  SET id=:id, staff=:staff,importance=:importance,title=:title,body=:body,status=:status,deadline=:deadline,indate=sysdate() WHERE id=:id" );
  //バインド変数を変数に変換
  // idはint型
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->bindValue(':staff', $staff, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':importance', $importance, PDO::PARAM_STR);  
  $stmt->bindValue(':title', $title, PDO::PARAM_STR);
  $stmt->bindValue(':body', $body, PDO::PARAM_STR);
  $stmt->bindValue(':status', $status, PDO::PARAM_STR);
  // 期限はdate型
  $stmt->bindValue(":deadline", date("Y-m-d", strtotime($deadline)), PDO::PARAM_STR);

  // 実行結果がtrueもしくはfalseで返る
  $result = $stmt->execute();

  //デバッグ
  //var_dump($stmt);
  //echo $stmt->rowCount();
  //var_dump($result);

  //３．データ表示
  $view="";//空っぽの変数viewを作成（ここにHTMLタグを追加していく）

  if($result==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
  } else {
    //$pdo ->autocommit(true);
    $view .= "<div class='jumbotron'>";
    $view .= "<p class='success_message'>以下の内容で更新完了しました。</p>";
    $view .= "担当者：<input type='text' value='".$staff."' size='15'>";
    $view .= "重要度：<input type='text' value='".$importance."' size='1'>";
    $view .= "<br>";
    $view .= "タスク名：<input type='text' value='".$title."' size='45' >";
    $view .= "<br>";
    // $view .= "内容";
    // $view .= "<br>";
    $view .= "<textArea name='body' rows='3' cols='60'>".$body."</textArea>";
    $view .= "<br>";
    $view .= "タスクの進捗状況：<input type='text' value='".$status."' size='2'>";
    $view .= "<br>";
    $view .= "期限：<input type='text' value='".$deadline."'>";
    $view .= "</div>";
    $view .= "<a href='menu.php'>TOPに戻る場合はこちら</a>";
  }

  ?>

  <!-- 変更内容の表示エリア -->
<div class=" jumbotron"><?= $view ?></div>
</body>
</html>