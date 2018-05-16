<?php
header('X-FRAME-OPTIONS: SAMEORIGIN');
require_once 'h.php';
require_once 'database_conf.php';
session_start();



if(isset($_POST['submit'])){

if($_POST['id'] == ""){
$error ="入力しろよカス";
    }

else{

try {
   $db = new PDO($dsn, $dbUser, $dbPass);
   $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $sql = 'SELECT * FROM user WHERE num=:num';
   $prepare = $db->prepare($sql);
   $prepare->bindValue(':num',h($_POST["id"]), PDO::PARAM_STR);
   $prepare->execute();
   $result = $prepare->fetchAll(PDO::FETCH_OBJ);


   foreach ($result as $row) {

   $namekk= "{$row->name}";
   $passkk= "{$row->default_ip}";
   $emailkk= "{$row->email}";

   }
if( $namekk == ""){
$error="お前はお呼びでないみたいだな。";
}else{
$acount =true;
}
 } catch (PDOException $e) {
   echo 'ERROR';
 }




//NextStep
if($acount ==true){
$bip =h($_SERVER['REMOTE_ADDR']);
$ip = str_replace('.', '', $bip);

if ($passkk == $ip){
      session_regenerate_id(true);
      $_SESSION['login'] = true;
      $_SESSION['name'] = h($namekk);
      header('Location: https://example.com/userpanel/');
}

else{

try {
  $db = new PDO($dsn, $dbUser, $dbPass);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $sql = 'SELECT * FROM ip_table WHERE name=:name';

  $prepare = $db->prepare($sql);
  $prepare->bindValue(':name',h($namekk), PDO::PARAM_STR);
  $prepare->execute();
  $result = $prepare->fetchAll(PDO::FETCH_OBJ);

   foreach ($result as $row) {

   $passkkk= "{$row->ip}";
   $emailkkk= "{$row->email}";

   }
if($passkkk == $ip){

      session_regenerate_id(true);
      $_SESSION['login'] = true;
      $_SESSION['user'] = h($namekk);
      header('Location: https://example.com/userpanel');

}else{
      $newip=true;

}

# エラーが発生した場合、PDOException例外がスローされるのでキャッチします。
} catch (PDOException $e) {
  echo 'ERROR';
}


if ($newip == true){



$key = "ABC";
#You must change this key generater HAHAHA

  try {
  $db = new PDO($dsn, $dbUser, $dbPass);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $sql = 'INSERT INTO kari_ip(kew,ip,name) VALUES (:key,:ip,:name)';
  $prepare = $db->prepare($sql);
  $prepare->bindValue(':key',$key, PDO::PARAM_STR);
  $prepare->bindValue(':ip',$ip, PDO::PARAM_STR);
  $prepare->bindValue(':name',h($namekk), PDO::PARAM_STR);
  $prepare->execute();
} catch (PDOException $e) {
  echo 'ERROR';
}




mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to      = h($emailkk);
$subject = 'You are Chicken Right?';
$message = 'https://example.com/confirm.php?key='.$key;
$headers = 'From: newloginlocation@example.com' . "\r\n";

mb_send_mail($to, $subject, $message, $headers);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="stylesheet" href="https://example.com/css/styles.css">
<title>Login</title>
</head>
<div class="page">
<body>
<div class="main">
  <h1>I send mail just now</h1>
<h2>Check both the Junk E-mail folder and the normal mail folder</h2>
</div>
</body>
</div>
</html>
<?


}
else{}

  }


}}}
else{}


if ($_SESSION['auth'] !== true) {
if($newip !==true){
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="stylesheet" href="https://example.com/css/styles.css">
<title>Login now!!! Yeah!!!!</title>
</head>
<div>
<body>
<div class="main">
  <h1>Login</h1>
  <?php
    echo '<p style="color:red;">' . h($error) . '</p>';
  ?>
  <form action="login.php" method="post">
    <dl>
      <dt><label for="id">ID：</label></dt>
      <dd><input type="text" name="id" id="id" value=""></dd>
    </dl>

    <input type="submit" name="submit" id="submit" value="Login">
  </form>

</div>
</body>
</div>
</html>
<?php
  exit();
}}
?>