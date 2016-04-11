<?php
// twitteroauth.phpを読み込む。パスはあなたが置いた適切な場所に変更してください
require_once("twitteroauth.php");

//★基本設定/////////////////////////////////////////////////////////

$conn = mysql_connect('mysql533.phy.lolipop.jp', 'LA11978636', 'RrS3KvR6');
mysql_select_db('LA11978636-database',$conn);
mysql_set_charset('utf8',$conn);

//☆/////////////////////////////////////////////////////////////////

  $sql="SELECT * from tweetbot_x93mg order by time asc limit 1";
  $query = mysql_query($sql,$conn);
  while ($row = mysql_fetch_array($query, MYSQL_BOTH)) {
    $content = $row['content'];
    $code = $row['code'];
  }
  
  $sql="DELETE from tweetbot_x93mg where code = {$code}";
  $query = mysql_query($sql,$conn);


// Consumer keyの値
$consumer_key = "D58otH4PppJTcTaB1vordw";
// Consumer secretの値
$consumer_secret = "sPkSa8hGjd8S9VgYIFi8bwcGmYfZvJM8wzROUw9YcNc";
// Access Tokenの値
$access_token = "146090504-gq9W1igFE6B8sUTIhF936dP4Cgv7VeEbChmqXuBj";
// Access Token Secretの値
$access_token_secret = "aaL6ex66jfkQNbBa1K5VEYU9FgG0nZ7mPdOmW3NZ5WM";

// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

// TwitterへPOSTする。パラメーターは配列に格納する
// in_reply_to_status_idを指定するのならば array("status"=>"@hogehoge reply","in_reply_to_status_id"=>"0000000000"); とする。
$ok = truefalse(50,50);
if($ok){
  $req = $to->OAuthRequest("http://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>"{$content}"));
  // Twitterから返されたJSONをデコードする
  $result = json_decode($req);
  // JSONの配列（結果）を表示する
  header("Content-type: text/html; charset=utf-8");
  echo "<pre>";
  var_dump($result);
}else{
  echo 'FALSE';
}

// TwitterへPOSTするときのパラメーターなど詳しい情報はTwitterのAPI仕様書を参照してください

function truefalse($trueperc = 50, $falseperc = 50) {
	if (($trueperc+$falseperc) !== 100) {
		echo 'Error invalid percentages';
	}
	$perc = rand(1,100);
	if ($perc < $trueperc) {
		return true;
	}
	elseif ($perc > $falseperc) {
		return false;
	}
}
?>