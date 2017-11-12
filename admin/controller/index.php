<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/magicquotes.inc.php';

//Добавить нового контролера

if (isset($_GET['add']))
{
  $pageTitle = 'Новый контролер';
  $action = 'addform';
  $name = '';
  $email = '';
  $id = '';
  $button = 'Добавить контролера';

  include 'form.html.php';
  exit();
}

if (isset($_GET['addform']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try
  {
    $sql = 'INSERT INTO controller SET
        name = :name,
        email = :email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':email', $_POST['email']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при добавлении контролера.';
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
    $sql = 'SELECT id, name, email FROM controller WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка получения сведений об контролере.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Редактор контролера';
  $action = 'editform';
  $name = $row['name'];
  $email = $row['email'];
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
    $sql = 'UPDATE controller SET
        name = :name,
        email = :email
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':email', $_POST['email']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при обновлении контролера.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

//Удаление контролера

if (isset($_POST['action']) and $_POST['action'] == 'Удалить')
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  // Получить предприятия, принадлежащие контролеру
  try {
    $sql = 'SELECT id FROM company WHERE controllerid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  } catch (PDOException $e) {
    $error = 'Ошибка при получении списка предприятий.';
    include 'error.html.php';
    exit();
  }

  $result = $s->fetchAll();

  if (empty($result))
  {
    // Удаление контролера
    try
    {
      $sql = 'DELETE FROM controller WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':id', $_POST['id']);
      $s->execute();
    }
    catch (PDOException $e)
    {
      $error = 'Ошибка удаления контролера.';
      include 'error.html.php';
      exit();
    }
  } else {
    $error = 'Нельзя удалить контролера у которого есть подчиненные предприятия.';
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
  $result = $pdo->query('SELECT id, name FROM controller');
}
catch (PDOException $e)
{
  $error = 'Ошибка вывода контролеров из базы данных!';
  include 'error.html.php';
  exit();
}
foreach ($result as $row) {
  $controllers[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'controller.html.php';