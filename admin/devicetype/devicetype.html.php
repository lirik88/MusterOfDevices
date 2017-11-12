<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Справочник приборов</title>
  </head>
  <body>
    <h1>Справочник приборов</h1>
    <p><a href="..">На главную</a></p>
    <p><a href="?add">Добавить новый прибор</a></p>
    <table>
      <?php if (!empty($devicetypes)): ?>
          <?php foreach ($devicetypes as $devicetype): ?>
	            <tr>
	              <form action="" method="post">
	                <td>
	                  <span><?= htmlentities($devicetype['name']); ?>
		                  <?php if($devicetype['typeid'] !== '2') : ?>
			                  (<?= htmlentities($devicetype['minm']); ?>-
			                  <?= htmlentities($devicetype['maxm']); ?>)
		                  <?php endif; ?>
	                  </span>
	                </td>
		            <td>
	                  <input type="hidden" name="id" value="<?= $devicetype['id']; ?>">
	                  <input type="submit" name="action" value="Редактировать">
	                  <input type="submit" name="action" value="Удалить">
	                </td>
	              </form>
	            </tr>
          <?php endforeach; ?>
      <?php endif; ?>
    </table>
  </body>
</html>
