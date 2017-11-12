<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Справочник поверок</title>
  </head>
  <body>
    <h1>Справочник поверок</h1>
    <p><a href="..">На главную</a></p>
    <p><a href="?add">Добавить новую поверку</a></p>
    <table>
      <?php if (!empty($devices)): ?>
          <?php foreach ($devices as $device): ?>
            <tr>
              <form action="" method="post">
                <td>
	                <?= htmlentities($device['company']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
	                <?= htmlentities($device['name']); ?>
                </td>
	            <td>
                    <input type="hidden" name="id" value="<?= $device['id']; ?>">
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
