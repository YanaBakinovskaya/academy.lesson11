<?php

$connection = new PDO ('mysql:host=localhost; dbname=forum; charset=utf8', 'root', '');
$data = $connection->query('SELECT * FROM `forum`.`comments` WHERE moderation = "ok" ORDER BY date DESC');

if (isset($_POST['comment'])) {
  $comment = htmlspecialchars($_POST['comment']);
  $username = htmlspecialchars($_POST['login']);
  //  $comment = strip_tags($_POST['comment']);
  //  $username = strip_tags($_POST['login']);
  $time =  date('Y-m-d H:i:s');
  //  $connection->query("INSERT INTO `forum`.`comments` (`username`, `comment`, `date`) VALUES ('$username', '$comment', '$time')");
  $safe = $connection->prepare("INSERT INTO `forum`.`comments` SET username=:username, date='$time', comment=:comment");
  $arr = ['username'=>$username, 'comment'=>$comment];
  $safe->execute($arr);
  header("Location: index.php");

}
?>
<style>
  p {
    font-size: 26px;
  }
  input, textarea {
    margin-bottom: 20px;
  }
</style>

<p style="font-weight: bolder;">Форум любителей форумов</p>
<form method="POST">
  <input type="text" name="login" placeholder="Ваше имя" required> <br>
  <textarea name="comment" cols="30" rows="10" placeholder="Ваше сообщение" required></textarea><br>
  <input type="submit">
</form>
<hr>
<p style="font-weight: bolder;">Сообщения уважаемых пользователей</p>
<p style="font-weight: bolder; font-size: 16px;">Все сообщения проходят модерацию</p>


<?php if ($data) {foreach ($data as $key) { ?>

<div style="font-size: 16px; margin: auto">
  <?php echo $key['date'] .' ' .$key['username'].' ' .'написал'.' '.$key['comment']; ?>
  <hr>
</div>

<?php }} ?>


