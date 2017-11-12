<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/formhelper.inc.php';

// Создание списков из таблиц справочников

$companies = tableToArray('company');

include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
try {
	$result = $pdo->query("SELECT id, name, minm, maxm, typeid FROM devicetype");
} catch (PDOException $e) {
	$error = "Ошибка вывода списка devicetype.";
	include 'error.html.php';
	exit();
}

if(!empty($result)) {
	foreach ($result as $row) {
		$devicetypes[] = array('id' => $row['id'], 'name' => $row['name'],
		'minm' => $row['minm'], 'maxm' => $row['maxm'], 'typeid' => $row['typeid']);
	}
} else {
	$devicetypes[] = array('id' => '', 'name' => '', 'minm' => '', 'maxm' => '', 'typeid' => '');
}

$devicetypes = array_msort($devicetypes, array('typeid' => SORT_ASC, 'name' => SORT_ASC));


//Добавить нового контролера

if (isset($_GET['add']))
{
  $pageTitle = 'Новая поверка';
  $action = 'addform';
  $companyid = '';
  $devicetypeid = '';
  $number = '';
  $lastdate = '';
  $note = '';
  $id = '';
  $button = 'Добавить поверку';

  include 'form.html.php';
  exit();
}

if (isset($_GET['addform']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  $inter = getNextDate($_POST['devicetypeid']);

  try
  {
    $sql = "INSERT INTO device SET
        companyid = :companyid,
        devicetypeid = :devicetypeid,
	      number = :number,
			  lastdate = :lastdate,
			  nextdate = ADDDATE(:lastdate, INTERVAL $inter YEAR ),
			  note = :note";
    $s = $pdo->prepare($sql);
    $s->bindValue(':companyid', $_POST['companyid']);
    $s->bindValue(':devicetypeid', $_POST['devicetypeid']);
	  $s->bindValue(':number', $_POST['number']);
	  $s->bindValue(':lastdate', $_POST['lastdate']);
	  $s->bindValue(':note', $_POST['note']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при добавлении поверки.';
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
    $sql = 'SELECT id, companyid, devicetypeid, number, lastdate, note
 						FROM device WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка получения данных о поверки.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Редактор прибора';
  $action = 'editform';
	$companyid = $row['companyid'];
	$devicetypeid = $row['devicetypeid'];
	$number = $row['number'];
	$lastdate = $row['lastdate'];
	$note = $row['note'];
  $id = $row['id'];
  $button = 'Сохранить изменения';

  include 'form.html.php';
  exit();
}

if (isset($_GET['editform']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

	$inter = getNextDate($_POST['devicetypeid']);

  try
  {
    $sql = "UPDATE device SET
        companyid = :companyid,
        devicetypeid = :devicetypeid,
        number = :number,
        lastdate = :lastdate,
        nextdate = ADDDATE(:lastdate, INTERVAL $inter YEAR ),
        note = :note
        WHERE id = :id";
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':companyid', $_POST['companyid']);
    $s->bindValue(':devicetypeid', $_POST['devicetypeid']);
	  $s->bindValue(':number', $_POST['number']);
	  $s->bindValue(':lastdate', $_POST['lastdate']);
	  $s->bindValue(':note', $_POST['note']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка при редактирования поверки.';
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

  // Удаление поверки
  try
  {
    $sql = 'DELETE FROM device WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка удаления поверки.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// Вывод списка поверок

include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try
{
  $result = $pdo->query('SELECT device.id AS id, company.name AS company, devicetype.name AS name
																		FROM device
																		INNER JOIN company ON companyid = company.id 
																		INNER JOIN devicetype ON devicetypeid = devicetype.id');
}
catch (PDOException $e)
{
  $error = 'Ошибка вывода поверок из базы данных!';
  include 'error.html.php';
  exit();
}
foreach ($result as $row) {
  $devices[] = array('id' => $row['id'],
                        'company' => $row['company'],
                        'name' => $row['name']);
}

//$test = $result;
include 'device.html.php';