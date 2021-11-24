<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>タスク詳細画面</title>
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
<!-- Main[End] -->

<?php
  //0. POSTデータ取得
  $id = $_POST['id'];
  $staff = $_POST['staff'];
  $importance = $_POST['importance'];
  $title = $_POST['title'];
  $body = $_POST['body'];
  $status = $_POST['status'];
  $deadline = $_POST['deadline'];
  $importance_value = $_POST['importance_value'];
  $status_value = $_POST['status_value'];
  //デバッグ
  // echo $id;
  // echo $staff;
  // echo $importance;
  // echo $title;
  // echo $body;
  // echo $status;
  // echo $deadline;
  // プルダウンの値
  // echo $importance_value;
  // echo $status_value;

  $view = "<p class='error_message'>以下のタスクを消去しますか？</p>";
  $view .= "<div class='jumbotron'>";
  $view .= "<form action='delete_confirm.php' method='POST'>";
  $view .= "<hr>";
  $view .= "担当者：<input type='text' name ='staff' value='".$staff."' size='15'readonly>";
  $view .= " 重要度：<input type='text' name='importance' value='".$importance_value."'size='1' readonly>";
  $view .= "<br>";
  $view .= "タスク名：<input type='text' name='title' value='".$title."' size='45' readonly>";
  $view .= "<br>";
  // $view .= "内容：";
  // $view .= "<br>";
  $view .= "<textArea name='body' name='body' rows='3' cols='60' readonly>".$body."</textArea>";
  $view .= "<br>";
  $view .= "タスクの進捗状況：<input type='text' name='status' value='".$status_value."'size='10' readonly>";
  $view .= " 期限：<input type='date' name='deadline' value='".$deadline."' size='10' readonly>";
  $view .= "<input type='hidden' name='id' value='".$id."'> <br>";
  $view .= "<input class='delete_button' type='submit' value='このタスクを削除する'>";
  $view .= "<hr>";
  $view .= "</div>";
  $view .= "</form>";
?>

<!-- チャット内容の表示エリア -->
<div><?= $view ?></div>


</body>
</html>
