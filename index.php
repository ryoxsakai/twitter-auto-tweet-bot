<?php

//★基本設定/////////////////////////////////////////////////////////

$conn = mysql_connect('mysql533.phy.lolipop.jp', 'LA11978636', 'RrS3KvR6');
mysql_select_db('LA11978636-database',$conn);
mysql_set_charset('utf8',$conn);

//☆/////////////////////////////////////////////////////////////////

if($_POST['key']=='edit'){
  $time = time();
  $sql = "UPDATE tweetbot_x93mg SET content = '{$_POST['content']}', time = '{$time}' where code = '{$_POST['code']}'";
  $query = mysql_query($sql,$conn);
  header("Location: ?flag=list");
}elseif($_POST['key']=='reg'){
  $time = time();$content = $_POST['content'];
  $sql = "INSERT INTO tweetbot_x93mg (content,time) VALUES ('{$content}','{$time}')";
  $query = mysql_query($sql,$conn);
  header("Location: ?flag=list");
}


if(!isset($_GET["flag"])){
  $title = "つぶやきを登録";
  $body  = <<< END
    <form method="post">
      <textarea id="textbox" name="content"></textarea>
      <input type="submit" value ="登録" />
      <input type="hidden" name="key" value="reg">
    </form>
END;
  $body .= "<div class='right'><a href='?flag=list'>一覧を表示</a></div>";
}
if(isset($_GET["flag"])&&$_GET["flag"]=="edit"){
  $code = $_GET['code'];
  $sql="SELECT * from tweetbot_x93mg where code = '{$code}'";
  $query = mysql_query($sql,$conn);
  $title = "つぶやきを編集";
  while ($row = mysql_fetch_array($query, MYSQL_BOTH)) {
    $time = date("y,m,d",$row['time']);
    $body = <<< END
    <form method="post">
      <textarea id="textbox" name="content">{$row['content']}</textarea>
      <input type="submit" value ="登録" />
      <input type="hidden" name="code" value="{$row['code']}">
      <input type="hidden" name="key" value="edit">
    </form>
END;
  $body .= "<div class=rig'ht'><a href='index.php'>つぶやきを登録</a> / <a href='?flag=list'>一覧を表示</a></div>";
  }
}
if(isset($_GET["flag"])&&$_GET["flag"]=="list"){
  $sql="SELECT * from tweetbot_x93mg order by time desc";
  $query = mysql_query($sql,$conn);
  $title = "一覧を表示";
  $body .= "<div class='right'><a href='index.php'>つぶやきを登録</a></div><hr>";
  while ($row = mysql_fetch_array($query, MYSQL_BOTH)) {
    $time = date("Y-m-d",$row['time']);$content = nl2br($row['content']);
    $body .= <<< END
      <b><a href="?flag=edit&code={$row['code']}">{$row['code']}</a></b>
      <p>{$content}</p>
      <i>{$time}</i><br>
      <a href="?flag=delete&code={$row['code']}">[×]</a>
      <hr>
END;
  }
  $body .= "<div class='right'><a href='index.php'>つぶやきを登録</a></div>";
}
if(isset($_GET["flag"])&&$_GET["flag"]=="delete"){
  $code = $_GET['code'];
  $sql="DELETE from tweetbot_x93mg where code = '{$code}'";
  $query = mysql_query($sql,$conn);
  header("Location: ?flag=list");
}
if(isset($_GET["flag"])&&$_GET["flag"]=="random"){
  $sql="SELECT * from tweetbot_x93mg order by rand() limit 1";
  $query = mysql_query($sql,$conn);
  $title = "ランダム表示テスト";
  while ($row = mysql_fetch_array($query, MYSQL_BOTH)) {
    $time = date("Y-m-d",$row['time']);
    $body .= <<< END
      <b><a href="?flag=edit&code={$row['code']}">{$row['code']}</a></b>
      <p>{$row['content']}</p>
      <i>{$time}</i>
      <hr>
END;
  $body .= "<div class='right'><a href='index.php'>つぶやきを登録</a></div>";
  }
}


?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link rel="apple-touch-icon" href="http://sakainote.com/picture/trademark.ico">
<meta http-equip="Content-Style-Type" content="text/css" />
<meta http-equip="pragma" content="no-cache" />
<meta http-equip="cache-control" content="no-cache" />
<meta http-equip="expires" content="-1" />
<meta name="description" content="x93mgの自動つぶやきシステム。" />
<meta name="keywords" content="x93mg,twitter" />
<meta name="robots" content="index,follow" />
<link rel=stylesheet type="text/css" href="style.css">
<style><?php echo $cssWrite; ?></style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="jquery.elastic.js"></script>
<script type="text/javascript" src="charCount.js"></script>
<script>
$(document).ready(function(){
      $('textarea').elastic();
      $('#textbox').charCount();
});
</script>
<title>x93mgBOT</title>
</head>
<body>
<h2><?php echo $title; ?></h2>
<?php echo $body; ?>
</body>
</html>