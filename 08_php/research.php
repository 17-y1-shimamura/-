<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>検索結果</title>
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
    <a href="insert.php">タスクを新規登録</a>
    </li>
    <li>
      <a href="menu.php">トップ画面に戻る</a>
    </li>
  </ul>
</div>

<?php
  //0. POSTデータ取得
  $keyword = $_POST['keyword'];
  $staff = $_POST['staff'];
  // 期限間近か期限超過
  $deadline = $_POST['deadline'];
  $importance = $_POST['importance'];

  //デバッグ
  // echo $keyword;
  // echo $deadline;
  // echo $importance;

?>

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

  //２．SQL文を用意(SELECT文)
  $sql = ""; //SQL文
  $sql .= "SELECT * FROM task_table ";

  //条件分岐のフラグ(もうすでにWHERE句が挿入されていればfalse)
  $isWhere = true;

  //keywordが空でない場合
  if (empty($keyword)==false) {
    $isWhere = false;
    $sql.="WHERE ";
    $sql.=" (title LIKE '%".$keyword."%'";
    $sql.="  OR body LIKE '%".$keyword."%')";
  }

  //staffが空でない場合
  if (empty($staff)==false) {
    // WHERE句が挿入されていない場合($isWhereがtrueの場合)は挿入する
    if($isWhere) {
      $sql.="WHERE ";
      $sql.=" STAFF LIKE'%".$staff."%'";
      $isWhere = false;
    } else {
      $sql.=" AND STAFF LIKE'%".$staff."%'";
    }
  }

  //deadlineが「指定なし」以外の場合
  if ($deadline != "指定なし") {
    // WHERE句が挿入されていない場合($isWhereがtrueの場合)は挿入する
    if($isWhere) {
      //WHERE句挿入
      $sql.=" WHERE ";
      $isWhere = false;
    } else {
      //AND挿入
      $sql.=" AND ";
    }

    if ($deadline == "期限間近") {
      $sql.=" deadline > CURRENT_DATE AND deadline < (DATE_ADD(CURRENT_DATE, INTERVAL 1 WEEK)) "; 
    } else if($deadline == "期限超過"){
      $sql.=" deadline < CURRENT_DATE" ;
    }
  }
  
  // 重要度が指定なし以外の場合
  if ($importance != "指定なし") {
    // WHERE句が挿入されていない場合($isWhereがtrueの場合)は挿入する
    if($isWhere) {
      //WHERE句挿入
      $sql.=" WHERE ";
      $isWhere = false;
    } else {
      //AND挿入
      $sql.=" AND ";
    }
    $sql.=" importance ='".$importance."'"; 
  }

  //SQLの最後にORDER BYをつける
  $sql .= " ORDER BY deadline ASC ";

  // 実行結果がtrueもしくはfalseで返る
  $stmt = $pdo->prepare($sql);
  $status = $stmt->execute();

  //デバッグ
  // var_dump($stmt);
  // echo $stmt->rowCount();
  // var_dump($status);

//３．データ表示
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

//結果メッセージ
$message = "";
if ($stmt->rowCount()==0) {
  //0件ヒットの時
  $message .= "<p class='error_message'>以下の検索条件にあてはまるタスクはありません。<br>";
  $message .= "キーワード：「".$keyword."」 / 担当者：「".$staff."」 / 期限：「".$deadline."」 / 重要度：「".$importance."」</p>";
} else {
  //成功時 
  $message = "<p class='success_message'>以下の検索条件で".$stmt->rowCount()."件ヒットしました。<br>";
  $message .= "キーワード：「".$keyword."」 / 担当者：「".$staff."」 / 期限：「".$deadline."」 / 重要度：「".$importance."」</p>";
}

?>
<?php echo $message; ?>
<div class=" jumbotron"><?= $view ?></div>
<p></p>
<form action="excel_export.php" method="POST">
<input class="button" type="submit" value="検索結果をエクセルで書き出す">
</form>



</body>
</html>