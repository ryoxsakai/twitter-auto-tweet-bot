<?php
// twitteroauth.phpを読み込む。パスはあなたが置いた適切な場所に変更してください
require_once("twitteroauth.php");

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

// home_timelineの取得。TwitterからXML形式が返ってくる
$req = $to->OAuthRequest("http://api.twitter.com/1/statuses/home_timeline.xml","GET",array("count"=>"50"));

// XML文字列をオブジェクトに代入する
$xml = simplexml_load_string($req);

// foreachで呟きの分だけループする
foreach($xml->status as $status){
      $status_id = $status->id; // 呟きのステータスID
      $text = $status->text; // 呟き
      $user_id = $status->user->id; // ユーザーナンバー
      $screen_name = $status->user->screen_name; // ユーザーID（いわゆる普通のTwitterのID）
      $name = $status->user->name; // ユーザーの名前（HNなど）
      echo "<p><b>".$screen_name." / ".$name."</b> <a href=\"http://twitter.com/".$screen_name."/status/".$status_id."\">この呟きのパーマリンク</a><br />\n".$text."</p>\n";
}
?>