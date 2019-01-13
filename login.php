<?php
session_start();
$connection = new PDO('mysql:host=localhost; dbname=forum; charset=utf8', 'root', '');
$data = $connection->query('SELECT * FROM `forum`.`admin`');

if ($_POST['login']) {
  foreach ($data as $log) {
    if ($_POST['login'] == $log['login'] && $_POST['password'] == $log['password']) {
      $_SESSION['login'] = $_POST['login'];
      $_SESSION['password'] = $_POST['password'];
      header("Location: admin.php");
    }
  }
}


?>
<style>
  body {
    margin: 200px 300px;
  }
  input, p {
    font-size: 30px;
    margin: 10px;
  }
</style>
<form method="POST">
  <p>Вход в админку</p>
  <input type="text" name="login" placeholder="Логин" required> <br>
  <input type="password" name="password" placeholder="Пароль" required> <br>
  <input type="submit">
</form>