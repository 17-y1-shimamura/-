<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TOP</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link href="css/style.css" rel="stylesheet">
  <!-- <style>div{padding: 10px;font-size:16px;}</style> -->
</head>
<body>

<!-- Main[Start] -->
<!-- methodはpostかget、actionは飛ぶページ(画面) -->
<!-- getはURLに入力値を入れて遷移、postはユーザーに分からないよう裏でもって遷移 -->
<div class="menu_header">
  <h1>タスク管理システム</h1>
  <ul class="menu_header_list">
    <li class="menu_header_list_insert">
      <a href="menu.php">画面を更新</a>
    </li>
    <li class="menu_header_list_insert">
      <a href="insert.php">タスクを新規登録</a>
    </li>
  </ul>
</div>

<!-- 検索フォーム -->
<form method="post" action="research.php">
  <div class="reserch_form">
   <fieldset>
    <legend></legend>
     <label>キーワード：<input type="text" name="keyword" size="30"></label><br>
     <label>担当：<input type="text" name="staff" size="15"></label><br>
     <label>期限：
      <select name="deadline">
      <option value="指定なし">指定なし</option>
		    <option value="期限間近">期限間近</option>
		    <option value="期限超過">期限超過</option>
	    </select>
     </label>
     <label> 重要度：
       <select name="importance">
       <option value="指定なし">指定なし</option>
		    <option value="!!!">!!!</option>
		    <option value="!!">!!</option>
        <option value="!">!</option>
	   </select></label>
     <input class="button" type="submit" value="　検索　">
    </fieldset>
  </div>
</form>

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
// 未着手か着手中のみ表示
// 日付を昇順でソート
$stmt = $pdo->prepare("SELECT * FROM task_table where status = '未着手' or status = '着手中' ORDER BY deadline ASC" );
// 実行結果がtrueもしくはfalseで返る
$status = $stmt->execute();

//３．データ表示
$view="";//空っぽの変数viewを作成（ここにHTMLタグを追加していく）

if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

 } else{
  //「2.」で取得したデータの数だけ自動でループしてくれるwhile文
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    // .=は追加(+=と同じ)
    // .が+と同じ機能を果たす
    // カラム名で指定
    // 日時
    $view .= "<div class='jumbotron'>";
    $view .= "<form action='update.php' method='POST'>";
    // 期限が超過している場合は赤字でメッセージ
    $today = date('Y-m-d');
    $today = strtotime($today);
    $day = strtotime($result['deadline']);
    //echo $today;
    //echo $day;
    if (($day-$today) < 0) {
      $view .= "<p class='error_message'>！期限が過ぎています！</p>";
    }
    $view .= "担当者：<input type='text' name ='staff' value='".$result['staff']."' size='15'readonly>";
    $view .= " 重要度：<input type='text' name='importance' value='".$result['importance']."'size='1' readonly>";
    $view .= "<br>";
    $view .= "タスク名：<input type='text' name='title' value='".$result['title']."' size='45' readonly>";
    $view .= "<br>";
    // $view .= "内容：";
    // $view .= "<br>";
    $view .= "<textArea name='body' name='body' rows='3' cols='60' readonly>".$result['body']."</textArea>";
    $view .= "<br>";
    $view .= "タスクの進捗状況：<input type='text' name='status' value='".$result['status']."'size='10' readonly>";
    $view .= " 期限：<input type='date' name='deadline' value='".$result['deadline']."' size='10' readonly>";
    $view .= "<input type='hidden' name='id' value='".$result['id']."'> <br>";
    $view .= "<input class='button' type='submit' value='詳細確認・変更はこちら'>";
    $view .= "</div>";
    $view .= "<hr>";
    $view .= "</form>";
  }
}
?>

<!-- タスク一覧の表示 -->
<div><h2>■未完了のタスク:<?php echo $stmt->rowCount();?>件</h2></div>
<div class=" jumbotron"><?= $view ?></div>

</body>
</html>
