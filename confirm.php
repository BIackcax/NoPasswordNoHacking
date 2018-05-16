<?php
require_once 'database_conf.php';
require_once 'h.php';
require_once 'funct.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?
head();

nav();
?>
<?php

if (!isset($_GET['key'])) {
  echo '<script>
alert("Oh...so...you cant access this directory pleas back to home"); 
window.location.href = "http://example.com/";
</script>';
      header('Location:http://example.com/');
//exit();
}

else{
$s= h($_GET["key"]);

try {
  $db = new PDO($dsn, $dbUser, $dbPass);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT * FROM kari_ip WHERE kew=:kes';
  $prepare = $db->prepare($sql);
  $prepare->bindValue(':kes',$s, PDO::PARAM_STR);
  $prepare->execute();
  $result = $prepare->fetchAll(PDO::FETCH_OBJ);

  foreach ($result as $row) {
$ip= h("{$row->ip}");
$name= h("{$row->name}");
$ti= h("{$row->time}");

  }
if($name ==""){

  echo '<script>
alert("Oh...so...you cant access this directory pleas back to home"); 
window.location.href = "http://example.com/";
</script>';
      header('Location:http://example.com/');
}
else{

$_SESSION['confirm']=true;

}
} catch (PDOException $e) {
  echo 'ERROR';
}

if($_SESSION['confirm'] == true){

  try {
  $db = new PDO($dsn, $dbUser, $dbPass);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'INSERT INTO ip_table(name,ip) VALUES (:key,:ip)';
  $prepare = $db->prepare($sql);
  $prepare->bindValue(':key',$name, PDO::PARAM_STR);
  $prepare->bindValue(':ip',$ip, PDO::PARAM_STR);
  $prepare->execute();
} catch (PDOException $e) {
  echo 'ERROR';
}

try {
  $db = new PDO($dsn, $dbUser, $dbPass);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'DELETE FROM kari_ip WHERE kew = :id';
  $prepare = $db->prepare($sql);
  $prepare->bindValue(':id', h($_GET["key"]), PDO::PARAM_STR);
  $result = $prepare->execute();

} catch (PDOException $e) {
  echo 'エラーが発生しました。内容: ' . h($e->getMessage());
}

      session_regenerate_id(true);
      $_SESSION['auth'] = true;
      $_SESSION['username'] = h($namekk);
  echo '<script>
alert("ログインが成功しました。"); 
window.location.href = "http://example.com/userpanel/";
</script>';
      header('Location: http://example.com/userpanel/');
}


}
?>