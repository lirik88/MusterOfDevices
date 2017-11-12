<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/formhelper.inc.php';

// Создание списков из таблиц справочников

$types = tableToArray('type');
$units = tableToArray('unit');
$manufacturers = tableToArray('manufacturer');



//Добавить нового контролера

if (isset($_GET['add']))
{
  $pageTitle = 'Новый прибор';
  $action = 'addform';
  $name = '';
  $intervalm = '';
  $minm = '';
  $maxm = '';
  $typeid = '';
  $unitid = '';
  $manufacturerid = '';
  $id = '';
  $button = 'Добавить прибор';

  include 'form.html.php';
  exit();
}

if (isset($_GET['addform']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try
  {
    $sql = 'INSERT INTO devicetype SET
        name = :name,
        intervalm = :intervalm,
	      minm = :minm,
			  maxm = :maxm,
			  typeid = :typeid,
			  unitid = :unitid,
			  manufacturerid = :manufacturerid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':intervalm', $_POST['intervalm']);
	  $s->bindValue(':minm', $_POST['minm']);
	  $s->bindValue(':maxm', $_POST['maxm']);
	  $s->bindValue(':typeid', $_POST['typeid']);
	  $s->bindValue(':unitid', $_POST['unitid']);
	  $s->bindValue(':manufacturerid', $_POST['manufacturerid']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при добавлении прибора.';
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
    $sql = 'SELECT id, name, intervalm, minm, maxm, typeid,
 						unitid, manufacturerid FROM devicetype WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка получения данных о приборе.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Редактор прибора';
  $action = 'editform';
  $name = $row['name'];
	$intervalm = $row['intervalm'];
	$minm = $row['minm'];
	$maxm = $row['maxm'];
	$typeid = $row['typeid'];
	$unitid = $row['unitid'];
	$manufacturerid = $row['manufacturerid'];
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
    $sql = 'UPDATE devicetype SET
        name = :name,
        intervalm = :intervalm,
        minm = :minm,
        maxm = :maxm,
        typeid = :typeid,
        unitid = :unitid,
        manufacturerid = :manufacturerid
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':intervalm', $_POST['intervalm']);
	  $s->bindValue(':minm', $_POST['minm']);
	  $s->bindValue(':maxm', $_POST['maxm']);
	  $s->bindValue(':typeid', $_POST['typeid']);
	  $s->bindValue(':unitid', $_POST['unitid']);
	  $s->bindValue(':manufacturerid', $_POST['manufacturerid']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при редактирования прибора.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

//Удаление прибора

if (isset($_POST['action']) and $_POST['action'] == 'Удалить')
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

	// Получить список поверок, принадлежащих прибору
	try {
		$sql = 'SELECT id FROM device WHERE devicetypeid = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	} catch (PDOException $e) {
		$error = 'Ошибка при получении списка поверок.';
		include 'error.html.php';
		exit();
	}

	$result = $s->fetchAll();

	if (empty($result))
	{
		// Удаление производителя
		try
		{
			$sql = 'DELETE FROM devicetype WHERE id = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->execute();
		}
		catch (PDOException $e)
		{
			$error = 'Ошибка удаления прибора.';
			include 'error.html.php';
			exit();
		}
	} else {
		$error = 'Нельзя удалить прибор у которого есть подчиненные поверки.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

// Вывод списка приборов

include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try
{
  $result = $pdo->query('SELECT id, name, minm, maxm, typeid FROM devicetype');
}
catch (PDOException $e)
{
  $error = 'Ошибка вывода приборов из базы данных!';
  include 'error.html.php';
  exit();
}
foreach ($result as $row) {
  $devicetypes[] = array('id' => $row['id'], 'name' => $row['name'],
                    'minm' => $row['minm'],'maxm' => $row['maxm'], 'typeid' => $row['typeid']);
}
$devicetypes = array_msort($devicetypes, array('typeid' => SORT_ASC, 'name' => SORT_ASC));

include 'devicetype.html.php';