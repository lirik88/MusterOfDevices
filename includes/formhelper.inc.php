<?php
function tableToArray(string $nameTable)
{
	try
	{
		$pdo = new PDO('mysql:host=musterofdevices.dev;dbname=musterdb', 'root', '');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec('SET NAMES "utf8"');
	}
	catch (PDOException $e) {
		$error = 'Unable to connect to the database server.';
		include 'error.html.php';
		exit();
	}

	try {
		$result = $pdo->query("SELECT id, name FROM $nameTable");
	} catch (PDOException $e) {
		$error = "Ошибка вывода списка $nameTable.";
		include 'error.html.php';
		exit();
	}

	if(!empty($result)) {
		foreach ($result as $row) {
			$table[] = array('id' => $row['id'], 'name' => $row['name']);
		}
	} else {
		$table[] = array('id' => '', 'name' => '');
	}
	return $table;
}

function getNextDate (int $devicetypeid){

	try
	{
		$pdo = new PDO('mysql:host=musterofdevices.dev;dbname=musterdb', 'root', '');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec('SET NAMES "utf8"');
	}
	catch (PDOException $e) {
		$error = 'Unable to connect to the database server.';
		include 'error.html.php';
		exit();
	}

	try {
		$sql = 'SELECT intervalm FROM devicetype WHERE id = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $devicetypeid);
		$s->execute();
		$result = $s->fetch();
	}
		catch (PDOException $e) {
		$error = "Ошибка вывода межповерочного интервала.";
		include 'error.html.php';
		exit();
	}

	return (int)$result['intervalm'];
}

//Сортировка массива по ключу
function array_msort($array, $cols)
{
	$colarr = array();
	foreach ($cols as $col => $order) {
		$colarr[$col] = array();
		foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
	}
	$eval = 'array_multisort(';
	foreach ($cols as $col => $order) {
		$eval .= '$colarr[\''.$col.'\'],'.$order.',';
	}
	$eval = substr($eval,0,-1).');';
	eval($eval);
	$ret = array();
	foreach ($colarr as $col => $arr) {
		foreach ($arr as $k => $v) {
			$k = substr($k,1);
			if (!isset($ret[$k])) $ret[$k] = $array[$k];
			$ret[$k][$col] = $array[$k][$col];
		}
	}
	return $ret;

}