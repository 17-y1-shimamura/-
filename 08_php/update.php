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
    <a href="insert.php">タスクを新規登録</a>
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
  //デバッグ
  // echo $id;
  // echo $staff;
  // echo $importance;
  // echo $title;
  // echo $body;
  // echo $status;
  // echo $deadline;

  $view = "";
  $view .= "<div class='jumbotron'>";
  //$view .= "<form action='update_confirm.php' method='POST'>";
  $view .= "<form method='POST'>";
  $view .= "<hr>";
  $view .= "担当者：<input type='text' name='staff' value='".$staff."' size='15'>";
  $view .= "<br>";
  $view .= "重要度：<select name='importance'>
    <option value='!!!'>!!!</option>
    <option value='!!'>!!</option>
    <option value='!'>!</option>
  </select>";
  $view .= "<br>";
  $view .= " タスク名：<input type='text' name='title' value='".$title."' size='45' >";
  $view .= "<br>";
  // $view .= "内容：";
  // $view .= "<br>";
  $view .= "<textArea name='body' rows='3' cols='60'>".$body."</textArea>";
  $view .= "<br>";
  $view .= "タスクの進捗状況：<select name='status'><option value='未着手'>未着手</option>
  <option value='着手中'>着手中</option><option value='完了'>完了</option>
</select>";
  $view .= "<br>";
  $view .= "期限：<input type='date' name='deadline' value='".$deadline."'>";
  $view .= "<input type='hidden' name='id' value='".$id."'> <br>";
  
  //プルダウンの値(重要度・状況)
  $view .= "<input type='hidden' name='importance_value' value='".$importance."'>";
  $view .= "<input type='hidden' name='status_value' value='".$status."'>";
  
  //ボタンによって画面遷移先を変える
  //formaction
  $view .= "<input class='button' type='submit' formaction='update_confirm.php' value='　　変更する　　'>";
  $view .= "<input class='delete_button' type='submit' formaction='delete.php' value='このタスクを削除する'>";
  $view .= "<hr>";
  $view .= "</form>";
  $view .= "</div>";
?>
  
<!-- チャット内容の表示エリア -->
<div><?= $view ?></div>


</body>
</html>
