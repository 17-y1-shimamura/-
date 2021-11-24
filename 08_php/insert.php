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

<!-- 登録フォーム -->
<form method="post" action="insert_confirm.php">
  <div class="insert_form">
   <fieldset>
    <legend></legend>
    <legend>担当者：<input type="text" name="staff"><br>
    </legend>
     <label>重要度：<select name="importance">
		    <option value="!!!">!!!</option>
		    <option value="!!">!!</option>
        <option value="!">!</option>
	   </select></label><br>
     <label>タスクのタイトル：<input type="text" name="title"></label><br>
     <!-- <label>タスクの内容：</label><br> -->
     <textarea name="body" rows="4" cols="40"></textarea><br>
     <label>期限：<input type="date" min="2020-01-01" max="2030-01-01" name="deadline"></input></label><br>
     <input class="button" type="submit" value="タスクを新規登録">
    </fieldset>
  </div>
</form>


</body>
</html>


<?php

//2. DB接続します
// try {
//   //Password:MAMP='root''
//   // mysql:データベース名,root,rootにはそれぞれユーザー名とパスワードが入る
//   $pdo = new PDO('mysql:dbname=ymt_db;charset=utf8;host=localhost','root','root');
// } catch (PDOException $e) {
//   exit('DBConnectError:'.$e->getMessage());
// }

// //３．データ登録SQL作成(INSERT文)
// // $name→:name $body→:body(バインド変数)
// $stmt = $pdo->prepare("INSERT INTO chat_table(id, name, body, indate) 
// VALUES (null,:name,:body,sysdate())");

// //バインド変数を変数に変換
// $stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':body', $body, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// //DBにSQL文を実行
// $status = $stmt->execute();

// //４．データ登録処理後
// if($status==false){
//   //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
//   $error = $stmt->errorInfo();
//   exit("ErrorMassage:".$error[2]);
// }else{
//   //５．index.phpへリダイレクト
//   header('Location: index.php');//ヘッダーロケーション（リダイレクト）

// }
?>
