<?php
session_start();
if (!$_SESSION['login'] || !$_SESSION['password']) {
  header("Location: login.php");
  die();
}

if ($_POST['unlogin']) {
  session_destroy();
  header("Location: login.php");
}
if (count($_POST) > 0) {
  header("Location: admin.php");
}
$connection = new PDO ('mysql:host=localhost; dbname=forum; charset=utf8', 'root', '');
$data = $connection->query('SELECT * FROM `forum`.`comments` WHERE moderation = "new" ORDER BY date DESC');
?>



<h1>Админка злобного админа</h1>

<form method="POST">
  <?php foreach ($data as $key) { ?>
  <select name="<?=$key['id']?>" id="<?=$key['id']?>">
    <option value="ok">ОК</option>
    <option value="rejected">ОТКЛОНИТЬ</option>
  </select>
  <label for="<?=$key['id']?>">
    <?=$key['username'] . ' оставил комментарий "' . $key['comment'] . "\"<br>"?>
  </label>
  <?php } ?>
  <button>Модерировать</button>
</form>


<form method="POST">
  <input type="submit" name="unlogin" value="Выйти из админки">
</form>


<?php
echo "<pre>";
var_dump($_POST);

foreach ($_POST as $num=>$checked) {
  if ($checked == 'ok') {
    $connection->query("UPDATE `forum`.`comments` SET moderation='ok' WHERE id=$num");
  } else {
    $connection->query("UPDATE `forum`.`comments` SET moderation='rejected' WHERE id=$num");
  }

}