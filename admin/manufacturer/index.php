<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/magicquotes.inc.php';

//Добавить нового производителя

if (isset($_GET['add']))
{
  $pageTitle = 'Новый производитель';
  $action = 'addform';
  $name = '';
  $email = '';
  $id = '';
  $button = 'Добавить прозводителя';

  include 'form.html.php';
  exit();
}

if (isset($_GET['addform']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try
  {
    $sql = 'INSERT INTO manufacturer SET
        name = :name';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при добавлении производителя.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}


//Редактировать

if (isset($_POST['action']) and $_POST['action'] == 'Редактировать')
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try
  {
    $sql = 'SELECT id, name FROM manufacturer WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка получения сведений о производителе.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Редактор производителей приборов';
  $action = 'editform';
  $name = $row['name'];
  $id = $row['id'];
  $button = 'Сохранить изменения';

  include 'form.html.php';
  exit();
}

if (isset($_GET['editform']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try
  {
    $sql = 'UPDATE manufacturer SET
        name = :name
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при редактирование производителя.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

//Удаление производителя

if (isset($_POST['action']) and $_POST['action'] == 'Удалить')
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  // Получить приборов, принадлежащих производителю
  try {
    $sql = 'SELECT id FROM devicetype WHERE manufacturerid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  } catch (PDOException $e) {
    $error = 'Ошибка при получении списка приборов.';
    include 'error.html.php';
    exit();
  }

  $result = $s->fetchAll();

  if (empty($result))
  {
    // Удаление производителя
    try
    {
      $sql = 'DELETE FROM manufacturer WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':id', $_POST['id']);
      $s->execute();
    }
    catch (PDOException $e)
    {
      $error = 'Ошибка удаления производителя.';
      include 'error.html.php';
      exit();
    }
  } else {
    $error = 'Нельзя удалить производителя у которого есть подчиненные приборы.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// Вывод списка контролеров

include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try
{
  $result = $pdo->query('SELECT id, name FROM manufacturer');
}
catch (PDOException $e)
{
  $error = 'Ошибка вывода производителей из базы данных!';
  include 'error.html.php';
  exit();
}
foreach ($result as $row) {
  $manufacturers[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'manufacturer.html.php';