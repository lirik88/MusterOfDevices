<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/magicquotes.inc.php';

// Построить список контролеров

include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try
{
  $result = $pdo->query('SELECT id, name FROM controller');
}
catch (PDOException $e)
{
  $error = 'Ошибка выбора списка контролеров.';
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $controllers[] = array('id' => $row['id'], 'name' => $row['name']);
}

//Добавить нового контролера

if (isset($_GET['add']))
{
  $pageTitle = 'Новое предприятие';
  $action = 'addform';
  $name = '';
  $controllerid = '';
  $id = '';
  $button = 'Добавить предприятие';



  include 'form.html.php';
  exit();
}

if (isset($_GET['addform']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try
  {
    $sql = 'INSERT INTO company SET
        name = :name,
        controllerid = :controllerid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':controllerid', $_POST['controllerid']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при добавлении предприятия.';
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
    $sql = 'SELECT id, name, controllerid FROM company WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка получения данных о предприятии.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Редактор контролера';
  $action = 'editform';
  $name = $row['name'];
  $controllerid = $row['controllerid'];
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
    $sql = 'UPDATE company SET
        name = :name,
        controllerid = :controllerid
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':controllerid', $_POST['controllerid']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при редактирования предприятия.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

//Удаление предприятия

if (isset($_POST['action']) and $_POST['action'] == 'Удалить')
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  // Удаление приборов, принадлежащих предприятию
  try
  {
    $sql = 'DELETE FROM device WHERE companyid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка удаления приборов, принадлежащих предприятию.';
    include 'error.html.php';
    exit();
  }

  // Удаление предприятий
  try
  {
    $sql = 'DELETE FROM company WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка удаления предприятия.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// Вывод списка предприятий

include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try
{
  $result = $pdo->query('SELECT id, name FROM company');
}
catch (PDOException $e)
{
  $error = 'Ошибка вывода предприятий из базы данных!';
  include 'error.html.php';
  exit();
}
foreach ($result as $row) {
  $companies[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'company.html.php';